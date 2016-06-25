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

            return $this;
        }

        /**
         * Execute class
         *
         * @since 1.0.0
         */
        public function exec()
        {
            register_activation_hook( BEAR_CORE_ROOT_FILE, array(
                &$this,
                'activation'
            ));
            register_deactivation_hook( BEAR_CORE_ROOT_FILE, array(
                &$this,
                'deactivation'
            ));

            add_action('plugins_loaded', array(
                &$this,
                'translations'
            ));

            add_action('admin_enqueue_scripts', array(
                &$this,
                'enqueue'
            ));

            add_action('admin_head', array(
                &$this,
                'headerPrint'
            ));

            return $this;
        }

        /**
         * Plugin activation
         *
         * @since 1.0
         * @access public
         */
        public function activation()
        {
            if ( version_compare(get_bloginfo('version'), '3.9', '<') ) {
                wp_die(__('WordPress Blog Version Must Be Higher Than 3.9 So Please Update Your Blog', $this->bear_core->config_i18n_textdomain), $this->bear_core->config_name);
            }
        }

        /**
         * Plugin deactivation
         *
         * @since 1.0
         * @access public
         */
        public function deactivation()
        {
            #~
        }

        /**
         * Plugin translation
         *
         * @since 1.0
         * @access public
         */
        public function translations()
        {
            load_plugin_textdomain( $this->bear_core->config_i18n_textdomain, $this->bear_core->config_i18n_abs_rel_path, $this->bear_core->config_i18n_rel_path );
        }

        /**
         * Enqueue JS and CSS files in backend
         *
         * @since 1.0
         * @access public
         */
        public function enqueue($hook)
        {
            wp_enqueue_script('bear_core_backend_scripts', plugins_url('/bear-core/assets/js/backend_scripts.js'), array( 'jquery' ), '1.0', true);
            wp_enqueue_style('bear_core_backend_styles', plugins_url('/bear-core/assets/css/backend_styles.css'), array(), '1.0');
        }

        /**
         * Print code in backend header
         *
         * @since 1.0
         * @access public
         */
        public function headerPrint()
        {
            ?>
            <script type="text/javascript">
                // #
            </script>
            <?php
        }

    }

endif;
