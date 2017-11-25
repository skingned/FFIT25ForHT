// This is a wordpress plugin, it mainly set up a "sticky" sidebar(fixed)
// Author: Dylan
// Date: 2015/02/
// Blog: http://pupil.tw
// Info: Belong to wordpress theme "The Fire One"
// Function: you can fixed something like a sideabr or a scolling box on your window.

jQuery(function(){
	if (!!$('.sidebar-convertible').offset()) {
		var stickyTop = $('.sidebar-convertible').offset().top;
		$(window).scroll(function(){
			var windowTop = $(window).scrollTop();
			if (stickyTop < windowTop){
				$('.sidebar-convertible').addClass('sticky');
				$('.sidebar-convertible').width($('.sidebar-right').width());
			}
			else {
				 $('.sidebar-convertible').removeClass("sticky");
			}
		});
	}
});