if (jQuery.cookie("showDialog") == undefined || jQuery.cookie("showDialog") == null || jQuery.cookie('showDialog') != 'false') {
	
	jQuery(document).ready(function($) {
		$('#dialog').dialog({
					width: 600,
					modal: true,
					resizable: false,
					draggable: false,
				});
	});
	jQuery.cookie("showDialog", "false", {expires: 1} ); 

 }

	
	