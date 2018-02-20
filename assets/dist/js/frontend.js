jQuery( document).ready( function($) {

	$('#gmtd-form').validate({
      

        submitHandler: function adminAjaxRequest( formData, action ) {
        	
        	var formData = {
				'name' : document.getElementById( 'name').value,
				'email' : document.getElementById( 'email').value,
				'phonenumber' : document.getElementById( 'phonenumber').value,
				'desiredbudget' : document.getElementById( 'desiredbudget').value,
				'message' : document.getElementById( 'message').value,
				'timedate' : document.getElementById( 'timedate').value,
			};

			$.ajax({
				type: 'POST',
				url: ajax_data.ajaxurl,
				data: {
					action: 'process_client_post',
					data: formData,
					security: ajax_data.security,
				},
				success: function(response, textStatus, XMLHttpRequest) {
					jQuery('.output').html('<div class="success">Your data has been submitted.</div>');
					jQuery( '#gmtd-form' )[0].reset();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					jQuery('.output').html('<div class="error">There was an unexpected error. Please try again.</div>');
				}
			});
		}
    });
	
	

});