$(function() {

  var URL = 'http://localhost/vault/';

  $(document).ready(function() {

    // Feather Icons
    feather.replace();

    // Sidebar
    var height1 = $('.sidebar-top-bar').outerHeight();
    var height2 = $('.sidebar-body-user').outerHeight();
    var fheight = height1 + height2;
    $('.sidebar-body-accounts').css('height', 'calc(100vh - ' + fheight + 'px)');

    // Cookies
    $('.cookies-btn').on('click', function() {
      $('.cookies').hide();
    });

    // Boostrap Tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Navbar
    $('.navbar-links a, .footer-box-links a').on('click', function() {
      var href = $(this).attr('href');
      var section = $(href);
      $('html, body').animate({scrollTop: section.offset().top}, 'slow');
      $('.navbar-links a').removeClass('active');
      $('.navbar-links a[href="' + href + '"]').addClass('active');
    });
    $('.navbar-mobile-toggle').on('click', function() {
      $('.navbar-mobile').addClass('active');
    });
    $('.navbar-mobile-close, .navbar-mobile .navbar-mobile-links a').on('click', function() {
      $('.navbar-mobile').removeClass('active');
    });

    // Header Read More Btn
    $('.header-read-more-btn').on('click', function() {
      $('html, body').animate({scrollTop: $('#features').offset().top}, 'slow');
    });

    // Show / Hide Info
    $('.dashboard-body-account-info-action .show-info').on('click', function() {
      var parent = $(this).parent();
      var input = parent.parent().children('.dashboard-body-account-info-input');
      var info = input.data('info');
      input.val(info);
      $(this).hide();
      parent.children('.hide-info').show();
    });
    $('.dashboard-body-account-info-action .hide-info').on('click', function() {
      var parent = $(this).parent();
      var input = parent.parent().children('.dashboard-body-account-info-input');
      input.val('********************');
      $(this).hide();
      parent.children('.show-info').show();
    });

    // Show / Hide All Info
    $('.dashboard-body-account-general-actions .show-all-info').on('click', function() {
      var info_type = $(this).data('info-type');
      $('.dashboard-body-account-info-input[data-info-type="' + info_type + '"]').each(function() {
        var info = $(this).data('info');
        $(this).val(info);
      });
      $('.dashboard-body-account-general-actions .show-all-info[data-info-type="' + info_type + '"]').hide();
      $('.dashboard-body-account-general-actions .hide-all-info[data-info-type="' + info_type + '"]').show();
    });
    $('.dashboard-body-account-general-actions .hide-all-info').on('click', function() {
      var info_type = $(this).data('info-type');
      var input = $('.dashboard-body-account-info-input[data-info-type="' + info_type + '"]');
      input.val('********************');
      $('.dashboard-body-account-general-actions .hide-all-info[data-info-type="' + info_type + '"]').hide();
      $('.dashboard-body-account-general-actions .show-all-info[data-info-type="' + info_type + '"]').show();
    });

    // Copy Info
    $('.dashboard-body-account-info-action .copy-info').on('click', function() {
      var parent = $(this).parent();
      var input = parent.parent().children('.dashboard-body-account-info-input');
      // var info = input.data('info');
      // input.val(info);
      input.select();
      document.execCommand('copy');
      input.val('Copied!');
      setTimeout(function() {
        input.val('********************');
        parent.children('.hide-info').hide();
        parent.children('.show-info').show();
      }, 1500);
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

    // Search
    $('#searchInput').on('keyup', function() {
      var query = $(this).val().toLowerCase();
      if(query != '') {
        var results = $('.dashboard-body-account[data-account-title*="' + query + '"]');
        var data = results.data('account-title');
        if(results.length) {
          $('.dashboard-body-account').parents('.dashboard-body-account-col').hide();
          results.parents('.dashboard-body-account-col').show();
        } else {
          $('.dashboard-body-account').parents('.dashboard-body-account-col').hide();
        }
      } else {
        $('.dashboard-body-account').parents('.dashboard-body-account-col').show();
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

    // Search User by Email
    var searchSelect = $('#accountUserEmail').selectize({
      placeholder: 'User Email (ex. useraccount@email.com)',
      maxOptions: 1,
      render: {
        option: function(item, escape) {
          console.log(item);
          return '<div class="search-account-user-email-box">' +
            '<div class="row">' +
              '<div class="col-lg-2">' +
                '<div class="search-account-user-email-box-image v-m">' +
                  '<img src="' + (item.profile_url == '' ? '../public/img/user.png' : item.profile_url) + '">' +
                '</div>' +
              '</div>' +
              '<div class="col-lg-10">' +
                '<div class="v-m">' +
                  '<div class="search-account-user-email-box-title">' + item.text + '</div>' +
                  '<div class="search-account-user-email-box-text">Click to select this user.</div>' +
                '</div>' +
              '</div>' +
            '</div>' +
          '</div>';
        }
	    }
    });
    if(searchSelect.length > 0) {
      var searchSelectize = searchSelect[0].selectize;
      var account_id = $('#accountUserEmailAccountID').val();
      var users = [];
      searchSelectize.on('type', function() {
        var query = $('#accountUserEmail-selectized').val();
        if(query.length > 0) {
          $.ajax({
            url: URL + 'account/searchuserbyemail/' + query + '/' + account_id,
            type: 'POST',
            success: function(json) {
              if(json != '') {
                users = JSON.parse(json);
                if(users.length > 0) {
                  for(var i = 0; i < users.length; i++) {
                    searchSelectize.addOption({ value: users[i].email, text: users[i].email, profile_url: users[i].profile_url });
                    searchSelectize.refreshOptions();
                  }
                  $('#accountUserEmailBtn').attr('disabled', false);
                } else {
                  searchSelectize.clearOptions();
                  searchSelectize.refreshOptions();
                  users = [];
                  $('#accountUserEmailBtn').attr('disabled', true);
                }
              } else {
                searchSelectize.clearOptions();
                searchSelectize.refreshOptions();
                users = [];
                $('#accountUserEmailBtn').attr('disabled', true);
              }
            }
          });
        } else {
          searchSelectize.clearOptions();
          searchSelectize.refreshOptions();
          users = [];
          $('#accountUserEmailBtn').attr('disabled', true);
        }
      });
      $('#accountUserEmail-selectized').on('keyup', function() {
        var query = $(this).val();
        if(query.length <= 0) {
          searchSelectize.clearOptions();
          searchSelectize.refreshOptions();
          users = [];
          $('#accountUserEmailBtn').attr('disabled', true);
        }
        if(users.length <= 0) {
          searchSelectize.clearOptions();
          searchSelectize.refreshOptions();
          users = [];
          $('#accountUserEmailBtn').attr('disabled', true);
        }
      });
    }

    // Notifications
    $(document).on('click', '.dashboard-body-notification', function() {
      var notification_id = $(this).data('notification-id');
      $.ajax({
        url: URL + 'notifications/readnotification/' + notification_id,
        type: 'POST'
      });
    });

    // Edit Profile
    $('#editProfileChooseImage').on('change', function() {
      if(this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#editProfileImagePreview').attr('src', e.target.result);
          $('.dashboard-body-profile-image-mask').hide();
          $('#editProfileBtn').attr('disabled', false);
        }
        reader.readAsDataURL(this.files[0]);
      }
    });

    // Btn Upgrade
    $('.btn-upgrade-pro').on('click', function() {
      $(this).text('Redirecting to PayPal...');
      $(this).attr('disabled', true);
    });

    // Delete Account
    $('#deleteAccountInput').on('keyup', function() {
      var value = $(this).val();
      var account_title = $(this).data('account-title');

      if(value == account_title) {
        var delete_link = $('#deleteAccountLink').data('href');
        $('#deleteAccountLink').attr('href', delete_link);
        $('#deleteAccountBtn').attr('disabled', false);
      } else {
        $('#deleteAccountLink').attr('href', 'javascript:void(0);');
        $('#deleteAccountBtn').attr('disabled', true);
      }
    });

  });

});
