jQuery( document ).ready( function( $ ) {
	var nonce  = $( '#_upp_migrate_posts' ).val();
	var offset = 0;
	var action = 'migrate_upp_data';
	$( '#upp-migrate' ).on( 'click', function( e ) {
		e.preventDefault();
		$( this ).attr( 'disabled', 'disabled' ).val( upp_enhanced.migrating );
		mpp_ajax_callback( {
			action: action,
			offset: offset,
			nonce: nonce
		} );
	} );

	function mpp_ajax_callback( args ) {
		$.post( ajaxurl, args, function( response ) {
			if ( response.more_posts ) {
				mpp_ajax_callback( {
					action: action,
					offset: response.offset,
					nonce: nonce
				} );
			} else {
				$('#upp-migrate').val( upp_enhanced.migrated );
				window.location.href = upp_enhanced.upp_page;
			}
		}, 'json' );
	}
} );