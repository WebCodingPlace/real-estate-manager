jQuery(document).ready(function($) {
	$('.ich-settings-main-wrap').on('click', '.deny-user', function(event) {
		event.preventDefault();
		var field_title = $(this).closest('tr').find('td:first-child').text();
        swal({
          title: "Delete "+field_title+"?",
          text: "Once deleted, you will not be able to recover this user.",
          icon: "warning",
          buttons: true,
          dangerMode: false,
        })
        .then((willDelete) => {
          if (willDelete) {
          	$(this).attr('disabled', 'disabled');
          	var data = {
          		userindex: $(this).data('userindex'),
          		action: 'deny_agent',
          		nonce: rem_agents_vars.nonce_deny
          	}

          	$.post(ajaxurl, data, function(resp) {
          		swal(field_title+" Deleted!", "", "success");
          		window.location.reload();
          	});
          }
        });
	});

	$('.ich-settings-main-wrap').on('click', '.approve-user', function(event) {
		event.preventDefault();
		$(this).attr('disabled', 'disabled');
		var data = {
			userindex: $(this).data('userindex'),
			action: 'approve_agent',
			nonce: rem_agents_vars.nonce_approve
		}

		$.post(ajaxurl, data, function(resp) {
			swal("Approved!", "Agent is approved.", "success");
			window.location.reload();
		});
	});
});