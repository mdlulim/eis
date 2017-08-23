/*! Customized Jquery from Punit Korat.  punit@templatetrip.com  : www.templatetrip.com
Authors & copyright (c) 2016: TemplateTrip - Webzeel Services(addonScript). */
/*! NOTE: This Javascript is licensed under two options: a commercial license, a commercial OEM license and Copyright by Webzeel Services - For use Only with TemplateTrip Themes for our Customers*/
$(document).ready(function() {
	if ($(document).height() < 2000){
		$(".body-image-bottom-left").css('display','none');
		$(".body-image-bottom-right").css('display','none');
	}
	$( "body" ).append( "<div id='goToTop' title='Top'></div>" );
	$("#goToTop").hide();
	
	$("#top-links a.dropdown-toggle").click(function(){
			$( ".account-link-toggle" ).slideToggle( "2000" );
			$(".header-cart-toggle").slideUp("slow");
			$(".language-toggle").slideUp("slow");
			$(".currency-toggle").slideUp("slow");
		 });
			
		$("#cart button.dropdown-toggle").click(function(){
			$( ".header-cart-toggle" ).slideToggle( "2000" );														 
		   	$(".account-link-toggle").slideUp("slow");
			$(".language-toggle").slideUp("slow");
			$(".currency-toggle").slideUp("slow");
   	    });
			
		$("#form-currency button.dropdown-toggle").click(function(){
			$( ".currency-toggle" ).slideToggle( "2000" );	
			$(".language-toggle").slideUp("slow");
			$(".account-link-toggle").slideUp("slow");
			$(".header-cart-toggle").slideUp("slow");
			
    	});
		
        $("#form-language button.dropdown-toggle").click(function(){
			$( ".language-toggle" ).slideToggle( "2000" );																  
			$(".currency-toggle").slideUp("fast");
			$(".account-link-toggle").slideUp("slow");
			$(".header-cart-toggle").slideUp("slow");
       	});
	
	/*$("#form-currency button.dropdown-toggle").click(function() {
		$( ".currency-toggle" ).slideToggle( "2000" );
	});
	$("#form-language button.dropdown-toggle").click(function() {
		$( ".language-toggle" ).slideToggle( "2000" );
	});
	$("#top-links a.dropdown-toggle").click(function() {
		$( ".account-link-toggle" ).slideToggle( "2000" );
	});
	$("#cart button.dropdown-toggle").click(function() {
		$( ".header-cart-toggle" ).slideToggle( "2000" );
	});*/

	$(".option-filter .list-group-items a").click(function() {
		$(this).toggleClass('collapsed').next('.list-group-item').slideToggle();
	});
	
	$(".product-list .product-thumb .button-group button.btn-cart").removeAttr('data-original-title');
	$("ul.breadcrumb li:nth-last-child(1) a").addClass('last-breadcrumb').removeAttr('href');
	$(".special-items .product-thumb .button-group button.btn-cart").removeAttr('data-original-title');
	
	$("#column-left .products-list .product-thumb, #column-right .products-list .product-thumb").unwrap();

	$("#content > h1, .account-wishlist #content > h2, .account-address #content > h2, .account-download #content > h2").first().addClass("page-title");

	$("#content > .page-title").wrap("<div class='page-title-wrapper'><div class='container'></div></div>");
	$(".page-title-wrapper .container").append($("ul.breadcrumb"));
	
	$("body #page > .menu-container").after($("#content > .page-title-wrapper"));

	$('#column-left .product-thumb .image, #column-right .product-thumb .image').attr('class', 'image col-xs-5 col-sm-5 col-md-4');
	$('#column-left .product-thumb .thumb-description, #column-right .product-thumb .thumb-description').attr('class', 'thumb-description col-xs-7 col-sm-7 col-md-8');

		$('#content .row > .product-list .product-thumb .image').attr('class', 'image col-xs-5 col-sm-5 col-md-3');
		$('#content .row > .product-list .product-thumb .thumb-description').attr('class', 'thumb-description col-xs-7 col-sm-7 col-md-9');
		$('#content .row > .product-grid .product-thumb .image').attr('class', 'image col-xs-12');
		$('#content .row > .product-grid .product-thumb .thumb-description').attr('class', 'thumb-description col-xs-12');
		
	$('select.form-control').wrap("<div class='select-wrapper'></div>");
// Carousel Counter
colsCarousel = $('#column-right, #column-left').length;
if (colsCarousel == 2) {
	ci=2;
} else if (colsCarousel == 1) {
	ci=4;
} else {
	ci=4;
}
// product Carousel
$("#content .products-carousel").owlCarousel({
	items: ci,
	itemsDesktop : [1200,3], 
	itemsDesktopSmall : [991,3], 
	itemsTablet: [767,2], 
	itemsMobile : [480,1],
	navigation: true,
	pagination: false
});
$(".customNavigation .next").click(function(){
	$(this).parent().parent().find(".products-carousel").trigger('owl.next');
})
$(".customNavigation .prev").click(function(){
	$(this).parent().parent().find(".products-carousel").trigger('owl.prev');
})
$(".products-list .customNavigation").addClass('owl-navigation');

/*------------------end product carousol-------------*/

$("#column-left .product-thumb .button-group .btn-cart").removeAttr('data-original-title');
$(".product-details .btn-group .product-btn-wishlist").removeAttr('data-original-title');
$(".product-details .btn-group .product-btn-compare").removeAttr('data-original-title');
$(".product-details .btn-group #button-cart").removeAttr('data-original-title');

var tttestimonial = $("#tttestimonial-carousel");
      tttestimonial.owlCarousel({
     	 items : 1, //10 items above 1000px browser width
     	 itemsDesktop : [1200,1], 
     	 itemsDesktopSmall : [991,1], 
     	 itemsTablet: [767,1], 
     	 itemsMobile : [480,1],
		 navigation:false,
		 pagination:true
      });
	  
	  $(".tttestimonial-carousel").click(function(){
        tttestimonial.trigger('owl.next');
      });
      $(".tttestimonial-carousel").click(function(){
        tttestimonial.trigger('owl.prev');
      });
	  
/*-------------start blog js-----------*/
var ttblog = $("#blog-carousel");
      ttblog.owlCarousel({
     	 items : 3, //10 items above 1000px browser width
     	 itemsDesktop : [1200,3], 
     	 itemsDesktopSmall : [991,2], 
     	 itemsTablet: [767,2], 
     	 itemsMobile : [480,1],
		 navigation:true,
		 pagination:false
      });
	  
	  $(".blog_prev").click(function(){
        ttblog.trigger('owl.next');
      });
      $(".blog_next").click(function(){
        ttblog.trigger('owl.prev');
      });

/*-------------end blog js-----------*/
 
  /* ----------- Start ttcmsoffers gallary ----------- */
	 var ttcmsoffers = $("#ttcmsoffers-carousel");
      ttcmsoffers.owlCarousel({	
		 //autoPlay:true,
     	 items : 1, //10 items above 1000px browser width
     	 itemsDesktop : [1200,1], 
     	 itemsDesktopSmall : [991,1], 
     	 itemsTablet: [767,1], 
     	 itemsMobile : [480,1] 
      });
  /* ----------- Start ttcmsoffers gallary ----------- */
/* Slider Load Spinner */
$(window).load(function() { 
	$(".slideshow-panel .ttloading-bg").removeClass("ttloader");
});

/* Go to Top JS START */
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 150) {
				$('#goToTop').fadeIn();
			} else {
				$('#goToTop').fadeOut();
			}
		});
	
		// scroll body to 0px on click
		$('#goToTop').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 1000);
			return false;
		});
	});
	/* Go to Top JS END */

	/* Active class in Product List Grid START */
	$('#list-view').click(function() {
		$('#grid-view').removeClass('active');
		$('#list-view').addClass('active');
		
		$('#content .row > .product-list .product-thumb .image').attr('class', 'image col-xs-5 col-sm-5 col-md-3');
		$('#content .row > .product-list .product-thumb .thumb-description').attr('class', 'thumb-description col-xs-7 col-sm-7 col-md-9');
	});
	$('#grid-view').click(function() {
		$('#list-view').removeClass('active');
		$('#grid-view').addClass('active');
		
		$('#content .row > .product-grid .product-thumb .image').attr('class', 'image col-xs-12');
		$('#content .row > .product-grid .product-thumb .thumb-description').attr('class', 'thumb-description col-xs-12');
	});
	if (localStorage.getItem('display') == 'list') {
		$('#list-view').addClass('active');
	} else {
		$('#grid-view').addClass('active');
	}
	/* Active class in Product List Grid END */

		var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);
	if(!isMobile) {
		if($(".parallex").length){  $(".parallex").sitManParallex({  invert: false });};    
		}else{
		$(".parallex").sitManParallex({  invert: true });
	}	
});

