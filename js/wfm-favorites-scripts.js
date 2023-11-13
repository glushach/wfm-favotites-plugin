jQuery(document).ready(function ($) {
  $(".wfm-favotites-link a").click(function (e) {
    $.ajax({
      type: 'POST',
      url: '/wp-admin/admin-ajax.php',
      data: {
        test: 'Test',
        action: 'wfm_test',
      },
      success: function(res) {
        console.log(res);
      },
      error: function() {
        alert('Error');
      }
    });
    e.preventDefault();
  });
});
