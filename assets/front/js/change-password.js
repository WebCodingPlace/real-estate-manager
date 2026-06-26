jQuery(document).ready(function($) {
	$('.rem-change-password-form').submit(function(event) {
		event.preventDefault();
		swal(rem_pass_vars.wait_text, '', "info");
		var old_pass = $('#old-password').val();
		var new_pass = $('#new-password').val();
		var repeat_pass = $('#repeat-password').val();
		var redirect = $(this).data('redirect');
		var logoutall = ($(this).find('.logoutall').is(':checked')) ? 'enable' : 'disable';
		if (new_pass !== repeat_pass) {
			swal(rem_pass_vars.error_text, rem_pass_vars.pass_match, "error");
		} else {
			$.post(rem_pass_vars.ajax_url, {action: 'rem_change_password', logoutall: logoutall, old_pass: old_pass, new_pass: new_pass} , function(resp) {
				swal(resp.title, resp.message, resp.status);
				if (resp.status == 'success') {
					if (redirect == '') {
						window.location.reload();
					} else {
						window.location = redirect;
					}
				}
			});
		}
	});
});