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

        public function config($bear)
        {
            $this->bear = $bear;
        }

        public function exec()
        {

        }

    }

endif;
