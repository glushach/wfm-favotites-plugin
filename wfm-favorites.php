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

add_filter('the_content', 'wfm_favotites_content');
add_action('wp_enqueue_scripts', 'wfm_favorites_scripts');
