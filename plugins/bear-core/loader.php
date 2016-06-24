<?php
/**
 * Loader file
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear-core
 */

/**
 * If this file is called directly, abort.
 */
if ( !defined('WPINC') ) {
      die;
}

require dirname(__FILE__) . '/inc/container.php';
require dirname(__FILE__) . '/inc/base.php';
require dirname(__FILE__) . '/inc/model.php';
require dirname(__FILE__) . '/libraries/validator.php';

$bear_core = Bear_Core_Container::instance();

$bear_core->register('config_name', 'Bear Core');
$bear_core->register('config_version', '1.0.0');
$bear_core->register('config_author', 'Clivern');
$bear_core->register('config_theme_url', 'http://github.com/clivern/bear');
$bear_core->register('config_author_url', 'http://github.com/clivern');
$bear_core->register('config_i18n_textdomain', 'bear_core_plugin_lang');
$bear_core->register('config_i18n_rel_path', '/bear-core/langs/');
$bear_core->register('config_i18n_abs_rel_path', false);
$bear_core->register('config_prefix', 'bear_core');


$bear_core->register('module_base', function($bear_core){
    return Bear_Core_Base::instance()->config($bear_core);
}, array($bear_core));

$bear_core->register('module_model', function($bear_core){
    return Bear_Core_Model::instance()->config($bear_core);
}, array($bear_core));

$bear_core->register('library_validator', function($bear_core){
    return Bear_Core_Validator::instance()->config($bear_core);
}, array($bear_core));
