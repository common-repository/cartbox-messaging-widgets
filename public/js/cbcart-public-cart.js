(function( $ ) {
	'use strict';
	 
	 jQuery(document).on("ready",function(e){

		var timer2;
		function getFieldData() { //Reading WooCommerce field values
			if(jQuery("#billing_email").length > 0 || jQuery("#billing_phone").length > 0){ //If at least one of these two fields exist on page
				var cbcart_abandoned_email = jQuery("#billing_email").val();
				if (typeof cbcart_abandoned_email === 'undefined' || cbcart_abandoned_email === null) { //If email field does not exist on the Checkout form
				   cbcart_abandoned_email = '';
				}
				var atposition = cbcart_abandoned_email.indexOf("@");
				var dotposition = cbcart_abandoned_email.lastIndexOf(".");

				var cbcart_abandoned_phone = jQuery("#billing_phone").val();
				if (typeof cbcart_abandoned_phone === 'undefined' || cbcart_abandoned_phone === null) { //If phone number field does not exist on the Checkout form
				   cbcart_abandoned_phone = '';
				}
				
				clearTimeout(timer2);

				if (!(atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= cbcart_abandoned_email.length) || cbcart_abandoned_phone.length >= 1){ //Checking if the email field is valid or phone number is longer than 1 digit
					//If Email or Phone valid
					var cbcart_abandoned_name = jQuery("#billing_first_name").val();
					var cbcart_abandoned_surname = jQuery("#billing_last_name").val();
					var cbcart_abandoned_phone = jQuery("#billing_phone").val();
					var cbcart_abandoned_country = jQuery("#billing_country").val();
					
					var data_ = {
						action:								"cbcart_abandoned_save",
						nonce: 									cbcart_public_data.nonce,
						cbcart_abandoned_email:					cbcart_abandoned_email,
						cbcart_abandoned_name:					cbcart_abandoned_name,
						cbcart_abandoned_surname:					cbcart_abandoned_surname,
						cbcart_abandoned_phone:					cbcart_abandoned_phone,
						cbcart_abandoned_country:					cbcart_abandoned_country
					}

					timer2 = setTimeout(function(){
						$.ajax({
							type: "POST",
							url: cbcart_public_data.ajax_url,
							data: data_,
							success: function(result) {
							}
						});
						
					}, 800);
				}else{
				}
			}
		}
		
		jQuery(document).on('keyup', '#billing_phone', getFieldData);
		jQuery(document).on('keyup', '#billing_email', getFieldData);
		jQuery(document).on('keyup', '#billing_first_name', getFieldData);
		jQuery(document).on('blur', '#billing_phone', getFieldData);
		jQuery(document).on('blur', '#billing_email', getFieldData);
		jQuery(document).on('blur', '#billing_first_name', getFieldData);

		//All action happens on or after changing Email or Phone fields or any other fields in the Checkout form. All Checkout form input fields are now triggering plugin action. Data saved to Database only after Email or Phone fields have been entered.
		getFieldData(); //Automatically collect and save input field data if input fields already filled on page load
		
	});

})( jQuery );