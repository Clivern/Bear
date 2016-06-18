<?php
/*
  Plugin Name: Bear Core
  Plugin URI: http://github.com/clivern/bear
  Description: WordPress Plugins BoilerPlate.
  Version: 1.0.0
  Author: Clivern
  Author URI: http://github.com/clivern
  License: GPL
 */

/**
 * If this file is called directly, abort.
 */
if ( !defined('WPINC') )
{
    die;
}

/**
 * Bear Core Root File Path
 *
 * Used for plugin activation
 *
 * @since 1.0.0
 */
define('BEAR_CORE_ROOT_FILE', __FILE__);

/**
 * Bear Core Root Dir Path
 *
 * Used to point to fonts and files
 *
 * @since 1.0.0
 */
define('BEAR_CORE_ROOT_DIR', dirname(__FILE__));

/**
 * load plugin files loader
 */
include_once BEAR_CORE_ROOT_DIR . '/loader.php';
