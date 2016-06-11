<?php
/**
 * Bear modules exec
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bear
 */

require get_template_directory() . '/inc/loader.php';

$bear->resolve('module_base')->exec();
$bear->resolve('module_customizer')->exec();
$bear->resolve('module_ecommerce')->exec();
$bear->resolve('module_extras')->exec();
$bear->resolve('module_supports')->exec();
$bear->resolve('module_template_tags')->exec();
