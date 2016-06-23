<?php
/**
 * Base Module
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear-core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bear_Core_Base' ) ) :

    /**
     * The base class
     */
    class Bear_Core_Base {

        /**
         * An instance of bear_core
         *
         * @var object
         */
        private $bear_core;

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
         * @param object $bear_core
         */
        public function config($bear_core)
        {
            $this->bear_core = $bear_core;
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
