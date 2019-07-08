jQuery( document ).ready( function( $ ) {
	jQuery.upp_enhanced_sortable = function() {
		var sort_list = $( '#user-profile-picture-enhanced-sortable' );
		var max_levels = 1;
		jQuery.upp_enhanced_sortable.sortable = sort_list.sortable( {
			update: function( event, ui ) {
				var $items = $( '#user-profile-picture-enhanced-sortable li' );
				if ( 0 == $items.length ) {
					return;
				}
				var new_items = {};
				var count = 0;
				$items.each( function() {
					var data = {
						id: $(this).find( '.user-profile-enhanced-social-item' ).data( 'id' ),
						order: count
					};
					new_items[count] = data;
					count++;
				} );
				var nonce = $( '#upp_add_social_network' ).val();
				var args = {
					data: new_items,
					nonce: nonce,
					action: 'sort_upp_social'
				};

				// Let's do some Ajax!
				$.post( ajaxurl, args, function( response ) {
				});

			}
		});
	};
	jQuery.upp_enhanced_sortable();
} );