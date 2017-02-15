jQuery(document).ready(function($){
  //ScrollTo
  $('a[href^="#"]').not('[data-toggle]').on('click', function(event) {
      var target = $(this.getAttribute('href'));
      if( !$(this).attr('data-toggle') ){
        if( target.length ) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top
            }, 1000);
        }
        console.log('scroll!');
      }
  });

  //Language
  $('#lang-select').change(function() {
    var langVal = $('#lang-select').val();
    if (langVal == 'show-english'){
      $('.eng').show();
      $('.fra, .esp').hide();
    }
    if (langVal == 'show-french'){
      $('.fra').show();
      $('.eng, .esp').hide();
    }
    if (langVal == 'show-spanish'){
      $('.esp').show();
      $('.fra, .eng').hide();
    }
  });

  $('#cool_find_div').hide();
  $('.resource-form-bar-wrapper form [type="search"]').on('keyup', function(e) {
      e.preventDefault();
      if (e.which == 13) {
          var search_val = $(this).val();
          if (search_val) {
              $(this).parent().find('.error').remove();
              if (search_val.length < 3) {
                  $(this).parent().append('<p class="error">At least 3 character search required.</p>');
              } else {
                  $('#cool_find_div').fadeIn();
                  $('.panel-collapse').addClass('in');
                  $('#cool_find_text').val(search_val);
                  if ($('#cool_find_btn').attr('title') !== 'Close') $('#cool_find_btn').click();
                  $('#cool_find_next').click();
              }
          }
      }
  });
  $('#cool_find_btn').live('click touch', function() {
      if ($(this).attr('title') == 'Find on this page') $('.panel-collapse').removeClass('in');
  });

  //Check to see if the window is top if not then display button
	$(window).scroll(function(){
		if ($(this).scrollTop() > 500) {
			$('.btt-button').fadeIn();
		} else {
			$('.btt-button').fadeOut();
		}
	});
	//Click event to scroll to top
	$('.btt-button').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});

});
