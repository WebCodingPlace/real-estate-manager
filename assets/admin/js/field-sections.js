jQuery(document).ready(function($) {
	
	$(document).on('click', '.rem-create-field-section', function(event) {
		event.preventDefault();
		/* Act on the event */
		var panel = $('#field-sections-panel .panel').last().clone(true);
		
		$(panel).find('input,select').val('');
		$(panel).find('.panel-heading b').html('New Section');
		$(panel).find('.panel-heading span.key').html('');
		$(panel).find('.inside-contents').show();
		(panel).appendTo('#field-sections-panel');
        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
        $('#field-sections-panel .panel:last-child').effect("highlight", {color: '#0FF700'}, 2000);
	});
	
    $('#field-sections-panel').on('keyup', 'input.section_title', function() {
        var input_val = $(this).val();
        var parent = $(this).closest('.panel');
        parent.find('.panel-heading b').text(input_val+' - ');
    });
   
    $(document).on('click', '.rem-save-field-section', function(event) {
    	event.preventDefault();
    	swal('Failed!', 'This feature is available in the pro version.', 'warning');
    });

	$('#field-sections-panel').on('click', '.remove-field', function(event) {
        event.preventDefault();
        var field_title = $(this).closest('.panel-heading').find('b').text().replace(' - ', '');
        swal({
          title: "Delete "+field_title+" field?",
          text: "Once deleted, you will not be able to recover this section!",
          icon: "warning",
          buttons: true,
          dangerMode: false,
        })
        .then((willDelete) => {
          if (willDelete) {
            $(this).closest('.panel').remove();
          }
        });
    });

	$("#field-sections-panel")
     .sortable({
        axis: "y",
        revert : true,
        handle: ".trigger-sort",
        placeholder: "ui-state-highlight",
        start: function( event, ui ){
            
        },
        stop: function( event, ui ) {
            
        }
    });

    $('#field-sections-panel').on('click', '.trigger-toggle', function(event) {
        event.preventDefault();
        var toggle_btn = $(this);
        if (toggle_btn.find('span').hasClass('glyphicon-menu-down')) {
            toggle_btn.find('span').removeClass('glyphicon-menu-down');
            toggle_btn.find('span').addClass('glyphicon-menu-up');
            $(this).closest('.panel').find('.inside-contents').show();
        } else {
            toggle_btn.find('span').removeClass('glyphicon-menu-up');
            toggle_btn.find('span').addClass('glyphicon-menu-down');
            $(this).closest('.panel').find('.inside-contents').hide();
        }
    });

    $('#field-sections-panel .panel').find('.inside-contents').hide();

    $('#field-sections-panel').on('blur', 'input.section_title', function() {
        if ($(this).closest('.inside-contents').find('.section_key').val() == '') {
            var data_name = $(this).val().replace(/[^a-z0-9\s]/gi, '').replace(/[-\s]/g, '_');
            $(this).closest('.inside-contents').find('.section_key').val(data_name.toLowerCase());
        }
    });

    $(document).on('click', '.rem-reset-field-section', function(event) {
        event.preventDefault();
        swal('Failed!', 'This feature is available in the pro version.', 'warning');
    });
});