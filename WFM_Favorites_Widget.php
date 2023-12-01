<?php

class WFM_Favorites_Widget extends WP_Widget
{
  // настройки виджета в списке виджетов
  public function __construct()
  {
    $args = [
      'name' => 'Избранные записи',
      'description' => 'Выводит блок избранных записей пользователя'
    ];
    parent::__construct('wfm-favorites-widget', '', $args);
  }

  // форма виджета в админке
  public function form($instance)
  {
    extract($instance);
    $title = !empty($title) ? esc_attr($title) : 'Тестовое название';
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title') ;?>">Заголовок:</label>
      <input type="text" name="<?php echo $this->get_field_name('title') ;?>" value="<?php echo $title ?>" id="<?php echo $this->get_field_id('title') ;?>" class="widefat">
    </p>

    <?php
  }

  // виджет в пользовательской части
  public function widget($args, $instance)
  {
    if (!is_user_logged_in()) return;
    echo $args['before_widget'];
      echo $args['before_title'];
        echo $instance['title'];
      echo $args['after_title'];
      wfm_show_dashboard_widget();
    echo $args['after_widget'];
  }

  // обновление настроек виджета в админке
  /* public function update()
  {
    
  } */
}
