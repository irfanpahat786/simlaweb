<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/bootstrap-select.min.js"></script> 
<script src="js/common.js"></script> 
<script src="owl-carousel/owl.carousel.min.js"></script> 
<!--<script src="https://cdn.rawgit.com/diazemiliano/googlemaps-scrollprevent/v.0.6.5/dist/googlemaps-scrollprevent.min.js"></script>--> 

<!-- Frontpage Demo --> 
<script>

    $(document).ready(function($) {
		
		var owl = $("#textmonia-carousel");
 
		  owl.owlCarousel({
			  items : 2, //10 items above 1000px browser width
			  itemsDesktop : [1000,3], //5 items between 1000px and 901px
			  itemsDesktopSmall : [900,2], // betweem 900px and 601px
			  itemsTablet: [600,1], //2 items between 600 and 0
			  itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
			  navigation : false,
			navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
			pagination : false,
		  });
		  
		  
		
		
   $(".navbar-toggle").on("click", function () {
				    $(this).toggleClass("active");
			  });
			  
			  $('ul.nav li.dropdown').hover(function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(300);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(300);
});


    });
	
	    $(window).scroll(function() {
  $(".slideanim").each(function(){
    var pos = $(this).offset().top;

    var winTop = $(window).scrollTop();
    if (pos < winTop + 600) {
      $(this).addClass("slide");
    }
  });
});

<!-- read more and read less -->
    
    $(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 80;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Read more";
    var lesstext = "Read less";
   

    $('.more').each(function() {
        var content = $(this).html();
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
	
	
	</script>