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
            add_action( 'after_setup_theme', array( &$this,
                'custom_header_setup'
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
            // wp_enqueue_script( "{$this->bear->config_prefix}-skip-link-focus-fix", get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
                wp_enqueue_script( 'comment-reply' );
            }
        }

        /**
         * Set up the WordPress core custom header feature.
         *
         * @since 1.0.0
         */
        public function custom_header_setup()
        {
            add_theme_support( 'custom-header', apply_filters( "{$this->bear->config_prefix}_custom_header_args", array(
                'default-image'          => '',
                'default-text-color'     => '000000',
                'width'                  => 1000,
                'height'                 => 250,
                'flex-height'            => true,
                'wp-head-callback'       => array(&$this, 'header_style'),
            )));
        }

        /**
         * Styles the header image and text displayed on the blog.
         *
         * @since 1.0.0
         * @see bear_custom_header_setup().
         */
        public function header_style()
        {
            $header_text_color = get_header_textcolor();

            /*
             * If no custom options for text are set, let's bail.
             * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
             */
            if ( HEADER_TEXTCOLOR === $header_text_color ) {
                return;
            }

            // If we get this far, we have custom styles. Let's do this.
            ?>
            <style type="text/css">
            <?php
                // Has the text been hidden?
                if ( ! display_header_text() ) :
            ?>
                .site-title,
                .site-description {
                    position: absolute;
                    clip: rect(1px, 1px, 1px, 1px);
                }
            <?php
                // If the user has set a custom color for the text use that.
                else :
            ?>
                .site-title a,
                .site-description {
                    color: #<?php echo esc_attr( $header_text_color ); ?>;
                }
            <?php endif; ?>
            </style>
            <?php
        }
    }

endif;
