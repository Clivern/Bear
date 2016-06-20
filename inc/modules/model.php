<?php
/**
 * Model Module
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bear_Model' ) ) :

    /**
     * The model class
     */
    class Bear_Model {

        /**
         * An instance of bear
         *
         * @var object
         */
        private $bear;

        /**
         * An instance of wpdb object
         *
         * @var object
         */
        private $wpdb;

        /**
         * Databases tables prefix
         *
         * @var string
         */
        private $prefix;

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
            global $wpdb;

            $this->wpdb = $wpdb;
            $this->prefix = $this->wpdb->prefix;
        }

        /**
         * Get option
         *
         * @since 1.0.0
         * @access public
         * @param  string  $key
         * @param  boolean $default
         * @return mixed
         */
        public function getOption($key, $default = false)
        {
            return get_option( $key, $default );
        }

        /**
         * Add option
         *
         * @since 1.0.0
         * @access public
         * @param string $key
         * @param mixed $value
         * @param on|off $autoload
         * @return boolean
         */
        public function addOption($key, $value, $autoload)
        {
            $value = (is_array($value)) ? serialize($value) : $value;
            return (boolean) add_option( $key, $value, false, $autoload );
        }

        /**
         * Update option
         *
         * @since 1.0.0
         * @access public
         * @param string $key
         * @param mixed $new_value
         * @return boolean
         */
        public function updateOption($key, $new_value)
        {
            $new_value = (is_array($new_value)) ? serialize($new_value) : $new_value;
            return (boolean) update_option( $key, $new_value );
        }

        /**
         * Delete option
         *
         * @since 1.0.0
         * @access public
         * @param string $key
         * @return boolean
         */
        public function deleteOption($key)
        {
            return (boolean) delete_option( $key );
        }

        /**
         * Used to run custom SQL query
         *
         * @since 1.0.0
         * @access public
         * @param string $query
         * @return mixed
         */
        public function query($query)
        {
            return $this->wpdb->query($query);
        }

        /**
         * Select data from table
         *
         * @since 1.0.0
         * @access public
         * @param string $table
         * @param array|* $cols
         * @param string $where
         * @param string $orderby
         * @param string $limit
         * @param boolean $prefix
         * @return array
         */
        public function select($table, $cols, $where = '', $orderby = '', $limit = '', $prefix = true)
        {
            $this->wpdb->flush();
            $table = ($prefix) ? $this->prefix . $table : $table;
            $cols = ($cols == '*') ? '*' : implode(', ', $cols);
            $where = (empty($where)) ? '' : ' WHERE ' . $where;
            $orderby = (empty($orderby)) ? '' : ' ORDER BY ' . $orderby;
            $limit = (empty($limit)) ? '' : ' LIMIT ' . $limit;

            return $this->wpdb->get_results("SELECT {$cols} FROM {$this->prefix}{$table}{$where}{$orderby}{$limit}", ARRAY_A);
        }

        /**
         * Insert data and get insert id
         *
         * @since 1.0.0
         * @access public
         * @param string $table
         * @param array $data
         * @param boolean $prefix
         * @return integer|false last insert id
         */
        public function insert($table, $data, $prefix = true)
        {
            $this->wpdb->flush();
            $table = ($prefix) ? $this->prefix . $table : $table;
            return ((boolean) $this->wpdb->insert($table, $data)) ? $this->wpdb->insert_id : false;
        }

        /**
         * Update a row or more in a table
         *
         * @since 1.0.0
         * @access public
         * @param string $table
         * @param array $data
         * @param null|array $where
         * @param boolean $prefix
         * @return boolean
         */
        public function update($table, $data, $where = null, $prefix = true)
        {
            $this->wpdb->flush();
            $table = ($prefix) ? $this->prefix . $table : $table;
            if ( null == $where ) {
                return (boolean) $this->wpdb->update($table, $data);
            } else {
                return (boolean) $this->wpdb->update($table, $data, $where);
            }
        }

        /**
         * Delete a row or more from a table
         *
         * @since 1.0.0
         * @access public
         * @param string $table
         * @param array $where
         * @param boolean $prefix
         * @return boolean
         */
        public function delete($table, $where, $prefix = true)
        {
            $this->wpdb->flush();
            $table = ($prefix) ? $this->prefix . $table : $table;
            return (boolean) $this->wpdb->delete($table, $where);
        }
    }

endif;
