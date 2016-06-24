<?php
/**
 * Validator Module
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear-core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bear_Core_Validator' ) ) :

    /**
     * The validator class
     */
    class Bear_Core_Validator {

        /**
         * An instance of bear_core
         *
         * @var object
         */
        private $bear_core;

        /**
         * Current validated input
         *
         * @since 1.0
         * @access private
         * @var array $this->input
         */
        private $input;

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
         * @access public
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
         * @access public
         * @param object $bear_core
         */
        public function config($bear_core)
        {
            $this->bear_core = $bear_core;
        }


        /**
         * Clear $_GET and $_POST vars
         *
         *
         * Prevents internet pirates from exploiting clark
         * If there is any issue here, i should remove my IDE and simply sell toys :)
         * So IF YOU FOUND BUG HERE SEND EMAIL TO HELLO@CLIVERN.COM TO INFORM.
         *
         * <code>
         * $inputs = array(
         *       'key' => array(
         *             'req'=> 'get|post',
         *             'sanit'=> '',
         *             'valid'=> '',
         *             'default'=>'',
         *             'errors'=>array(
         *                         'vrule' => error,
         *                         'vrule' => error,
         *                   ),
         *             ),
         *        ......,
         *        ......,
         * );
         * </code>
         *
         * @since 1.0.0
         * @access public
         * @param array $inputs
         * @return array
         */
        public function clear($inputs)
        {
            $cleared_data = array(
                'error_status' => false,
                'error_text' => '',
            );
            foreach ( $inputs as $key => $rules ) {
                $request = ($rules[ 'req' ] == 'get') ? $_GET : $_POST;
                $sanit_rules = (isset($rules[ 'sanit' ])) ? $rules[ 'sanit' ] : null;
                $valid_rules = (isset($rules[ 'valid' ])) ? $rules[ 'valid' ] : null;
                $this->input = array(
                    'old_value' => '',
                    'value' => '',
                    'status' => false,
                    'error' => false,
                );
                $this->input[ 'value' ] = (isset($request[ $key ])) ? $request[ $key ] : '';
                $this->input['old_value'] = $this->input[ 'value' ];
                # we need to validate user inputs
                if ( $this->input[ 'value' ] !== null ) {
                    $this->input[ 'status' ] = ( boolean ) $this->valid($this->input[ 'value' ], $valid_rules);
                }
                # then sanitize
                if ( $this->input[ 'value' ] !== null ) {
                    $this->input[ 'value' ] = $this->sanit($this->input[ 'value' ], $sanit_rules);
                }
                # override default
                if ( (isset($rules[ 'default' ])) && ($rules[ 'default' ] !== null) && ($this->input[ 'status' ] == false) ) {
                    $this->input[ 'value' ] = $rules[ 'default' ];
                }

                if( (isset($rules['optional'])) && ($this->input[ 'value' ] != $this->input['old_value']) ){
                    $cleared_data['error_status'] = true;
                    $cleared_data['error_text'] = $rules['optional'];
                }

                # check if error found in
                if( (false === $cleared_data['error_status']) && (false !== $this->input['error']) && (isset($rules['errors'])) && (isset($rules['errors'][$this->input['error']])) ){
                    $cleared_data['error_status'] = true;
                    $cleared_data['error_text'] = $rules['errors'][$this->input['error']];
                }
                $cleared_data[ $key ] = $this->input;

            }
            return $cleared_data;
        }

        /**
         * Clear array of values
         *
         *
         * Prevents internet pirates from exploiting clark
         * If there is any issue here, i should remove my IDE and simply sell toys :)
         * So IF YOU FOUND BUG HERE SEND EMAIL TO HELLO@CLIVERN.COM TO INFORM.
         *
         * <code>
         * $values = array(
         *       'key' => array(
         *             'value'=> '',
         *             'sanit'=> '',
         *             'valid'=> '',
         *             'default'=>'',
         *             'errors' => array()
         *             ),
         *        ......,
         *        ......,
         * );
         * </code>
         *
         * @since 1.0.0
         * @access public
         * @param array $values
         * @return array
         */
        public function clear_values($values)
        {
            $cleared_values = array(
                'error_status' => false,
                'error_text' => '',
            );
            foreach ( $values as $key => $rules ) {
                $sanit_rules = (isset($rules[ 'sanit' ])) ? $rules[ 'sanit' ] : null;
                $valid_rules = (isset($rules[ 'valid' ])) ? $rules[ 'valid' ] : null;
                $this->input = array(
                    'old_value' => '',
                    'value' => '',
                    'status' => false,
                    'error' => false
                );
                $this->input[ 'value' ] = (isset($rules[ 'value' ])) ? $rules[ 'value' ] : '';
                $this->input['old_value'] = $this->input[ 'value' ];
                if ( $this->input[ 'value' ] !== null ) {
                    $this->input[ 'status' ] = ( boolean ) $this->valid($this->input[ 'value' ], $valid_rules);
                }
                if ( $this->input[ 'value' ] !== null ) {
                    $this->input[ 'value' ] = $this->sanit($this->input[ 'value' ], $sanit_rules);
                }
                if ( (isset($rules[ 'default' ])) && ($rules[ 'default' ] !== null) && ($this->input[ 'status' ] == false) ) {
                    $this->input[ 'value' ] = $rules[ 'default' ];
                }

                if( (isset($rules['optional'])) && ($this->input[ 'value' ] != $this->input['old_value']) ){
                    $cleared_data['error_status'] = true;
                    $cleared_data['error_text'] = $rules['optional'];
                }

                # check if error found in
                if( (false === $cleared_values['error_status']) && (false !== $this->input['error']) && (isset($rules['errors'])) && (isset($rules['errors'][$this->input['error']])) ){
                    $cleared_values['error_status'] = true;
                    $cleared_values['error_text'] = $rules['errors'][$this->input['error']];
                }
                $cleared_values[ $key ] = $this->input;
            }
            return $cleared_values;
        }

        /**
         * Execute different sanitization methods on given input value and return value again
         *
         * @since 1.0
         * @access private
         * @param mixed $value
         * @param string $rules
         * @return mixed
         */
        private function sanit($value, $rules)
        {
            if ( $rules == null ) {
                return $value;
            }
            if ( strpos($rules, '&') ) {
                $rules = explode('&', $rules);
            } else {
                $rules = array( $rules );
            }

            $san_value = $value;
            $san_value = (is_array($san_value)) ? $san_value : trim($san_value);
            foreach ( $rules as $rule ) {
                if ( strpos($rule, ':') ) {
                    $rule = explode(':', $rule);
                    $method = $rule[ 0 ];
                    $args = $rule[ 1 ];
                    $san_value = $this->$method($san_value, $args);
                } else {
                    $method = $rule;
                    $san_value = $this->$method($san_value);
                }
            }

            return $san_value;
        }

        /**
         * Execute different validation methods on given input value and return status
         *
         * @since 1.0.0
         * @access private
         * @param mixed $value
         * @param string $rules
         * @return boolean
         */
        private function valid($value, $rules)
        {
            if ( $rules == null ) {
                return true;
            }
            if ( strpos($rules, '&') ) {
                $rules = explode('&', $rules);
            } else {
                $rules = array( $rules );
            }

            $passed = true;
            $value = (is_array($value)) ? $value : trim($value);
            foreach ( $rules as $rule ) {
                if ( strpos($rule, ':') ) {
                    $rule = explode(':', $rule);
                    $method = $rule[ 0 ];
                    $args = $rule[ 1 ];
                    $passed &= $this->$method($value, $args);
                    # detect first broken rule
                    $this->input['error'] = ( !($passed) && ($this->input['error'] == false) ) ? $method : $this->input['error'];
                } else {
                    $method = $rule;
                    $passed &= $this->$method($value);
                    # detect first broken rule
                    $this->input['error'] = ( !($passed) && ($this->input['error'] == false) ) ? $method : $this->input['error'];
                }
            }

            return $passed;
        }

        /**
         * Sanitize email value
         *
         * Usage : add ..&semail to sanit rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return string sanitized value
         */
        private function semail($value)
        {
            return filter_var($value, FILTER_SANITIZE_EMAIL);
        }

        /**
         * Sanitize encoded value
         * + to used add ..&sencoded to sanit rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return string sanitized value
         */
        private function sencoded($value)
        {
            return filter_var($value, FILTER_SANITIZE_ENCODED);
        }

        /**
         * Sanitize full special chars value
         *
         * Usage : add ..&sfullspecialchars to sanit rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return string sanitized value
         */
        private function sfullspecialchars($value)
        {
            return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        /**
         * Sanitize magic quotes value
         *
         * Usage : add ..&smagicquotes to sanit rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return string sanitized value
         */
        private function smagicquotes($value)
        {
            return filter_var($value, FILTER_SANITIZE_MAGIC_QUOTES);
        }

        /**
         * Sanitize number float value
         *
         * Usage : add ..&snumberfloat to sanit rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return string sanitized value
         */
        private function snumberfloat($value)
        {
            return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
        }

        /**
         * Sanitize number int value
         *
         * Usage : add ..&snumberint to sanit rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return string sanitized value
         */
        private function snumberint($value)
        {
            return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        }

        /**
         * Sanitize special chars value
         *
         * Usage : add ..&sspecialchars to sanit rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return string sanitized value
         */
        private function sspecialchars($value)
        {
            return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        /**
         * Sanitize string value
         *
         * Usage : add ..&sstring to sanit rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return string sanitized value
         */
        private function sstring($value)
        {
            return filter_var($value, FILTER_SANITIZE_STRING);
        }

        /**
         * Sanitize integer or float value
         *
         * Usage : add ..&sintfloat to sanit rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return string sanitized value
         */
        private function sintfloat($value)
        {
            return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }

        /**
         * Sanitize url value
         *
         * Usage : add ..&surl to sanit rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return string sanitized value
         */
        private function surl($value)
        {
            return filter_var($value, FILTER_SANITIZE_URL);
        }

        /**
         * Validate boolean value
         *
         * Usage : add ..&vboolean to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vboolean($value)
        {
            return ( boolean ) (filter_var($value, FILTER_VALIDATE_BOOLEAN));
        }

        /**
         * Validate email value
         *
         * Usage : add ..&vemail to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vemail($value)
        {
            return ( boolean ) (filter_var($value, FILTER_VALIDATE_EMAIL));
        }

        /**
         * Validate float value
         *
         * Usage : add ..&vfloat to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vfloat($value)
        {
            return ( boolean ) (filter_var($value, FILTER_VALIDATE_FLOAT));
        }

        /**
         * Validate int value
         *
         * Usage : add ..&vint to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vint($value)
        {
            return ( boolean ) (filter_var($value, FILTER_VALIDATE_INT));
        }

        /**
         * Validate int or float value
         *
         * Usage : add ..&vintfloat to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vintfloat($value)
        {
            return ( ((boolean) filter_var($value, FILTER_VALIDATE_FLOAT)) || ((boolean)filter_var($value, FILTER_VALIDATE_INT)));
        }

        /**
         * Validate ip value
         *
         * Usage : add ..&vip to validate rules
         *
         * @since 1.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vip($value)
        {
            return ( boolean ) (filter_var($value, FILTER_VALIDATE_IP));
        }

        /**
         * Validate Media value
         *
         * Usage : add ..&vmedia to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vmedia($value)
        {
            $value = trim($value);
            if( empty($value) ){
                return true;
            }
            $value_list = explode(',', $value);
            $status = true;
            foreach ($value_list as $key => $value_item) {
                $status &= (boolean) filter_var($value_item, FILTER_VALIDATE_INT);
            }
            return (boolean) $status;
        }

        /**
         * Validate regexp value
         *
         * Usage : add ..&vregexp to validate rules
         *
         * THIS METHOD TRY TO VALIDATE REGEXPs SO USING OF @ TO PREVENT NOTICES
         * THAT COULD RISE IF CLIENT SUBMIT INVALID REGEXPs
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vregexp($value)
        {
            $value = trim($value);
            return ( (boolean) (empty($value)) ) ? true : (@preg_match($value, null) !== false);
            return true;
        }

        /**
         * Validate url value
         *
         * Usage : add ..&vurl to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vurl($value)
        {
            return ( boolean ) (filter_var($value, FILTER_VALIDATE_URL));
        }

        /**
         * Validate color value
         *
         * Usage : add ..&vcolor to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vcolor($value)
        {
            return ( boolean ) (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $value));
        }

        /**
         * Validate notempty value
         *
         * Usage : add ..&vnotempty to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vnotempty($value)
        {
            return ( boolean ) (($value != '') && (!empty($value)) && ($value != null));
        }

        /**
         * Validate inarray value
         *
         * Usage : add ..&vinarray:left,right,center to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vinarray($value, $args)
        {
            $args = explode(',', $args);
            return ( boolean ) (in_array($value, $args));
        }

        /**
         * Validate intbetween value
         *
         * Usage : add ..&vintbetween:1,1000 to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vintbetween($value, $args)
        {
            $args = explode(',', $args);
            $min = ( int ) $args[ 0 ];
            $max = ( int ) $args[ 1 ];
            return ( boolean ) (($value >= $min) && ($value <= $max));
        }

        /**
         * Validate equals value
         *
         * Usage : add ..&vequals:helo to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vequals($value, $args)
        {
            return ( boolean ) ($value == $args);
        }

        /**
         * Validate checkbox value
         *
         * Usage : add ..&vcheckbox to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function vcheckbox($value)
        {
            return ( boolean ) ($value == '1');
        }

        /**
         * Validate if str lenght between two values
         *
         * Usage : add ..&vstrlenbetween:1,250 to validate rules
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @param string $args
         * @return boolean
         */
        private function vstrlenbetween($value, $args)
        {
            $args = explode(',', $args);
            $value_lenght = strlen($value);
            $min = ( int ) $args[ 0 ];
            $max = ( int ) $args[ 1 ];
            return ( boolean ) (($value_lenght >= $min) && ($value_lenght <= $max));
        }

        /**
         * Validate alphanumeric strings with spaces
         *
         * @since 1.0.0
         * @access private
         * @param string $value
         * @return boolean
         */
        private function valnumws($value)
        {
            return (boolean) ctype_alnum(trim(str_replace(' ','',$value)));
        }
    }

endif;
