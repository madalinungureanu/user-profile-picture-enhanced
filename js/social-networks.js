jQuery( document ).ready( function( $ ) {
	var nonce  = $( '#upp_add_social_network' ).val();
	var offset = 0;
	var action = 'add_social_network';
	$( '#user-profile-enhanced-social-add' ).on( 'click', function( e ) {
		e.preventDefault();
		var $option  = $( '#user-profile-enhanced-social-options option:selected' );
		var $options = $( '.user-profile-enhanced-social-item' );
		var order = $options.length;
		var html     = '<div class="user-profile-enhanced-social-item" data-order="' + order + '" data-icon="' + $option.data( 'icon' ) + '" data-id="0"><i class="' + $option.data( 'icon' ) + '"></i> <input class="regular-text" type="text" value="" placeholder="' + upp_enhanced.placeholder + '" /> <a class="user-profile-enhanced-social-item-save button button-secondary" href="#" class="button button-secondary">' + upp_enhanced.save + '</a> <a class="user-profile-enhanced-social-item-remove button button-secondary button-link-delete" href="#" class="button button-secondary">' + upp_enhanced.remove + '</a></div>';

		$( '#user-profile-picture-enhanced-social-networks' ).append( html ).find( 'input:last' ).focus();
	} );
} );