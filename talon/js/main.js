//Page Builder
jQuery(function($) {
	$('.panel-grid .panel-row-style').each( function() {
		if ( $(this).data('overlay') ) {
			$(this).append( '<div class="row-overlay"></div>' );
			var overlayColor = $(this).data('overlay-color');
			$(this).find('.row-overlay').css('background-color', overlayColor );
		}
	});

	$('.panel-grid .panel-widget-style').each( function() {
		var titleColor = $(this).data('title-color');
		var headingsColor = $(this).data('headings-color');
		if ( titleColor ) {
			$(this).find('.widget-title').css('color', titleColor );
		}
		if ( headingsColor ) {
			$(this).find('h1,h2,h3:not(.widget-title),h4,h5,h6').css('color', headingsColor );
		}			
	});
});
//Sticky menu
jQuery(function($) {
	stickyInit();
	$(window).resize(function() {
		stickyInit();
	});

	function stickyInit() {
		if ($(window).width() > 1024) {
			$('.header-sticky').sticky({topSpacing:0});
		}
	}
});
//Sliders
jQuery(function($) {
	$('.main-slider').slick({
		dots: true,
		arrows: false,
		rtl: false,
		adaptiveHeight: true,
		autoplay: true,
		autoplaySpeed: $('.main-slider').data('sliderspeed'),
		pauseOnHover: false,
		lazyLoad: 'progressive',
		useCSS: true,		
	});
});
jQuery(function($) {
	$('.testimonials-slider').slick({
		dots: true,
		arrows: false,
		rtl: false,
		adaptiveHeight: true,
  		autoplay: true,
  		autoplaySpeed: $('.testimonials-slider').data('speed'),
  		useCSS: true,	
	});
});
//Mobile menu
jQuery(function($) {

	var controller = new slidebars();
	controller.init();

	$( '.menu-btn' ).on( 'click', function ( event ) {
		$('body').toggleClass('body-overflow');
		event.stopPropagation();
		event.preventDefault();
		controller.toggle( 'main-menu' );
	} );

	$('.menu-btn').click(function(){
		$(this).toggleClass('open');
	});	

	$( '.mobile-menu li a' ).on( 'click', function ( event ) {
		controller.toggle( 'main-menu' );
		$('.menu-btn').toggleClass('open');
	} );	

	var hasChildMenu = $('.mobile-menu').find('li:has(ul)');
	hasChildMenu.children('ul').hide();
	hasChildMenu.children('a').after('<span class="btn-submenu">+</span>');
	$(document).on('click', '.btn-submenu', function(e) {
		$(this).toggleClass('active').next('ul').slideToggle(300);
		e.stopImmediatePropagation()
	});		
});

//Fit Vids
jQuery(function($) {
    $("body").fitVids(); 
});

//Video header
jQuery(function($) {
    var testMobile;
    var isMobile = {
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
    };

    testMobile = isMobile.iOS(); 
	$(window).on('ready load', function () {
		$('#wp-custom-header').fitVids();
			
		if (testMobile != null) {
			$('#wp-custom-header-video-button').css('opacity', '0');
			$('#wp-custom-header-video').prop('controls',true); 
		}	
	});
});

//Masonry
jQuery(function($) {
	var $container = $('.masonry-layout .posts-layout');
	$container.imagesLoaded( function() {
		$container.masonry({
			itemSelector: '.hentry',
			isFitWidth: true,
			animationOptions: {
				duration: 500,
				easing: 'linear',
			}
	    });
	});
});
//Portfolio
jQuery(function($) {
    if ( $('.portfolio-section').length ) {

      $('.portfolio-section').each(function() {

        var self       = $(this);
        var filterNav  = self.find('.portfolio-filter').find('a');

        var projectIsotope = function($selector){

          $selector.isotope({
            filter: '*',
            itemSelector: '.portfolio-item',
            percentPosition: true,
            animationOptions: {
                duration: 750,
                easing: 'liniar',
                queue: false,
            }
          });

        }

        self.children().find('.projects-container').imagesLoaded( function() {
          projectIsotope(self.find('.projects-container'));
        });

        $(window).load(function() {
          projectIsotope(self.find('.projects-container'));
        });

        filterNav.click(function(){
            var selector = $(this).attr('data-filter');
            filterNav.parents('li').removeClass('active');
            $(this).parents('li').addClass('active');

            self.find('.projects-container').isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'liniar',
                    queue: false,
                }
            });

            return false;

        });
      });
    }
});
//Smoothscroll
jQuery(function($) {
	$('#site-navigation a[href*="#"], .button-wrapper a[href*="#"], .header-button a[href*="#"]').on('click',function (e) {
	    var target = this.hash;
	    var $target = $(target);

		if ( $target.length ) {
	    	e.preventDefault();
			$('html, body').stop().animate({
			     'scrollTop': $target.offset().top - 100
			}, 900, 'swing');
		}
	});
});