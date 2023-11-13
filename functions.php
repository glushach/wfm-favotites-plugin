<?

function wfm_favotites_content($content)
{
  if (!is_single() || !is_user_logged_in()) return $content;
  $img_src = plugins_url('/img/loader.gif', __FILE__);

  global $post;
  if (wfm_is_favorites($post->ID)) {
    return '<p class="wfm-favotites-link"><a href="#">Удалить из Изранного</a></p>' . $content;
  }

  return '<p class="wfm-favotites-link"><span class="wfm-favorites-hidden"><img src="' . $img_src . '" alt=""></span><a href="#">Добавить в Изранное</a></p>' . $content;
}

function wfm_favorites_scripts()
{
  if (!is_single() || !is_user_logged_in()) return;
  wp_enqueue_script('wfm-favorites-scripts', plugins_url('/js/wfm-favorites-scripts.js',  __FILE__), array('jquery'), null, true);
  wp_enqueue_style('wfm-favorites-styles', plugins_url('/css/wfm-favorites-style.css',  __FILE__));
  global $post;
  wp_localize_script(
    'wfm-favorites-scripts',
    'wfmFavotites',
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
  $post_id = (int)$_POST['postId'];
  $user = wp_get_current_user();

  if (wfm_is_favorites($post_id)) wp_die();

  if (add_user_meta($user->ID, 'wfm-favorites', $post_id)) {
    wp_die('Добавленно');
  }

  wp_die('Ошибка добавления');
}

function wfm_is_favorites($post_id)
{
  $user = wp_get_current_user();
  $favorites = get_user_meta($user->ID, 'wfm-favorites');
  foreach ($favorites as $favorite) {
    if ($favorite == $post_id) return true;
  }
  return false;
}
