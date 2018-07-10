jQuery(document).ready(function($) {
	$('.deny-user').click(function(event) {
		event.preventDefault();
		$(this).attr('disabled', 'disabled');
		var data = {
			userindex: $(this).data('userindex'),
			action: 'deny_agent',
		}

		$.post(ajaxurl, data, function(resp) {
			swal("Denied!", "Agent is denied.", "success");
			window.location.reload();
		});
	});
	$('.approve-user').click(function(event) {
		event.preventDefault();
		$(this).attr('disabled', 'disabled');
		var data = {
			userindex: $(this).data('userindex'),
			action: 'approve_agent',
		}

		$.post(ajaxurl, data, function(resp) {
			swal("Approved!", "Agent is approved.", "success");
			window.location.reload();
		});
	});
});