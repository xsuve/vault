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
    $(document).on('keyup', function() {
      if($('#accountEncryptionKey').val().length > 0 && $('#accountTitle').val().length > 0 && $('#accountDomainURL').val().length > 0 && $('#accountExpirationDate').val().length > 0 && $('#accountIPAddress').val().length > 0) {
        $('#addAccountBtn').attr('disabled', false);
      } else {
        $('#addAccountBtn').attr('disabled', true);
      }
    });

    // Encryption Key
    $('.encryption-key-input .show-encryption-key').on('click', function() {
      $('.encryption-key-input input').attr('type', 'text');
      $(this).removeClass('active');
      $('.encryption-key-input .hide-encryption-key').addClass('active');
    });
    $('.encryption-key-input .hide-encryption-key').on('click', function() {
      $('.encryption-key-input input').attr('type', 'password');
      $(this).removeClass('active');
      $('.encryption-key-input .show-encryption-key').addClass('active');
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
