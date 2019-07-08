jQuery( document ).ready( function( $ ) {
	var sort_list = $( '#user-profile-picture-enhanced-sortable' );
	var max_levels = 1;
	var callback = false;
	var sort_start = {};
	var sort_end = {};
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

		},
		start: function( event, ui ) {
			sort_start.item = ui.item;
			sort_start.prev = ui.item.prev( ':not(".placeholder")' );
			sort_start.next = ui.item.next( ':not(".placeholder")' );
		}
	});
} );