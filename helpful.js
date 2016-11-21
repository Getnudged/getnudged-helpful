jQuery( document ).on( 'click', '.helpful-button-y', function() {
	
	var post_id = jQuery(this).data('id');
	var user = jQuery(this).data('user');
	var stat = jQuery(this).data('stat');
	
	jQuery.ajax({
		url : helpfulajax.ajax_url,
		type : 'post',
		data : {
			action : 'helpful_ajax_form',
			post_id : post_id,
			user : user,
			stat : stat
		},
		success : function( response ) {
			jQuery('#helpful-content').html( response );
		}
	});

	return false;
})

jQuery( document ).on( 'click', '.helpful-button-n', function() {
	
	var post_id = jQuery(this).data('id');
	var user = jQuery(this).data('user');
	var stat = jQuery(this).data('stat');
	
	jQuery.ajax({
		url : helpfulajax.ajax_url,
		type : 'post',
		data : {
			action : 'helpful_ajax_form',
			post_id : post_id,
			user : user,
			stat : stat
		},
		success : function( response ) {
			jQuery('#helpful-content').html( response );
		}
	});

	return false;
})