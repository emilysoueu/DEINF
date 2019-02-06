(function($){

//top menu
$(".site-navbar,.home-navbar").click(function(){
	$(".top-nav").toggle();
});

$('.top-nav ul li').hover(function(){
	$(this).find('ul:first').slideDown(100);
	$(this).addClass("hover");
},function(){
	$(this).find('ul').css('display','none');
	$(this).removeClass("hover");
});


$('.top-nav li ul li:has(ul)').find("a:first").append(" <span class='menu_more'>»</span> ");

var windowWidth = $(window).width(); 
if(windowWidth > 939){
	if($(".site-main .sidebar").height() > $(".site-main .main-content").height()){
		$(".site-main .main-content").css("height",($(".site-main .sidebar").height()+140)+"px");
	}
}else{
	$(".site-main .main-content").css("height","auto");
}

$(window).resize(function() {

var windowWidth = $(window).width(); 
	if(windowWidth > 939){
		if( $(".site-main .sidebar").height() > $(".site-main .main-content").height() ){
			$(".site-main .main-content").css("height",($(".site-main .sidebar").height()+140)+"px");
		}
	}else{
		$(".site-main .main-content").css("height","auto");
	}	
	if(windowWidth > 919){
		$(".top-nav").show();
	}else{
		$(".top-nav").hide();
	}
	});
	
})(jQuery);

jQuery( function( $ ) {
	// Add space for Elementor Menu Anchor link
	var selectorHeight = $('.fxd-header').height(); 		
	selectorHeight = selectorHeight - 1;
		  
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addFilter( 'frontend/handlers/menu_anchor/scroll_top_distance', function( scrollTop ) {
			return scrollTop - selectorHeight;
		} );
	} );
} );

