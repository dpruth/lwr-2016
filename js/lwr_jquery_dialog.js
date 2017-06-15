/**
 * lwr_jquery_dialog.js
 *
 * Handles behaviour of the jQuery UI dialog popup
 */

if (jQuery.cookie("showDialog") == undefined || jQuery.cookie("showDialog") == null || jQuery.cookie('showDialog') != 'false') {
	
	jQuery(document).ready(function($) {
		var windowWidth = jQuery(window).width();
		
		if(windowWidth <= 800) {
			var modalWidth = windowWidth * 0.8;
		} else {
			var modalWidth = 800;
		}
		
		$('#dialog').dialog({
					width: modalWidth,
					modal: true,
					resizable: false,
					draggable: false,
					position: {
						collision: "flipfit"
					}
				});
		$(".ui-widget-overlay").click(function(){
			$(".ui-dialog-titlebar-close").trigger('click');
		});

	});
	jQuery.cookie("showDialog", "false", {expires: 10} ); 

}