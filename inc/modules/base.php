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

        public function config()
        {

        }

        public function exec()
        {

        }

    }

endif;
