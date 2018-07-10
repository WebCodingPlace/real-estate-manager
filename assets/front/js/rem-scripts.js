jQuery(document).ready(function($) {

	// Apply Labeluty
	jQuery(".labelauty").labelauty();

	// Apply DropDown
	jQuery(function(){
		var $selects = jQuery('.ich-settings-main-wrap select');
		$selects.easyDropDown({
			onChange: function(selected){}
		});
	});


	jQuery("#mortgage-calc", document.body).on('click', function(){

		var L, P, n, c, dp;
		L = parseInt( jQuery( "#mc-price" ).val() ,10 );
		n = parseInt( jQuery( "#mc-term" ).val() ,10 ) * 12;
		c = parseFloat( jQuery( "#mc-rate" ).val() ,10 )/1200;
		dp = 1 - parseFloat( jQuery( "#mc-down" ).val() ,10 )/100;
		L = L * dp;
		P = ( L* ( c*Math.pow( 1+c, n ) ) ) / ( Math.pow( 1 + c, n ) -1 );

		if( !isNaN( P ) ) {
			jQuery( "#mc-payment" ).text( landz_ls.currency_symbol+" " + P.toFixed(2) );
		} else {
			jQuery( "#mc-payment" ).text( "ERROR!" );
		}

		return false;

	});
		
});