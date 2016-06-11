<?php
/**
 * Base Module
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bear_Base' ) ) :

    /**
     * The base class
     */
    class Bear_Base {

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
                'setup'
            ));
            add_action( 'after_setup_theme', array( &$this,
                'content_width', 0
            ));
            add_action( 'widgets_init', array( &$this,
                'widgets_init'
            ));
            add_action( 'wp_enqueue_scripts', array( &$this,
                'register_scripts'
            ));
        }

        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * @since 1.0.0
         */
        public function setup()
        {

            // Make theme available for translation.
            load_theme_textdomain( $this->bear->config_textdomain, get_template_directory() . '/languages' );

            // Add default posts and comments RSS feed links to head.
            add_theme_support( 'automatic-feed-links' );

            // Let WordPress manage the document title.
            add_theme_support( 'title-tag' );

            // Enable support for Post Thumbnails on posts and pages.
            add_theme_support( 'post-thumbnails' );

            // This theme uses wp_nav_menu() in one location.
            register_nav_menus( array(
                'primary' => esc_html__( 'Primary', $this->bear->config_textdomain ),
            ));

            // Switch default core markup for search form, comment form, and comments
            // to output valid HTML5.
            add_theme_support( 'html5', array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ));

            // Enable support for Post Formats.
            add_theme_support( 'post-formats', array(
                'aside',
                'image',
                'video',
                'quote',
                'link',
            ));

            // Set up the WordPress core custom background feature.
            add_theme_support( 'custom-background', apply_filters( "{$this->bear->config_prefix}_custom_background_args", array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )));
        }

        /**
         * Set the content width in pixels, based on the theme's design and stylesheet.
         *
         * Priority 0 to make it available to lower priority callbacks.
         *
         * @since 1.0.0
         * @global int $content_width
         */
        public function content_width()
        {
            $GLOBALS['content_width'] = apply_filters( "{$this->bear->config_prefix}_content_width", 640 );
        }

        /**
         * Register widget area.
         *
         * @since 1.0.0
         */
        public function widgets_init()
        {
            register_sidebar( array(
                'name'          => esc_html__( 'Sidebar', $this->bear->config_textdomain ),
                'id'            => 'sidebar-1',
                'description'   => esc_html__( 'Add widgets here.', $this->bear->config_textdomain ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));
        }

        /**
         * Enqueue scripts and styles.
         *
         * @since 1.0.0
         */
        public function register_scripts()
        {
            wp_enqueue_style( "{$this->bear->config_prefix}-style", get_stylesheet_uri() );
            wp_enqueue_script( "{$this->bear->config_prefix}-navigation", get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
            wp_enqueue_script( "{$this->bear->config_prefix}-skip-link-focus-fix", get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
            }
        }
    }

endif;
