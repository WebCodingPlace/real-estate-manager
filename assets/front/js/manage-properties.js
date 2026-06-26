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
					swal(rem_vars.done_txt);
					window.location.reload();
				});
		    break;
		 
		    default:
		  }
		});		
	});

	$('body').on('change', '.check-all-cbs', function(event) {
		event.preventDefault();
		if ($(this).is(':checked')) {
			$('.action-cb').prop('checked', true);
		} else {
			$('.action-cb').prop('checked', false);
		}
	});

	$('.rem-publish-properties').click(function(event) {
		event.preventDefault();
		swal('Please wait...', '', 'info');
		var p_ids = [];
		$(".id-cb-wrap input:checked").each(function (){
		    p_ids.push(parseInt($(this).val()));
		});

		if (p_ids.length === 0) {
			alert('Please select properties first');
		} else {
			var rem_ajax_url = $('.rem-ajax-url').val();
			data = {
				action: 'rem_manage_my_properties',
				p_ids: p_ids,
				status: 'publish',
			}
			$.post(rem_ajax_url, data, function(resp) {
				swal('Done', '', 'success');
				window.location.reload();
			});
		}
		
	});

	$('.rem-draft-properties').click(function(event) {
		event.preventDefault();
		swal('Please wait...', '', 'info');
		var p_ids = [];
		$(".id-cb-wrap input:checked").each(function (){
		    p_ids.push(parseInt($(this).val()));
		});

		if (p_ids.length === 0) {
			alert('Please select properties first');
		} else {
			var rem_ajax_url = $('.rem-ajax-url').val();
			data = {
				action: 'rem_manage_my_properties',
				p_ids: p_ids,
				status: 'draft',
			}
			$.post(rem_ajax_url, data, function(resp) {
				swal('Done', '', 'success');
				window.location.reload();
			});
		}
	});
	if ( $.isFunction($.fn.DataTable) ) {
	    $(".table-striped").DataTable();
	    $('.search-area').html('');
	    $('.dataTables_filter').appendTo('.search-area');
	}
});