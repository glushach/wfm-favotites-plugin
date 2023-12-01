jQuery(document).ready(function ($) {
  $(".wfm-favotites-link a").click(function (e) {
    const action = $(this).data('action');
    $.ajax({
      type: 'POST',
      // url: '/wp-admin/admin-ajax.php',
      url: wfmFavotites.url,
      data: {
        security: wfmFavotites.nonce,
        action: 'wfm_' + action,
        postId: wfmFavotites.postId,
      },
      beforeSend: function() {
        $('.wfm-favotites-link a').fadeOut(300, function() {
          $('.wfm-favotites-link .wfm-favorites-hidden').fadeIn();
        });
      },
      success: function(res) {
        $('.wfm-favotites-link .wfm-favorites-hidden').fadeOut(300, function() {
          if(action == 'del') {
            $('.wfm-favotites-link').html('Удалено');
            $('.widget_wfm-favorites-widget').find('li.cat-item-' + wfmFavotites.postId).remove();
          }
          if(action == 'add') {
            $('.wfm-favotites-link').html('Добавлено');
            $('.widget_wfm-favorites-widget ul').prepend(res);
          }
        });
      },
      error: function() {
        alert('Error');
      }
    });
    e.preventDefault();
  });
});