function footerToggle() {
	if($( window ).width() < 992) {
		
		$("footer .payment-icon-inner h4").addClass( "toggle" );
		$("footer .payment-icon-inner ul").css( 'display', 'none' );
		$("footer .payment-icon-inner.active ul").css( 'display', 'block' );
		$("footer .payment-icon-inner h4.toggle").unbind("click");
		$("footer .payment-icon-inner h4.toggle").click(function() {
		$(this).parent().toggleClass('active').find('ul').slideToggle( "fast" );
		});
		
		$("footer .footer-column h5").addClass( "toggle" );
		$("footer .footer-column ul").css( 'display', 'none' );
		$("footer .footer-column.active ul").css( 'display', 'block' );
		$("footer .footer-column h5.toggle").unbind("click");
		$("footer .footer-column h5.toggle").click(function() {
			$(this).parent().toggleClass('active').find('ul.list-unstyled').slideToggle( "fast" );
		});
		
		$("#column-left .panel-heading").addClass( "toggle" );
		$("#column-left .list-group").css( 'display', 'none' );
		$("#column-left .panel-default.active .list-group").css( 'display', 'block' );
		$("#column-left .panel-heading.toggle").unbind("click");
		$("#column-left .panel-heading.toggle").click(function() {
		$(this).parent().toggleClass('active').find('.list-group').slideToggle( "fast" );
		});
		
		$("#column-left .box-heading").addClass( "toggle" );
		$("#column-left .products-carousel").css( 'display', 'none' );
		$("#column-left .products-list.active .products-carousel").css( 'display', 'block' );
		$("#column-left .box-heading.toggle").unbind("click");
		$("#column-left .box-heading.toggle").click(function() {
		$(this).parent().toggleClass('active').find('.products-carousel').slideToggle( "fast" );
		});
		
		$("#ttcmstestimonial .title_block").addClass( "toggle" );
		$("#ttcmstestimonial #tttestimonial-carousel").css( 'display', 'none' );
		$("#ttcmstestimonial .tttestimonial-inner.active tttestimonial-carousel").css( 'display', 'block' );
		$("#ttcmstestimonial .title_block.toggle").unbind("click");
		$("#ttcmstestimonial .title_block.toggle").click(function() {
		$(this).parent().toggleClass('active').find('#tttestimonial-carousel').slideToggle( "fast" );
		});
		
		$("#ttcmsoffers .title_block").addClass( "toggle" );
		$("#ttcmsoffers #ttcmsoffers-carousel").css( 'display', 'none' );
		$("#ttcmsoffers .ttcmsoffers-inner.active ttcmsoffers-carousel").css( 'display', 'block' );
		$("#ttcmsoffers .title_block.toggle").unbind("click");
		$("#ttcmsoffers .title_block.toggle").click(function() {
		$(this).parent().toggleClass('active').find('#ttcmsoffers-carousel').slideToggle( "fast" );
		});
		
	} else {
		$("footer .footer-column h5").removeClass('toggle');
		$("footer .footer-column ul.list-unstyled").css('display', 'block');
		
		$("footer .payment-icon-inner h4").removeClass( "toggle" );
		$("footer .payment-icon-inner ul").css( 'display', 'block' );
		
		$("#column-left .panel-heading").removeClass( "toggle" );
		$("#column-left .list-group").css( 'display', 'block' );
		
		$("#column-left .box-heading").removeClass( "toggle" );
		$("#column-left .products-carousel").css( 'display', 'block' );
		
		$("#ttcmstestimonial .title_block").removeClass( "toggle" );
		$("#ttcmstestimonial #tttestimonial-carousel").css( 'display', 'block' );
		
		$("#ttcmsoffers .title_block").removeClass( "toggle" );
		$("#ttcmsoffers #ttcmsoffers-carousel").css( 'display', 'block' );
		
	}
}

