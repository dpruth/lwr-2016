var rotArr = new Array, spinning = "", spinIntv;
rotArr["grey"] = 81; rotArr["green"] = 31; rotArr["blue"] = 41; rotArr["orange"] = 8; rotArr["inner"] = 66;

jQuery(function() {
	jQuery("div#message").hide();

	jQuery("div#grey").on("mousedown", function() { setSpin("grey", 95) }).on("mouseout", clearSpin);
	jQuery("div#green").on("mousedown", function() { setSpin("green", 65) }).on("mouseout", clearSpin);
	jQuery("div#blue").on("mousedown", function() { setSpin("blue", 95) }).on("mouseout", clearSpin);
	jQuery("div#orange").on("mousedown", function() { setSpin("orange", 70) }).on("mouseout", clearSpin);
	jQuery("div#inner").on("mousedown", function() { setSpin("inner", 36) }).on("mouseout", clearSpin);
	jQuery(window).on("mouseup", clearSpin);

	jQuery("div.stressor").on("click", function() { jQuery(this).toggleClass("activated"); });

});

function clearSpin() { clearInterval(spinIntv); spinning = ""; }
function setSpin(clr, dly) { spinning = clr; spinCircle(); spinIntv = setInterval(spinCircle, dly); }
function spinCircle() { rotArr[spinning] += 14; jQuery("div#" + spinning).css("transform", "rotate(" + rotArr[spinning] + "deg)"); }