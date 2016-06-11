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
require get_template_directory() . '/inc/modules/supports.php';
require get_template_directory() . '/inc/modules/template_tags.php';


$bear = Bear_Container::instance();


$bear->register('config.name', 'Bear');
$bear->register('config.version', '1.0.0');
$bear->register('config.author', 'Clivern');
$bear->register('config.author_url', 'http://clivern.com');


$bear->register('module.base', function(){
    return Bear_Base::instance()->config()->exec();
}, array());

$bear->register('module.customizer', function(){
    return Bear_Customizer::instance()->config()->exec();
}, array());

$bear->register('module.ecommerce', function(){
    return Bear_Ecommerce::instance()->config()->exec();
}, array());

$bear->register('module.extras', function(){
    return Bear_Extras::instance()->config()->exec();
}, array());

$bear->register('module.supports', function(){
    return Bear_Supports::instance()->config()->exec();
}, array());

$bear->register('module.template_tags', function(){
    return Bear_TemplateTags::instance()->config()->exec();
}, array());
