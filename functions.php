<?

function wfm_favotites_content($content)
{
  if (!is_single() || !is_user_logged_in()) return $content;
  $img_src = plugins_url('/img/loader.gif', __FILE__);
  return '<p class="wfm-favotites-link"><span class="wfm-favorites-hidden"><img src="'. $img_src .'" alt=""></span><a href="#">Добавить в Изранное</a></p>' . $content;
}

function wfm_favorites_scripts()
{
  if (!is_single() || !is_user_logged_in()) return;
  wp_enqueue_script('wfm-favorites-scripts', plugins_url('/js/wfm-favorites-scripts.js',  __FILE__), array('jquery'), null, true);
  wp_enqueue_style('wfm-favorites-styles', plugins_url('/css/wfm-favorites-style.css',  __FILE__));
  global $post;
  wp_localize_script( 'wfm-favorites-scripts', 'wfmFavotites',
		array(
			'url' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('wfm-favorites'),
      'postId' => $post->ID
    )
	);
}

function wp_ajax_wfm_callback()
{
  if (!wp_verify_nonce($_POST['security'], 'wfm-favorites')) {
    wp_die('Ошибка безопасности!');
  }
  echo (int)$_POST['postId'];
  wp_die('Запрос завершен');
}
