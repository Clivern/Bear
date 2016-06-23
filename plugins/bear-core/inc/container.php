<?php
/**
 * Container Module
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear-core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bear_Core_Container' ) ) :

    /**
     * The container class
     */
    class Bear_Core_Container {

        /**
         * An instance of this class
         *
         * @var object
         */
        private static $instance;

        /**
         * A list of all container values
         *
         * @var array
         */
        private $container = array();

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
         * Store modules or values in the container
         *
         * @since 1.0.0
         * @param string $key
         * @param mixed $value
         * @param array $parameters
         * @return mixed
         */
        public function register($key, $value, $parameters = array())
        {
            $key = $this->slug($key);

            if( is_callable($value) ){
                $this->container[$key] = call_user_func_array($value, $parameters);
            }else{
                $this->container[$key] = $value;
            }

            return $this->container[$key];
        }

        /**
         * Resolve value from the container
         *
         * @since 1.0.0
         * @param string $key
         * @return mixed
         */
        public function resolve($key)
        {
            $key = $this->slug($key);

            if (isset($this->container[$key])) {
                return $this->container[$key];
            }

            return false;
        }

        /**
         * Check if value exist
         *
         * @since 1.0.0
         * @param string $key
         * @return boolean
         */
        public function exist($key)
        {
            $key = $this->slug($key);

            if ( isset($this->container[$key]) ) {
                return true;
            }

            return false;
        }

        /**
         * Check if key exist in container
         *
         * @since 1.0.0
         * @param string $key
         * @return boolean
         */
        public function __isset($key)
        {
            return $this->exist($key);
        }

        /**
         * Get value from conatiner
         *
         * @since 1.0.0
         * @param string $key
         * @return mixed
         */
        public function __get($key)
        {
            return $this->resolve($key);
        }

        /**
         * Change string into slug
         *
         * @since 1.0.0
         * @param string $string
         * @return string
         */
        private function slug($string)
        {
            return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $string)));
        }

    }

endif;
