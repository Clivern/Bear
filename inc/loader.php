<?php
/**
 * Modules Loader
 *
 * @author   clivern
 * @since    1.0.0
 * @package  bear
 */

require get_template_directory() . '/inc/modules/container.php';
require get_template_directory() . '/inc/modules/base.php';
require get_template_directory() . '/inc/modules/customizer.php';
require get_template_directory() . '/inc/modules/ecommerce.php';
require get_template_directory() . '/inc/modules/extras.php';
require get_template_directory() . '/inc/modules/model.php';
require get_template_directory() . '/inc/modules/supports.php';
require get_template_directory() . '/inc/modules/template_tags.php';


$bear = Bear_Container::instance();


$bear->register('config_name', 'Bear');
$bear->register('config_version', '1.0.0');
$bear->register('config_author', 'Clivern');
$bear->register('config_theme_url', 'http://github.com/clivern/bear');
$bear->register('config_author_url', 'http://github.com/clivern');

$bear->register('config_textdomain', 'bear');
$bear->register('config_prefix', 'bear');
$this->bear->config_textdomain
$this->bear->config_prefix


$bear->register('module_base', function($bear){
    return Bear_Base::instance()->config($bear);
}, array($bear));

$bear->register('module_customizer', function($bear){
    return Bear_Customizer::instance()->config($bear);
}, array($bear));

$bear->register('module_ecommerce', function($bear){
    return Bear_Ecommerce::instance()->config($bear);
}, array($bear));

$bear->register('module_extras', function($bear){
    return Bear_Extras::instance()->config($bear);
}, array($bear));

$bear->register('module_model', function($bear){
    return Bear_Model::instance()->config($bear);
}, array($bear));

$bear->register('module_supports', function($bear){
    return Bear_Supports::instance()->config($bear);
}, array($bear));

$bear->register('module_template_tags', function($bear){
    return Bear_TemplateTags::instance()->config($$ear);
}, array($bear));
