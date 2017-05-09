if (jQuery.cookie("showDialog") == undefined || jQuery.cookie("showDialog") == null || jQuery.cookie('showDialog') != 'false') {
	
	jQuery(document).ready(function($) {
		$('#dialog').dialog({
					width: 800,
					modal: true,
					resizable: false,
					draggable: false,
				});
		$(".ui-widget-overlay").click(function(){
			$(".ui-dialog-titlebar-close").trigger('click');
		});

	});
	jQuery.cookie("showDialog", "false", {expires: 10} ); 

 }
