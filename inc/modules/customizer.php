<?php
/**
 * Customizer Module
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bear_Customizer' ) ) :

    /**
     * The customizer class
     */
    class Bear_Customizer {

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
            add_action( 'customize_register', array( &$this,
                'customize_register'
            ));
            add_action( 'customize_preview_init', array( &$this,
                'customize_preview_js'
            ));
        }

        /**
         * Add postMessage support for site title and description for the Theme Customizer.
         *
         * @since 1.0.0
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_register( $wp_customize )
        {
            $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
            $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
            $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
        }

        /**
         * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
         *
         * @since 1.0.0
         */
        public function customize_preview_js()
        {
            wp_enqueue_script( "{$this->bear->config_prefix}_customizer", get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
        }
    }

endif;
