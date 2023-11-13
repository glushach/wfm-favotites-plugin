<?

function wfm_favotites_content($content)
{
  if (!is_single() || !is_user_logged_in()) return $content;
  return '<p class="wfm-favotites-link"><a href="#">Добавить в Изранное</a></p>' . $content;
}

function wfm_favorites_scripts()
{
  if (!is_single() || !is_user_logged_in()) return;
  wp_enqueue_script('wfm-favorites-scripts', plugins_url('/js/wfm-favorites-scripts.js',  __FILE__), array('jquery'), null, true);
  wp_enqueue_style('wfm-favorites-styles', plugins_url('/css/wfm-favorites-style.css',  __FILE__));
  wp_localize_script( 'wfm-favorites-scripts', 'wfmFavotites',
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);
}

function wp_ajax_wfm_callback()
{
  if (isset($_POST['test'])) {
    print_r($_POST);
  }
  wp_die('Запрос завершен');
}
