jQuery(function($){
	var wp_inline_edit_function = inlineEditPost.edit;

	inlineEditPost.edit = function( post_id ) {

		wp_inline_edit_function.apply( this, arguments );

		var id = 0;
		if ( typeof( post_id ) == 'object' ) {
			id = parseInt( this.getId( post_id ) );
		}

		if ( id > 0 ) {

			// add rows to variables
			var specific_post_edit_row = $( '#edit-' + id ),
			    specific_post_row = $( '#post-' + id );
				$.each(rem_qe_fields, function(index, fieldName) {
					if(fieldName == 'property_price'){
						var fieldValue = $( '.column-'+fieldName, specific_post_row ).find('.rem-price-int').text();
					} else {
						var fieldValue = $( '.column-'+fieldName, specific_post_row ).text();
					}
					$( ':input[name="rem_property_data['+fieldName+']"]', specific_post_edit_row ).val( fieldValue );
				});
		}
	}

	$( 'body' ).on( 'click', 'input[name="bulk_edit"]', function() {

		$( this ).after('<span class="spinner is-active"></span>');

		var bulk_edit_row = $( 'tr#bulk-edit' ),
		    post_ids = new Array(),
		    remSaveData = new Array();

		$.each(rem_qe_fields, function(index, fieldName) {
			var tempobj = {
				key: fieldName,
				value:  bulk_edit_row.find( ':input[name="rem_property_data['+fieldName+']"]' ).val()
			}
			remSaveData.push(tempobj);
		});

		bulk_edit_row.find( '#bulk-titles' ).children().each( function() {
			post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
		});
		
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'rem_save_bulk_edit',
				post_ids: post_ids,
				save_data: JSON.stringify(remSaveData),
				nonce: $('#_rem_quick_edit_nonce').val()
			}
		});
	});
});