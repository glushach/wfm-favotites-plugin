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
    parent::__construct('wfm-favorites-wdget', '', $args);
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
    
  }

  // обновление настроек виджета в админке
  /* public function update()
  {
    
  } */
}
