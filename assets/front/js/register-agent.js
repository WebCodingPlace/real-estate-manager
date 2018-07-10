jQuery(document).ready(function($) {
    $('#agent_login').submit(function(event){
        event.preventDefault();

        var redirect_after_reg = $(this).data('redirect');
        var ajaxurl = $(this).data('ajaxurl');
        var data = $(this).serialize();
        
        if ($('input[name="password"]').val() == $('input[name="repassword"]').val()) {

            $('.agent-register-info .msg').html('Please Wait...');
            $('.agent-register-info').show();
            
            $.post(ajaxurl, data, function(resp) {
                if (resp.status == 'already') {
                    $('.agent-register-info .msg').html(resp.msg);
                    $('.agent-register-info').removeClass('alert-success').addClass('alert-info');
                    $('.agent-register-info').show();
                } else if (resp.status == 'error') {
                    $('.agent-register-info .msg').html(resp.msg);
                    $('.agent-register-info').removeClass('alert-success alert-info').addClass('alert-danger');
                    $('.agent-register-info').show();
                } else {
                    $('.agent-register-info .msg').html(resp.msg);
                    $('.agent-register-info').removeClass('alert-info alert-danger').addClass('alert-success');
                    // console.log(resp);
                    if (redirect_after_reg != '' && redirect_after_reg != undefined) {
                        window.location = redirect_after_reg;
                    }
                }
            }, 'json');
        } else {
            alert('Passwords did not match!');
        }

    });
});