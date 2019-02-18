/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

    wp.customize('body_size',function( value ) {
        value.bind( function( newval ) {
            $('body').css('font-size', newval + 'px' );
        } );
    });	
    wp.customize('so_widgets_title',function( value ) {
        value.bind( function( newval ) {
            $('.so-panel .widget-title').css('font-size', newval + 'px' );
        } );
    });
    wp.customize('index_post_title',function( value ) {
        value.bind( function( newval ) {
            $('.post-item .post-content .entry-title').css('font-size', newval + 'px' );
        } );
    });
    wp.customize('single_post_title',function( value ) {
        value.bind( function( newval ) {
            $('.single .entry-header .entry-title').css('font-size', newval + 'px' );
        } );
    });
    wp.customize('sidebar_widgets_title',function( value ) {
        value.bind( function( newval ) {
            $('.widget-area .widget-title span').css('font-size', newval + 'px' );
        } );
    });

	wp.customize( 'site_title_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).css('color', to );
		} );
	} );
	wp.customize( 'site_desc_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).css('color', to );
		} );
	} );
	wp.customize( 'site_header_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-header' ).css('background-color', to );
		} );
	} );   
	wp.customize( 'header_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.main-slider-caption h1' ).css('color', to );
		} );
	} ); 
	wp.customize( 'header_subtext_color', function( value ) {
		value.bind( function( to ) {
			$( '.main-slider-caption p' ).css('color', to );
		} );
	} ); 
	wp.customize( 'footer_bg_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-footer' ).css('background-color', to );
		} );
	} ); 
	wp.customize( 'footer_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-footer, .site-footer a' ).css('color', to );
		} );
	} ); 
	wp.customize( 'body_color', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css('color', to );
		} );
	} ); 	

} )( jQuery );
