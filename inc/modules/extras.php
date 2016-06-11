<?php
/**
 * Extras Module
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bear_Extras' ) ) :

    /**
     * The extras class
     */
    class Bear_Extras {

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
            add_filter( 'body_class', array( &$this,
                'body_classes'
            ));
        }

        /**
         * Adds custom classes to the array of body classes.
         *
         * @since 1.0.0
         * @param array $classes Classes for the body element.
         * @return array
         */
        public function body_classes( $classes )
        {
            // Adds a class of group-blog to blogs with more than 1 published author.
            if ( is_multi_author() ) {
                $classes[] = 'group-blog';
            }

            // Adds a class of hfeed to non-singular pages.
            if ( ! is_singular() ) {
                $classes[] = 'hfeed';
            }

            return $classes;
        }
    }

endif;
