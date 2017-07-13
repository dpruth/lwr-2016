(function ($) {
		
    $(window).scroll(function () {
        var scrHt = $(window).scrollTop();

        // Persistent Scrolling Navigation
        if (scrHt > 137) {
            $("nav#main-nav").addClass("scrolled");
        }
        else {
            $("nav#main-nav").removeClass("scrolled");
        }

        // Set any object to animate with class "animated-object" and "shift"
        $(".animated-object").each(function () {
            $this = $(this);

            if ($this.offset() != null) {
                var scrLimit = $this.offset().top - 320;
                if (scrLimit < 0) {
                    scrLimit = 100;
                }
                ;	// top of page

                if (scrHt > scrLimit) {
                    $this.removeClass("shift");
                }
                else {
                    $this.addClass("shift");
                }
            }
        });
    }).trigger("scroll");


		// Video Rescale Effect
			
			function vidRescaleBack(){
				
				var w = $(window).width();
				var	h = $("#homepage-top-banner").height();

				yt-player.setSize( w, h );
				yt-player.unMute();
				yt-player.seekTo(0);
				yt-player.setPlaybackRate(1);
				yt-player.playVideo();
			}
				
			$("#homepage-top-banner a").attr("href", "javascript:void(0);").attr("target", "_self").on("click", function () {
            $(this).addClass("vidplaying").children("div");
						vidRescaleBack();
        });
	
	
	/*******************************
		Resilience Wheel Script
	********************************/
	var rotArr = new Array, spinning = "", spinIntv;
		rotArr["grey"] = 81; rotArr["green"] = 31; rotArr["blue"] = 41; rotArr["orange"] = 8; rotArr["inner"] = 66;

	$(function() {
		$("div#message").hide();

		$("div#grey").on("mousedown", function() { setSpin("grey", 95) }).on("mouseout", clearSpin);
		$("div#green").on("mousedown", function() { setSpin("green", 65) }).on("mouseout", clearSpin);
		$("div#blue").on("mousedown", function() { setSpin("blue", 95) }).on("mouseout", clearSpin);
		$("div#orange").on("mousedown", function() { setSpin("orange", 70) }).on("mouseout", clearSpin);
		$("div#inner").on("mousedown", function() { setSpin("inner", 36) }).on("mouseout", clearSpin);
		$(window).on("mouseup", clearSpin);

		$("div.stressor").on("click", function() { $(this).toggleClass("activated"); });

	});

	function clearSpin() { clearInterval(spinIntv); spinning = ""; }
	function setSpin(clr, dly) { spinning = clr; spinCircle(); spinIntv = setInterval(spinCircle, dly); }
	function spinCircle() { rotArr[spinning] += 14; $("div#" + spinning).css("transform", "rotate(" + rotArr[spinning] + "deg)"); }

	
	/*****************************************
		TRACK Downloads & External Clicks in GA
	******************************************/
    jQuery(document).ready(function($) {
        var filetypes = /\.(zip|exe|pdf|doc*|xls*|ppt*|mp3)$/i;
        var baseHref = '';
        if (jQuery('base').attr('href') != undefined)
            baseHref = jQuery('base').attr('href');
        jQuery('a').each(function() {
            var href = jQuery(this).attr('href');
            if (href && (href.match(/^https?\:/i)) && (!href.match(document.domain))) {
                jQuery(this).click(function() {
                    var extLink = href.replace(/^https?\:\/\//i, '');
                    ga('send','event','External','Click',extLink);
                    if (jQuery(this).attr('target') != undefined && jQuery(this).attr('target').toLowerCase() != '_blank') {
                        setTimeout(function() { location.href = href; }, 200);
                        return false;
                    }
                });
            }
            else if (href && href.match(/^mailto\:/i)) {
                jQuery(this).click(function() {
                    var mailLink = href.replace(/^mailto\:/i, '');
                    ga('send','event','Email Link','Click',mailLink);
                });
            }
            else if (href && href.match(filetypes)) {
                jQuery(this).click(function() {
                    var extension = (/[.]/.exec(href)) ? /[^.]+$/.exec(href) : undefined;
                    var filePath = href;
                    ga('send','event','Download','Click-' + extension,filePath);
                    if (jQuery(this).attr('target') != undefined && jQuery(this).attr('target').toLowerCase() != '_blank') {
                        setTimeout(function() { location.href = baseHref + href; }, 200);
                        return false;
                    }
                });
            }
        });
    });
	
	/*****************************
		TypeKit Script
	******************************/
		try{Typekit.load({ async: true });}catch(e){}
	
})(jQuery);