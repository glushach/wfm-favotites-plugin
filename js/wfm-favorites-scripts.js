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
          $('.wfm-favorites-hidden').fadeIn();
        });
      },
      success: function(res) {
        $('.wfm-favorites-hidden').fadeOut(300, function() {
          $('.wfm-favotites-link').html(res);
        });
      },
      error: function() {
        alert('Error');
      }
    });
    e.preventDefault();
  });
});
