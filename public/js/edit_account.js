$(function() {

  $(document).ready(function() {

    // Sidebar
    var height1 = $('.sidebar-top-bar').outerHeight();
    var height2 = $('.sidebar-body-user').outerHeight();
    var fheight = height1 + height2;
    $('.sidebar-body-accounts').css('height', 'calc(100vh - ' + fheight + 'px)');

    // Feather Icons
    feather.replace();

    // New Account
    if($('#accountTitle').val().length > 0 && $('#accountDomainURL').val().length > 0 && $('#accountExpirationDate').val().length > 0 && $('#accountIPAddress').val().length > 0) {
      $('#editAccountBtn').attr('disabled', false);
    } else {
      $('#editAccountBtn').attr('disabled', true);
    }
    $(document).on('keyup', function() {
      if($('#accountTitle').val().length > 0 && $('#accountDomainURL').val().length > 0 && $('#accountExpirationDate').val().length > 0 && $('#accountIPAddress').val().length > 0) {
        $('#editAccountBtn').attr('disabled', false);
      } else {
        $('#editAccountBtn').attr('disabled', true);
      }
    });

    // Tabs
    $('.dashboard-body-account-tab-link').on('click', function() {
      var tab = $(this).data('tab');
      $('.dashboard-body-account-tab-link').removeClass('active');
      $('.dashboard-body-account-tab-link[data-tab="' + tab + '"]').addClass('active');
      $('.dashboard-body-account-tab').removeClass('active');
      $('.dashboard-body-account-tab[data-tab="' + tab + '"]').addClass('active');
    });

  });

});
