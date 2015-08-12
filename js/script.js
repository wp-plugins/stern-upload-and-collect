jQuery(document).ready(function($){
	// assign function to onclick property of checkbox
	var renewableCheckBox = document.getElementById('renewable')
	if (renewableCheckBox != null) {
		document.getElementById('renewable').onclick = function() {
			// call toggleSub when checkbox clicked
			// toggleSub args: checkbox clicked on (this), id of element to show/hide
			toggleSub(this, 'active_sub');
		};

		// called onclick of checkbox
		function toggleSub(box, id) {
			// get reference to related content to display/hide
			var el = document.getElementById(id);
			
			if ( box.checked ) {
				el.style.display = 'block';
			} else {
				el.style.display = 'none';
			}
		}
	}
});


jQuery(document).ready(function($){
	// assign function to onclick property of checkbox
	var showSearchOptionsCheckBox = document.getElementById('showSearchOptions')
	if (showSearchOptionsCheckBox != null) {
		document.getElementById('showSearchOptions').onclick = function() {
			// call toggleSub when checkbox clicked
			// toggleSub args: checkbox clicked on (this), id of element to show/hide
			toggleSub(this, 'active_sub');
		};

		// called onclick of checkbox
		function toggleSub(box, id) {
			// get reference to related content to display/hide
			var el = document.getElementById(id);
			
			if ( box.checked ) {
				el.style.display = 'block';
			} else {
				el.style.display = 'none';
			}
		}
	}
});



/*
jQuery(document).ready(function($){


	$("button").click(function() {
		alert(this.id);
		
		
		
		jQuery.post(
			ajaxurl,
			{
				'action': 'mon_action',
				'param': 'coucou'
			},
			function(response){
					console.log(response);
				}
		);

	
	
	});
	
	


});

*/	





