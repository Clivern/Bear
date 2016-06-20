<?php
/**
 * Ecommerce Module
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bear_Ecommerce' ) ) :

    /**
     * The ecommerce class
     */
    class Bear_Ecommerce {

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

        }

    }

endif;
