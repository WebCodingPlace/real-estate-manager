jQuery(document).ready(function($) {
    $('.hard-coded-list .trigger-sort').removeClass('btn btn-default');
    $('.hard-coded-list [data-type="password"]').hide();
    $('.hard-coded-list [data-type="image"]').hide();

    var fields_panel_width = $('.hard-coded-list .panel:first-child').width();
    var settings_panel_width = $('.form-meta-setting .panel:first-child').width();

    $(".hard-coded-list .panel").draggable({
        connectToSortable : ".form-meta-setting",
        helper : "clone",
        start : function(event, ui) {
                ui.helper.css('max-width', fields_panel_width);
             },
        revert : "invalid",
        stop : function(event, ui) {
            $('.form-meta-setting').find('.panel').removeClass('ui-draggable ui-draggable-handle').css({
                width: 'auto',
                height: 'auto'
            });
            ui.helper.find('.trigger-sort').addClass('btn btn-default');
            ui.helper.find('.glyphicon-menu-down').addClass('glyphicon-menu-up').removeClass('glyphicon-menu-down');
            setTimeout(function() {
                ui.helper.find('.inside-contents').show();
            }, 500);
        }
    });

    $(".form-meta-setting")
    .sortable({
        axis: "y",
        revert : true,
        handle: ".trigger-sort",
        placeholder: "ui-state-highlight",
        start: function( event, ui ){
            ui.helper.css('max-width', settings_panel_width);
        },
        stop: function( event, ui ) {
            ui.item.children( ".panel-heading" ).triggerHandler( "focusout" );
        }
    });

    $('.form-meta-setting').on('click', '.trigger-toggle', function(event) {
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

    $('.form-meta-setting').on('click', '.remove-field', function(event) {
        event.preventDefault();
        var field_title = $(this).closest('.panel-heading').find('b').text().replace(' - ', '');
        swal({
          title: "Delete "+field_title+" field?",
          text: "Once deleted, you will not be able to recover this field!",
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
    
    $('.ich-settings-main-wrap').on('click', '.rem-save-settings', function(e) {
        e.preventDefault();
        swal('Please Wait', "Saving settings...", 'info');
        var ListData = [];
        $('.form-meta-setting .panel').each(function(index, el) {
            var dataType = $(this).data('type');

            if (dataType == 'checkbox' || dataType == 'textarea' || dataType == 'text' || dataType == 'number' || dataType == 'email' || dataType == 'password' || dataType == 'image') {
                var singleField = {
                    key: $(this).find('.field_key').val(),
                    type: dataType,
                    tab: $(this).find('.field_tab').val(),
                    title: $(this).find('.field_title').val(),
                    help: $(this).find('.field_help').val(),
                    icon_class: $(this).find('.field_icon_class').val(),
                    max_upload_size: $(this).find('.field_max_upload_size').val(),
                    file_types: $(this).find('.field_file_types').val(),
                    display: $(this).find(".field_display:checked").map(function(){
                        return $(this).val();
                    }).get(),
                    required: $(this).find('.field_required').is(':checked') ? true : false,
                };

                ListData.push(singleField);
            };

            if (dataType == 'select') {
                var singleField = {
                    key: $(this).find('.field_key').val(),
                    type: dataType,
                    tab: $(this).find('.field_tab').val(),
                    title: $(this).find('.field_title').val(),
                    options: $(this).find('.field_options').val(),
                    help: $(this).find('.field_help').val(),
                    required: $(this).find('.field_required').is(':checked') ? true : false,
                    display: $(this).find(".field_display:checked").map(function(){
                        return $(this).val();
                    }).get(),
                };

                ListData.push(singleField);
            };


        });

        var data = {
            action: 'wcp_rem_save_custom_agent_fields',
            fields: ListData,
            nonce: rem_agent_fields_var.nonce,
        }
        $.post(ajaxurl, data, function(resp) {
            swal(resp.title, resp.message, resp.status);
        }, 'json');
    });

    $('.ich-settings-main-wrap').on('click', '.rem-reset-settings', function(e) {
        event.preventDefault();
        swal({
          title: "Are you sure?",
          text: "Once reset, you will not be able to recover custom fields!",
          icon: "warning",
          buttons: true,
          dangerMode: false,
        })
        .then((willDelete) => {
          if (willDelete) {
            var data = {
                action: 'wcp_rem_reset_custom_agent_fields',
                reset: 'yes',
                nonce: rem_agent_fields_var.nonce,
            }
            $.post(ajaxurl, data, function(resp) {
                swal("Reset is Done!", {
                  icon: "success",
                });
                window.location.reload();
            });
          }
        });
    });

    $('.form-meta-setting').on('keyup', 'input.field_title', function() {
        var input_val = $(this).val();
        var parent = $(this).closest('.panel');
        parent.find('.panel-heading b').text(input_val+' - ');
    });

    $('.form-meta-setting').on('blur', 'input.field_title', function() {
        if ($(this).closest('.inside-contents').find('.field_key').val() == '') {
            var data_name = $(this).val().replace(/[^a-z0-9\s]/gi, '').replace(/[-\s]/g, '_');
            $(this).closest('.inside-contents').find('.field_key').val(data_name.toLowerCase());
        }
    });
});