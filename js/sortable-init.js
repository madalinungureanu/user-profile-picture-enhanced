jQuery( document ).ready( function( $ ) {
	jQuery.fn.upp_enhanced_sortable = function() {
		var sort_list = $( '#user-profile-picture-enhanced-sortable' );
		var max_levels = 1;
		sort_list.nestedSortable( {
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			maxLevels: max_levels,
			opacity: .6,
			placeholder: 'ui-sortable-placeholder',
			toleranceElement: '> div',
			listType: 'ul',
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
	jQuery.fn.upp_enhanced_sortable();
} );