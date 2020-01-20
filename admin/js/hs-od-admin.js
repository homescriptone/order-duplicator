(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready(function(){
		var hs_post_id;
		
		$('button#hs_od').on('click submit',function(event){
			event.preventDefault();
			hs_post_id = $('input#post_ID').val();
			$.post(hs_od_ajax_object.hs_od_ajax_url,{
				action: 'hs-duplicate-order',
				'security': hs_od_ajax_object.hs_od_ajax_security,
				post_id : hs_post_id
			}, function (response) {
				$('p.hs_od').after(response);
			});

		});	
		
	});

})( jQuery );
