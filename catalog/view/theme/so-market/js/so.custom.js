/* Add Custom Code Jquery
 ========================================================*/
$(document).ready(function(){
	 "use strict";
	// jQuery methods go here...

	// style for header top link
	$(".header-top-right .top-link > li").mouseenter(function(){
		$(".header-top-right .top-link > li.account").addClass('inactive');
	});
	$(".header-top-right .top-link > li").mouseleave(function(){
		$(".header-top-right .top-link > li.account").removeClass('inactive');
	});
	$(".header-top-right .top-link > li.account").mouseenter(function(){
		$(".header-top-right .top-link > li.account").removeClass('inactive');
	});
	$('.banner-slider').owlCarousel2({
		pagination: false,
		center: false,
		nav: false,
		dots: true,
		loop: true,
		slideBy: 1,
		autoplay: true,
		margin: 0,
		autoplayTimeout: 4500,
		autoplayHoverPause: true,
		autoplaySpeed: 1200,
		startPosition: 0, 
		responsive:{
			0: {
				items:1
			},
			480: {
				items:2
			},
			768: {
				items:3
			},
			991: {
				items:3
			},						
			1200: {
				items:3
			}
		}
	});
	$(function ($) {
    "use strict";
    
	$('.contentslider').each(function () {
		var $slider = $(this),
			$panels = $slider.children('div'),
			data = $slider.data(),
			$totalItem = $panels.length;
		// Apply Owl Carousel
		$slider.on("initialized.owl.carousel2", function () {
			setTimeout(function() {
			   $slider.parent().find('.loading-placeholder').hide();
			}, 1000);

		});
		$slider.owlCarousel2({
			responsiveClass: true,
			mouseDrag: true,
			video:true,
			autoWidth: (data.autowidth == 'yes') ? true : false,
			rtl: (data.rtl == 'yes') ? true : false,
			animateIn: data.transitionin,
    		animateOut: data.transitionout,
    		lazyLoad: (data.lazyload == 'yes') ? true : false,
			autoplay: (data.autoplay == 'yes') ? true : false,
			autoHeight: (data.autoheight == 'yes') ? true : false,
			autoplayTimeout: data.delay * 1000,
			smartSpeed: data.speed * 1000,
			autoplayHoverPause: (data.hoverpause == 'yes') ? true : false,
			center: (data.center == 'yes') ? true : false,
			loop: (data.loop == 'yes') ? true : false,
            dots: (data.pagination == 'yes') ? true : false,
            nav: (data.arrows == 'yes') ? true : false,
			dotClass: "owl2-dot",
			dotsClass: "owl2-dots",
            margin: data.margin,
			navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
			navClass: ["owl2-prev", "owl2-next"],
			responsive: {
				0: {
					items	: data.items_column4,
					nav		: ($totalItem > data.items_column4 && data.arrows == 'yes') ? true : false
				},
				370: {
					items	: data.items_column3,
					nav		: ($totalItem > data.items_column3 && data.arrows == 'yes') ? true : false
				},
				768: {
					items	: data.items_column2,
					nav		: ($totalItem > data.items_column2 && data.arrows == 'yes') ? true : false
				},
				992: { 
					items	: data.items_column1,
					nav		: ($totalItem > data.items_column1 && data.arrows == 'yes') ? true : false
				}
			}
		});
		

	});
});

});

