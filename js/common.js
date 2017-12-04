 $(function() {
	
	$('header').load('header.html');
	$('footer').load('footer.html');
	
	});
// header top on scroll
	$(window).scroll(function(){
  var sticky = $('.navbar'),
      scroll = $(window).scrollTop();

  if (scroll >= 40) sticky.addClass('fixed');
  else sticky.removeClass('fixed');
});

// scoll form
$('header .query a').click(function () {
       
	   $('html, body').animate({
        scrollTop: $(".common-query-section").offset().top -100
    }, 1000);
	   
	   
	   
    });
	
	

