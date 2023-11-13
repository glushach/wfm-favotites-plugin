<?php
/*
Plugin Name: Добавление статей в Избранное
Plugin URI: http://webformyself.com
Description: Плагин добавляет для авторизированных пользвателей ссылку к статьям, позволяющую добавить статью в список избранных статьей
Version: 1.0
Author: Александр
Author URI: http://webformyself.com
*/

add_filter('the_content', 'wfm_favotites_content');

function wfm_favotites_content($content) {
  if (is_single()) {
    return '<p class="wfm-favotites-link"><a href="#">Добавить в Изранное</a></p>' . $content;
  }
  return $content;
}

