<?php
/**
 * Template Tags Module
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bear_TemplateTags' ) ) :

    /**
     * The template tags class
     */
    class Bear_TemplateTags {

        /**
         * An instance of bear
         *
         * @var object
         */
        private $bear;

        /**
         * An instance of this class
         *
         * @var object
         */
        private static $instance;

        /**
         * Get and Set Instance of the class
         *
         * @since 1.0.0
         * @return object an instance of this class
         */
        public static function instance()
        {
            if ( !isset(self::$instance) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Configure class
         *
         * @since 1.0.0
         * @param object $bear
         */
        public function config($bear)
        {
            $this->bear = $bear;
        }

        /**
         * Execute class
         *
         * @since 1.0.0
         */
        public function exec()
        {
            add_action( 'edit_category', array(&$this,
                'category_transient_flusher'
            ));
            add_action( 'save_post',     array(&$this,
                'category_transient_flusher'
            ));
        }

        /**
         * Prints HTML with meta information for the current post-date/time and author.
         *
         * @since 1.0.0
         */
        public function posted_on()
        {
            $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
            if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }

            $time_string = sprintf( $time_string,
                esc_attr( get_the_date( 'c' ) ),
                esc_html( get_the_date() ),
                esc_attr( get_the_modified_date( 'c' ) ),
                esc_html( get_the_modified_date() )
            );

            $posted_on = sprintf(
                esc_html_x( 'Posted on %s', 'post date', $this->bear->config_textdomain ),
                '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
            );

            $byline = sprintf(
                esc_html_x( 'by %s', 'post author', $this->bear->config_textdomain ),
                '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
            );

            echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

        }

        /**
         * Prints HTML with meta information for the categories, tags and comments.
         *
         * @since 1.0.0
         */
        public function entry_footer()
        {
            // Hide category and tag text for pages.
            if ( 'post' === get_post_type() ) {
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( esc_html__( ', ', $this->bear->config_textdomain ) );
                if ( $categories_list && $this->categorized_blog() ) {
                    printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', $this->bear->config_textdomain ) . '</span>', $categories_list ); // WPCS: XSS OK.
                }

                /* translators: used between list items, there is a space after the comma */
                $tags_list = get_the_tag_list( '', esc_html__( ', ', $this->bear->config_textdomain ) );
                if ( $tags_list ) {
                    printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', $this->bear->config_textdomain ) . '</span>', $tags_list ); // WPCS: XSS OK.
                }
            }

            if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                echo '<span class="comments-link">';
                /* translators: %s: post title */
                comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', $this->bear->config_textdomain ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
                echo '</span>';
            }

            edit_post_link(
                sprintf(
                    /* translators: %s: Name of current post */
                    esc_html__( 'Edit %s', $this->bear->config_textdomain ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                ),
                '<span class="edit-link">',
                '</span>'
            );
        }

        /**
         * Returns true if a blog has more than 1 category.
         *
         * @since 1.0.0
         * @return bool
         */
        public function categorized_blog()
        {
            if ( false === ( $all_the_cool_cats = get_transient( "{$this->bear->config_prefix}_categories" ) ) ) {
                // Create an array of all the categories that are attached to posts.
                $all_the_cool_cats = get_categories( array(
                    'fields'     => 'ids',
                    'hide_empty' => 1,
                    // We only need to know if there is more than one category.
                    'number'     => 2,
                ) );

                // Count the number of categories that are attached to the posts.
                $all_the_cool_cats = count( $all_the_cool_cats );

                set_transient( "{$this->bear->config_prefix}_categories", $all_the_cool_cats );
            }

            if ( $all_the_cool_cats > 1 ) {
                // This blog has more than 1 category so bear_categorized_blog should return true.
                return true;
            } else {
                // This blog has only 1 category so bear_categorized_blog should return false.
                return false;
            }
        }

        /**
         * Flush out the transients used in $_categorized_blog.
         *
         * @since 1.0.0
         */
        public function category_transient_flusher()
        {
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }
            // Like, beat it. Dig?
            delete_transient( "{$this->bear->config_prefix}_categories" );
        }

    }

endif;
