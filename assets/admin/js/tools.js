jQuery(document).ready(function($) {
	$('.panel-body').on('click', '.rem-create-pages', function(event) {
        event.preventDefault();
        swal({
          title: "Create Basic Pages?",
          text: "If you have already created these pages, it may add duplicate entries.",
          icon: "warning",
          buttons: true,
          dangerMode: false,
        })
        .then((createPages) => {
        	if(createPages){
				swal('Please Wait', 'Creating Pages...', 'info');
				$.post(ajaxurl, {
            action: 'rem_create_pages_auto',
            nonce: rem_tools_var.nonce_pages
          }, function(resp) {
					swal('Done', 'Pages are created!', 'success');
					setTimeout(function() {
						window.location.reload();
					}, 2000);
				});
        	}
        });
	});

  $('.rem-activate-license').submit(function(event) {
    event.preventDefault();
    swal('Please Wait', 'Activating your license...', 'info');
    var data = $(this).serialize();
    $.post(ajaxurl, data, function(results) {
        // console.log(results);
          swal(results.title, results.message, results.status);
          if (results.status == 'success') {
              setTimeout(function() {
                window.location.reload();
              }, 50);
          }
    }, 'json');
    
  });

  $('.panel-body').on('click', '.rem-deactivate', function(event) {
    event.preventDefault();
    swal({
      title: "Are you sure?",
      text: "Once de-activate, you will need the purchase code to activate again.",
      icon: "warning",
      buttons: true,
      dangerMode: false,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.post(ajaxurl, {action: 'rem_remove_pcode', nonce: rem_tools_var.nonce_pages }, function(results) {
            // console.log(results);
              swal(results.title, results.message, results.status);
              if (results.status == 'success') {
                  setTimeout(function() {
                    window.location.reload();
                  }, 50);
              }
        }, 'json');
      }
    });
  });
  setTimeout(function() {
    $('.ich-settings-main-wrap').find('.notice').hide();
  }, 10);
});