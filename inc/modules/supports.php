<?php
/**
 * Plugins Support Module
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bear_Supports' ) ) :

    /**
     * The plugins support class
     */
    class Bear_Supports {

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
            add_action( 'after_setup_theme', array( &$this,
                'jetpack_support'
            ));
        }

        /**
         * Jetpack setup function.
         *
         * @since 1.0.0
         * See: https://jetpack.com/support/infinite-scroll/
         * See: https://jetpack.com/support/responsive-videos/
         */
        public function jetpack_support()
        {
            // Add theme support for Infinite Scroll.
            add_theme_support( 'infinite-scroll', array(
                'container' => 'main',
                'render'    => array(&$this, 'infinite_scroll_render'),
                'footer'    => 'page',
            ));

            // Add theme support for Responsive Videos.
            add_theme_support( 'jetpack-responsive-videos' );
        }

        /**
         * Custom render function for Infinite Scroll.
         *
         * @since 1.0.0
         */
        public function infinite_scroll_render()
        {
            while ( have_posts() ) {
                the_post();
                if ( is_search() ) :
                    get_template_part( 'template-parts/content', 'search' );
                else :
                    get_template_part( 'template-parts/content', get_post_format() );
                endif;
            }
        }
    }

endif;