jQuery(document).ready(function($){

	var adminbarHeight = function(){
	var stickyTop;
	if ($("body.admin-bar").length) {
        if ($(window).width() < 765) {
            stickyTop = 46;
        } else {
            stickyTop = 32;
        }
    } else {
        stickyTop = 0;
    }
	return stickyTop;
	}
	var is_rtl = false;
	var stickyTop;
	if( onetone_params.is_rtl === '1' || onetone_params.is_rtl === 'on' )
	is_rtl = true;
	stickyTop = adminbarHeight();
	
	// page height
	var page_min_height = $(window).height() - $('footer').outerHeight()- stickyTop;
		
	if($('header').length)
		page_min_height = page_min_height - $('header').outerHeight();
		
	if($('.page-title-bar').length)
		page_min_height = page_min_height - $('.page-title-bar').outerHeight();
		
	$('.page-wrap,.post-wrap').css({'min-height':page_min_height});
	
	 //slider
	if( $("section.homepage-slider .item").length >1 ){
		if( onetone_params.slide_fullheight == '1' && $(window).width() > 1024 ){
			$('section.homepage-slider').height($(window).height()-stickyTop);
			$('section.homepage-slider .item').height($(window).height()-stickyTop);
	}
	
	$("#onetone-owl-slider").owlCarousel({
		nav:(onetone_params.slider_control === '1' || onetone_params.slider_control === 'on')?true:false,
		dots:(onetone_params.slider_pagination === '1' || onetone_params.slider_pagination === 'on') == '1'?true:false,
		slideSpeed : 300,
		items:1,
		autoplay:(onetone_params.slide_autoplay === '1'|| onetone_params.slide_autoplay === 'on')?true:false,
		margin:0,
		rtl: is_rtl,
		loop:true,
		paginationSpeed : 400,
		singleItem:true,
		autoplayTimeout:parseInt(onetone_params.slideSpeed)
	});
	}
	
	$('section.video-section').parent('section.section').css({'padding':0});
	
	//related posts
	if($(".onetone-related-posts").length){
		$(".onetone-related-posts").owlCarousel({
			navigation : false, // Show next and prev buttons
			pagination: false,
			loop:false,
			items:4,
			slideSpeed : 300,
			paginationSpeed : 400,
			margin:15,
			rtl: is_rtl,
			singleItem:false,
			responsive:{
				320:{
					items:1,
					nav:false
				},
				768:{
					items:2,
					nav:false
				},
				992:{
					items:3,
					nav:false
				},
				1200:{
					items:4,
					nav:false,
				}
			}
			});
			}
	
	if($("section.homepage-slider .item").length ==1 ){
		$("section.homepage-slider .owl-carousel").show();
	}
	$(".site-nav-toggle").click(function(){
		$(".site-nav").toggle();
	});
		
	$('.menu-item-has-children > ul').before('<span class="menu-item-toggle"></span>');
	$(document).on('click', "span.menu-item-toggle",function(e){
		$(this).siblings('ul').toggle();
	});
	// retina logo
	if( window.devicePixelRatio > 1 ){
		if($('.normal_logo').length && $('.retina_logo').length){
			$('.normal_logo').hide();
			$('.retina_logo').show();
		}
		$('.page-title-bar').addClass('page-title-bar-retina');
		}
		
	//video background
		var myPlayer;
		$(function () {
		myPlayer = $("#onetone-youtube-video").YTPlayer();
		$("#onetone-youtube-video").on("YTPReady",function(e){
			$(".video-section,.video-section section").css('background', 'none');
			$(".video-section").parent('section.section').css('background', 'none');		
			$("#video-controls").show();
		});
	});
	
	// BACK TO TOP
	$(window).scroll(function(){
		if($(window).scrollTop() > 200){
			$("#back-to-top").fadeIn(200);
		} else{
			$("#back-to-top").fadeOut(200);
		}
	});
		
	$('#back-to-top, .back-to-top').click(function() {
		$('html, body').animate({ scrollTop:0 }, '800');
		return false;
	});
	
	//parallax background image
	$('.onetone-parallax').parallax("50%", 0.1);
	
	// parallax scrolling
	if( $('.parallax-scrolling').length ){
		$('.parallax-scrolling').parallax({speed : 0.15});
	}
	
	//sticky header
	$(window).scroll(function(){
		var scrollTop = $(window).scrollTop(); 
		if( $('div.fxd-header').length ){
			if (scrollTop > 0 ) {
				$('.fxd-header').css({'top':stickyTop}).show();
				$('header').addClass('fixed-header');
			}else{
				$('.fxd-header').hide();
				$('header').removeClass('fixed-header');
			}
		}
	});
	
	/* woocommerce quantity button */

	$('.quantity').each(function() {

		var spinner = $(this),
		input   = spinner.find('input[type="number"]'),
		btnUp   = spinner.find('.plus'),
		btnDown = spinner.find('.minus'),
		
		min = input.attr('min'),
		max = input.attr('max');
		
		btnUp.click(function() {
			var oldValue = parseFloat(input.val());
			if ( max !='' && oldValue >= max) {
				var newVal = oldValue;
			} else {
				var newVal = oldValue + 1;
			}
			
			spinner.find('input[type="number"]').val(newVal);
			spinner.find('input[type="number"]').trigger("change");
		
		});
		
		btnDown.click(function() {
		
			var oldValue = parseFloat(input.val());
			
			if (oldValue <= min) {
				var newVal = oldValue;
			} else {
				var newVal = oldValue - 1;
			}
			
			spinner.find('input[type="number"]').val(newVal);
			spinner.find('input[type="number"]').trigger("change");
		
		});

	});

	$('.variations_form .single_add_to_cart_button').prepend('<i class="fa fa-shopping-cart"></i> ');
	//sticky header
	$(window).scroll(function(){
		var scrollTop = $(window).scrollTop(); 
		if( $('div.fxd-header').length ){
		if (scrollTop > 0 ) { 
			$('.fxd-header').css({'top':stickyTop}).show();
			$('header').addClass('fixed-header');
		}else{
			$('.fxd-header').hide();
			$('header').removeClass('fixed-header');
			}
		}
	 });
	
	// sticky header
	$(document).on('click', "a.scroll,.onetone-nav a[href^='#']",function(e){
		if($(window).width() <= 919) {
			$(".site-nav").hide();
		}
		var selectorHeight = 0;
		if( $('.fxd-header').length )
			var selectorHeight = $('.fxd-header').outerHeight();
		var scrollTop = $(window).scrollTop(); 
		e.preventDefault();
		var id = $(this).attr('href');
		if(typeof $(id).offset() !== 'undefined'){
			var goTo = $(id).offset().top - selectorHeight - stickyTop  + 1;
			$("html, body").animate({ scrollTop: goTo }, 1000);
		}
		});
	
	$('header .site-nav ul,ul.onetone-dots').onePageNav({filter: 'a[href^="#"]',scrollThreshold:0.3,scrollSpeed:300});	
	
	// smooth scrolling  btn 
	$("div.page a[href^='#'],div.post a[href^='#'],div.home-wrapper a[href^='#'],.banner-scroll a[href^='#'],a.banner-scroll[href^='#']").on('click', function(e){
		var selectorHeight = $('header').height();   
		var scrollTop = $(window).scrollTop(); 
		e.preventDefault();
		var id = $(this).attr('href');
			
		if(typeof $(id).offset() !== 'undefined'){
			var goTo = $(id).offset().top - selectorHeight;
			$("html, body").animate({ scrollTop: goTo }, 1000);
		}
	});
	
	//prettyPhoto
	if(onetone_params.enable_image_lightbox == '1' ){
		
		$('.section-gallery').magnificPopup({
		  delegate: 'a.onetone-portfolio-image',
		  type: 'image',
		  gallery: {
      		enabled: true
    		},
		});
	}
	
	$("a[rel='prettyPhoto']").magnificPopup({type:'image'});
	
	// gallery lightbox
	//$(".gallery .gallery-item a").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
	
	if($(window).width() <1200){	
		newPercentage = (($(window).width() / 1200) * 100) + "%";
		$(".home-banner .heading-inner").css({"font-size": newPercentage});
	}
	
	$(window).on("resize", function (){
		if($(window).width() <1200){
			newPercentage = (($(window).width() / 1200) * 100) + "%";
			$(".home-banner .heading-inner").css({"font-size": newPercentage});
		}else{
			$(".home-banner .heading-inner").css({"font-size": "100%"});
		}
		});
	
	// section fullheight
	var win_height = $(window).height();
	
	$("section.fullheight").each(function(){
		var section_height = $(this).height();
		$(this).css({'height':section_height,'min-height':win_height});
		});
	   // hide animation items
	
	$('.onetone-animated').each(function(){
		if($(this).data('imageanimation')==="yes"){
			$(this).find("img,i.fa").css("visibility","hidden");	
		}
		else{
			$(this).css("visibility","hidden");	
		}
	});
	
	// section one animation
	if( $('.onetone-animated').length &&  $(window).height() > $('.onetone-animated:first').offset().top  ){
		onetone_animation($('.onetone-animated:first'));
	}
	
	// home page animation
	function onetone_animation(e){
		
		e.css({'visibility':'visible'});
			e.find("img,i.fa").css({'visibility':'visible'});	
	
			// this code is executed for each appeared element
			var animation_type       = e.data('animationtype');
			var animation_duration   = e.data('animationduration');
			var image_animation      = e.data('imageanimation');
			if(image_animation === "yes"){
							 
			e.find("img,i.fa").addClass("animated "+animation_type);
	
			if(animation_duration) {
				e.find("img,i.fa").css('-moz-animation-duration', animation_duration+'s');
				e.find("img,i.fa").css('-webkit-animation-duration', animation_duration+'s');
				e.find("img,i.fa").css('-ms-animation-duration', animation_duration+'s');
				e.find("img,i.fa").css('-o-animation-duration', animation_duration+'s');
				e.find("img,i.fa").css('animation-duration', animation_duration+'s');
			}
	
		}else{
			e.addClass("animated "+animation_type);
	
			if(animation_duration) {
				e.css('-moz-animation-duration', animation_duration+'s');
				e.css('-webkit-animation-duration', animation_duration+'s');
				e.css('-ms-animation-duration', animation_duration+'s');
				e.css('-o-animation-duration', animation_duration+'s');
				e.css('animation-duration', animation_duration+'s');
			}
		}
		}
	
	$('.onetone-animated').each(function(index, element) {
			var el = jQuery(this);
			el.waypoint(function() {onetone_animation(el);},{ triggerOnce: true, offset: '90%' });
			
		});
	
	// Counter
	$('.js-counter').counterUp({
    	delay: 20,
    	time: 2000
	});

});

