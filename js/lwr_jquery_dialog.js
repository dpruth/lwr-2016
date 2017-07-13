if (jQuery.cookie("showDialog") == undefined || jQuery.cookie("showDialog") == null || jQuery.cookie('showDialog') != 'false') {
	
	jQuery('#dialog').modal({
		show: true
	});

	jQuery.cookie("showDialog", "false", {expires: 10} ); 

 }