jQuery( document ).ready( function( $ ) {
	var nonce  = $( '#upp_add_social_network' ).val();
	var offset = 0;
	var action = 'add_social_network';
	$( '#user-profile-enhanced-social-add' ).on( 'click', function( e ) {
		e.preventDefault();
		var $option = $( '#user-profile-enhanced-social-options option:selected' );
		var html    = '<div><i class="' + $option.data( 'icon' ) + '"></i> <input class="regular-text" type="text" value="" /> <a href="#" class="button button-secondary">' + upp_enhanced.save + '</a></div>' ;

		$( '#user-profile-picture-enhanced-social-networks' ).append( html ).find( 'input:last' ).focus();
	} );
} );