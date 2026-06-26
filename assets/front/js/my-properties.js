jQuery(document).ready(function($) {
	$('.delete-property').click(function(event) {
		event.preventDefault();
		swal(rem_vars.confirm, {
		  buttons: {
		    cancel: rem_vars.no_txt,
		    proceed: rem_vars.yes_txt,
		  },
		})
		.then((value) => {
		  switch (value) {
		 
		    case "proceed":
				var data = {
					action: 'rem_delete_property',
					p_id: $(this).data('pid'),
				}
				$.post(rem_vars.ajaxurl, data, function(resp) {
					swal(resp);
					window.location.reload();
				});
		    break;
		 
		    default:
		  }
		});		
	});
});