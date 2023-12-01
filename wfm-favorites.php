<?php
/*
Plugin Name: Добавление статей в Избранное
Plugin URI: http://webformyself.com
Description: Плагин добавляет для авторизированных пользвателей ссылку к статьям, позволяющую добавить статью в список избранных статьей
Version: 1.0
Author: Александр
Author URI: http://webformyself.com
*/

require __DIR__ . '/functions.php';
require __DIR__ . '/WFM_Favorites_Widget.php';

add_filter('the_content', 'wfm_favotites_content');
add_action('wp_enqueue_scripts', 'wfm_favorites_scripts');
add_action( 'wp_ajax_wfm_add', 'wp_ajax_wfm_callback_add' );
add_action( 'wp_ajax_wfm_del', 'wp_ajax_wfm_callback_del' );
add_action( 'wp_ajax_wfm_del_all', 'wp_ajax_wfm_callback_del_all' );
add_action( 'wp_dashboard_setup', 'wp_favorites_dashboard_widget' );

add_action( 'admin_enqueue_scripts', 'wfm_favorites_admin_scripts' );

add_action('widgets_init', 'wfm_favorites_widget');
function wfm_favorites_widget() {
  register_widget('WFM_Favorites_Widget');
}
