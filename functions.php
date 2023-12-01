<?

function wp_favorites_dashboard_widget()
{
  wp_add_dashboard_widget('wp_favorites_dashboard', 'Ваш список Избранного', 'wfm_show_dashboard_widget');
}

function wfm_show_dashboard_widget()
{
  $user = wp_get_current_user();
  $favorites = get_user_meta($user->ID, 'wfm-favorites');
  $favorites = array_reverse($favorites);
  $admin_side = is_admin();
  if(!$favorites) {
    echo 'Список пуст';
    return;
  }
  $img_src = plugins_url('/img/loader.gif', __FILE__);
  echo '<ul>';
    foreach($favorites as $favorite) {
      echo '<li class="cat-item cat-item-'. $favorite .'">
              <a href="' . get_permalink($favorite) . '" target="_blank">' . get_the_title($favorite) . '</a>';
      if ($admin_side) {
        echo  '<span><a class="wfm-favorites-del" href="#" data-post="'. $favorite .'">&#10008;</a></span>
              <span class="wfm-favorites-hidden"><img src="' . $img_src . '" alt=""></span>';
      }
      echo  '</li>';
    }
  echo '</ul>';
  if ($admin_side) {
  echo '<div class="wfm-favorites-del-all">
    <button class="button" id="wfm-favorites-del-all">Очистить список</button>
    <span class="wfm-favorites-hidden"><img src="' . $img_src . '" alt=""></span>
  </div>';
  }
}

function wfm_favotites_content($content)
{
  if (!is_single() || !is_user_logged_in()) return $content;
  $img_src = plugins_url('/img/loader.gif', __FILE__);

  global $post;
  if (wfm_is_favorites($post->ID)) {
    return '<p class="wfm-favotites-link"><span class="wfm-favorites-hidden"><img src="' . $img_src . '" alt=""></span><a data-action="del" href="#">Удалить из Избранного</a></p>' . $content;
  }

  return '<p class="wfm-favotites-link"><span class="wfm-favorites-hidden"><img src="' . $img_src . '" alt=""></span><a data-action="add" href="#">Добавить в Изранное</a></p>' . $content;
}

function wfm_favorites_admin_scripts($hook)
{
  if($hook != 'index.php') return;
  wp_enqueue_script('wfm-favorites-admin-scripts', plugins_url('/js/wfm-favorites-admin-scripts.js',  __FILE__), array('jquery'), null, true);
  wp_enqueue_style('wfm-favorites-admin-style', plugins_url('/css/wfm-favorites-admin-style.css',  __FILE__));

  wp_localize_script(
    'wfm-favorites-admin-scripts',
    'wfmFavotites',
    array(
      'nonce' => wp_create_nonce('wfm-favorites'),
    )
  );
}

function wfm_favorites_scripts()
{
  if (!is_user_logged_in()) return;
  // if (!is_single() || !is_user_logged_in()) return;
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

function wp_ajax_wfm_callback_add()
{
  if (!wp_verify_nonce($_POST['security'], 'wfm-favorites')) {
    wp_die('Ошибка безопасности!');
  }
  $post_id = (int)$_POST['postId'];
  $user = wp_get_current_user();

  if (wfm_is_favorites($post_id)) wp_die();

  if (add_user_meta($user->ID, 'wfm-favorites', $post_id)) {
    $img_src = plugins_url('/img/loader.gif', __FILE__);
    wp_die(
      '<li class="cat-item cat-item-'. $post_id .'">
        <a href="' . get_permalink($post_id) . '" target="_blank">' . get_the_title($post_id) . '</a>
        <span><a class="wfm-favorites-del" href="#" data-post="'. $post_id .'">&#10008;</a></span>
        <span class="wfm-favorites-hidden"><img src="' . $img_src . '" alt=""></span>
      </li>'
    );
  }

  wp_die('Ошибка добавления');
}

function wp_ajax_wfm_callback_del_all() {
  if (!wp_verify_nonce($_POST['security'], 'wfm-favorites')) {
    wp_die('Ошибка безопасности!');
  }

  $user = wp_get_current_user();
  if(delete_metadata('user', $user->ID, 'wfm-favorites')) {
    wp_die('Список очищен');
  } else {
    wp_die('Ошибка удаления');
  }
}

function wp_ajax_wfm_callback_del()
{
  if (!wp_verify_nonce($_POST['security'], 'wfm-favorites')) {
    wp_die('Ошибка безопасности!');
  }
  $post_id = (int)$_POST['postId'];
  $user = wp_get_current_user();

  if (!wfm_is_favorites($post_id)) wp_die();

  if (delete_user_meta($user->ID, 'wfm-favorites', $post_id)) {
    wp_die('Удалено');
  }

  wp_die('Ошибка удаления');
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