$(document).ready(function() {footerToggle();});
$(window).resize(function() {footerToggle();});


/* Category List - Tree View */
function categoryListTreeView() {
	$(".category-treeview li.category-li").find("ul").parent().prepend("<div class='list-tree'></div>").find("ul").css('display','none');

	$(".category-treeview li.category-li.category-active").find("ul").css('display','block');
	$(".category-treeview li.category-li.category-active").toggleClass('active');
}
$(document).ready(function() {categoryListTreeView();});


/* Category List - TreeView Toggle */
function categoryListTreeViewToggle() {
	$(".category-treeview li.category-li .list-tree").click(function() {
		$(this).parent().toggleClass('active').find('ul').slideToggle();
	});
}
$(document).ready(function() {categoryListTreeViewToggle();});
$(document).ready(function(){ menuMore(); });

function menuToggle() {
	if($( window ).width() < 992) {
		$('#column-left .main-category-list .menu-category ul.dropmenu').prependTo('.menu-container #tttoplink_block');
		$('#column-left .main-category-list .TT-panel-heading').prependTo('.menu-container #tttoplink_block');
 
		$("#tttoplink_block ul.dropmenu li.TT-Sub-List > i").remove();
		$("#tttoplink_block ul.dropmenu .dropdown-menu ul li.dropdown-inner > i").remove();

		$("#tttoplink_block ul.dropmenu li.TT-Sub-List > a").after("<i class='fa fa-angle-down'></i>");
		$("#tttoplink_block ul.dropmenu .dropdown-menu ul li.dropdown-inner a.dropdown").after("<i class='fa fa-angle-down'></i>");
		
		$('#tttoplink_block .TT-panel-heading').click(function(){
			$(this).parent().toggleClass('ttactive').find('ul.dropmenu,ul.block_content').slideToggle( "fast" );
		});

		$("#tttoplink_block ul.dropmenu li.TT-Sub-List > i").click(function() {
			$(this).parent().toggleClass('active').find(".dropdown-menu").slideToggle();
		});
		$("#tttoplink_block ul.dropmenu .dropdown-menu ul li.dropdown-inner > i").click(function() {
			$(this).parent().toggleClass('active').find("ul").slideToggle();
		});
		
	}
	else {
		$('.menu-container #tttoplink_block ul.dropmenu').appendTo('#column-left .main-category-list .menu-category');
		$('.menu-container #tttoplink_block .TT-panel-heading').prependTo('#column-left .main-category-list .menu-category');
		$('.main-category-list .menu-category ul.dropmenu li.tttoplink').prependTo('#tttoplink_block ul');
		$(".menu-category ul.dropmenu li.TT-Sub-List > i").remove();
		$(".menu-category ul.dropmenu .dropdown-menu ul li.dropdown-inner > i").remove();
	
	}
}
$(document).ready(function() {menuToggle();});
$( window ).resize(function(){menuToggle();});

