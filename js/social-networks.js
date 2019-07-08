jQuery( document ).ready( function( $ ) {
	var nonce  = $( '#upp_add_social_network' ).val();
	var action = 'add_upp_social';
	var user_id = $( '#metronet_profile_id' ).val();

	// Add a social network item
	$( '#user-profile-enhanced-social-add' ).on( 'click', function( e ) {
		e.preventDefault();
		var $button  = $( this ).attr( 'disabled', 'disabled' );
		$( '#user-profile-enhanced-spinner' ).show();
		var $option  = $( '#user-profile-enhanced-social-options option:selected' );
		var $options = $( '.user-profile-enhanced-social-item' );
		var order = $options.length;
		var icon = $option.data( 'icon' );
		var slug = $option.val();
		var label = $option.html();

		var args = {
			order: order,
			nonce: nonce,
			icon: icon,
			slug: slug,
			label: label,
			user_id: user_id,
			action: 'add_upp_social'
		};

		// Let's do some Ajax!
		$.post( ajaxurl, args, function( response ) {
			$button.removeAttr( 'disabled' );
			$( '#user-profile-enhanced-spinner' ).hide();
			$( '#user-profile-picture-enhanced-social-networks' ).append( response ).find( 'input:last' ).focus();
		});
	} );

	// Remove a social network item
	$( '#user-profile-picture-enhanced-social-networks' ).on( 'click', '.user-profile-enhanced-social-item-remove', function( e ) {
		e.preventDefault();
		var $input = jQuery( this ).parent( '.user-profile-enhanced-social-item' );
		var profile_id = $input.data( 'id' );
		var args = {
			nonce: nonce,
			id: profile_id,
			action: 'remove_upp_social'
		};
		$.post( ajaxurl, args, function( response ) {
			$input.remove();
		});
	} );

	// Remove a social network item
	$( '#user-profile-picture-enhanced-social-networks' ).on( 'click', '.user-profile-enhanced-social-item-save', function( e ) {
		e.preventDefault();
		var $input = jQuery( this ).parent( '.user-profile-enhanced-social-item' );
		var profile_id = $input.data( 'id' );
		var url = $input.find( '.user-profile-enhanced-url' ).val();
		var args = {
			nonce: nonce,
			id: profile_id,
			url: url,
			action: 'save_upp_social'
		};
		$.post( ajaxurl, args, function( response ) {
		});
	} );
} );