jQuery(document).ready(function($) {
	jQuery(".labelauty").labelauty();
	jQuery('#rem-login-form').submit(function(e){
		e.preventDefault();
		var redirect_after_login = $(this).data('redirect');
		var login_wrap = jQuery('.login-alert');
		login_wrap.removeClass('alert-danger').addClass('alert-info');
		login_wrap.find('.icon').removeClass('fa-exclamation-triangle').addClass('fa-info');
		login_wrap.find('.login-status').text('Logging In, Please Wait...');
		var login_wrap = jQuery('.login-alert').show();

		var loginData = $(this).serialize();
		$.post($(this).data('ajaxurl'), loginData, function(resp) {
			if (resp.status == 'failed') {
				login_wrap.removeClass('alert-info').addClass('alert-danger');
				login_wrap.find('.icon').removeClass('fa-info').addClass('fa-exclamation-triangle');
				login_wrap.find('.login-status').html(resp.message);
			};
			if (resp.status == 'success') {
				login_wrap.removeClass('alert-info alert-danger').addClass('alert-success');
				login_wrap.find('.icon').removeClass('fa-info fa-exclamation-triangle').addClass('fa-check');
				login_wrap.find('.login-status').text('Successfull!');
				if (redirect_after_login != '' && redirect_after_login != undefined) {
					window.location = redirect_after_login;
				} else {
					window.location = resp.message;
				}
			};

		}, "json");
	});
});