/* Animate effect on Review Links - Product Page */
$(".product-total-review, .product-write-review").click(function() {
    $('html, body').animate({ scrollTop: $(".product-tabs").offset().top }, 1000);
});
/* Main Menu - MORE items */
function menuMore(){
	var max_items = 5;
	var liItems = $('.navbar-nav > li');
	var remainItems = liItems.slice(max_items, liItems.length);
	remainItems.wrapAll('<li class="dropdown more-menu"><div class="dropdown-menu"><div class="dropdown-inner"><ul class="list-unstyled childs_1">');
	$('.more-menu').prepend('<span>More</span>');
}
/* FilterBox - Responsive Content*/
function optionFilter(){

	if ($(window).width() <= 767) {
		$('#column-left .option-filter-box').appendTo('.row #content .category-list');
		$('#column-right .option-filter-box').appendTo('.row #content .category-list');
	} else {
		$('.row #content .category-list .option-filter-box').appendTo('#column-left .option-filter');
		$('.row #content .category-list .option-filter-box').appendTo('#column-right .option-filter');
	}
}
$(document).ready(function(){ optionFilter(); });
$(window).resize(function(){ optionFilter(); });

function responsivecolumn()
{
	if ($(document).width() <= 991)
	{
		$('#page > .container > .row > #column-left').appendTo('#page > .container > .row');
	}
	else if($(document).width() >= 992)
	{
		$('#page > .container > .row > #column-left').prependTo('#page > .container > .row');
	}
}
$(document).ready(function(){responsivecolumn();});
$(window).resize(function(){responsivecolumn();});

/* --------------------------- End TmplateTrip JS ------------------------------ */



