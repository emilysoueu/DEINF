<?php
/**
 * Talon Theme Customizer.
 *
 * @package Talon
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function talon_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_section( 'header_image' )->panel         = 'talon_header_panel';
    $wp_customize->get_section( 'header_image' )->priority      = '12';

    //Titles
    class Talon_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3 style="margin-top:15px;border-bottom:2px solid;padding-bottom:5px;color:#53677b;text-transform:uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }    

	//Get defaults
	$defaults = talon_customizer_defaults();

	/**
	 * Header
	 */
    $wp_customize->add_panel( 'talon_header_panel', array(
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Header area', 'talon'),
    ) );
    $wp_customize->add_section(
        'talon_header_type',
        array(
            'title'         => __('Header type', 'talon'),
            'priority'      => 10,
            'panel'         => 'talon_header_panel', 
        )
    );
    //Front page
    $wp_customize->add_setting(
        'front_header_type',
        array(
            'default'           => $defaults['front_header_type'],
            'sanitize_callback' => 'talon_sanitize_header',
        )
    );
    $wp_customize->add_control(
        'front_header_type',
        array(
            'type'        => 'radio',
            'label'       => __('Homepage header type', 'talon'),
            'section'     => 'talon_header_type',
            'description' => __('This option refers only to your homepage', 'talon'),
            'choices' => array(
                'has-slider'    => __('Slider', 'talon'),            	
                'has-image'     => __('Image', 'talon'),
                'has-video'     => __('Video', 'talon'),
                'nothing'       => __('Only menu', 'talon')
            ),
        )
    );
    //Site
    $wp_customize->add_setting(
        'site_header_type',
        array(
            'default'           => $defaults['site_header_type'],
            'sanitize_callback' => 'talon_sanitize_header',
        )
    );
    $wp_customize->add_control(
        'site_header_type',
        array(
            'type'        => 'radio',
            'label'       => __('Site header type', 'talon'),
            'section'     => 'talon_header_type',
            'description' => __('This option refers to all pages except your homepage', 'talon'),
            'choices' => array(
                'has-slider'    => __('Slider', 'talon'),            	
                'has-image'     => __('Image', 'talon'),
                'has-video'     => __('Video', 'talon'),              
                'nothing'       => __('Only menu', 'talon')
            ),
        )
    );

    //___Slider___//
    $wp_customize->add_section(
        'talon_slider',
        array(
            'title'         => __('Header Slider', 'talon'),
            'description'   => __('Configure your header slider here, then go to <strong>Header Area > Header Type</strong> and choose where you want to display it.', 'talon'),
            'priority'      => 11,
            'panel'         => 'talon_header_panel',
        )
    );
    //Speed
    $wp_customize->add_setting(
        'slider_speed',
        array(
            'default' => $defaults['slider_speed'],
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'slider_speed',
        array(
            'label' => __( 'Slider speed', 'talon' ),
            'section' => 'talon_slider',
            'type' => 'number',
            'description'   => __('Slider speed in miliseconds [default: 4000]', 'talon'),       
            'priority' => 7
        )
    );
	for ($c = 1; $c <= 3; $c++) {
	    $wp_customize->add_control( new Talon_Info( $wp_customize, 'slide' . $c, array(
	        'label' => __('Slide ', 'talon') . $c,
	        'section' => 'talon_slider',
	        'settings' => array(),
	        'priority' => 10
	        ) )
	    );

	    $wp_customize->add_setting(
	        'slide_image_' . $c,
	        array(
	            'default' => $defaults['slide_image_' . $c],
	            'sanitize_callback' => 'esc_url_raw',
	        )
	    );
	    $wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	        	'slide_image_' . $c,
	            array(
	               'label'     => __( 'Upload your image', 'talon' ),
	               'type'      => 'image',
	               'section'   => 'talon_slider',
	               'priority'  => 10,
	            )
	        )
	    );
	    $wp_customize->add_setting(
	        'slide_title_' . $c,
	        array(
	            'sanitize_callback' => 'talon_sanitize_text',
	        )
	    );
	    $wp_customize->add_control(
	        'slide_title_' . $c,
	        array(
	            'label' 	=> __( 'Slide title', 'talon' ),
	            'section' 	=> 'talon_slider',
	            'type' 		=> 'text',
	            'priority' 	=> 10
	        )
	    );
	    $wp_customize->add_setting(
	        'slide_subtitle_' . $c,
	        array(
	            'sanitize_callback' => 'talon_sanitize_text',
	        )
	    );
	    $wp_customize->add_control(
	        'slide_subtitle_' . $c,
	        array(
	            'label' 	=> __( 'Slide subtitle', 'talon' ),
	            'section' 	=> 'talon_slider',
	            'type' 		=> 'text',
	            'priority' 	=> 10
	        )
	    );
	    $wp_customize->add_setting(
	        'slide_btn_url_' . $c,
	        array(
	            'sanitize_callback' => 'esc_url_raw',
	        )
	    );
	    $wp_customize->add_control(
	        'slide_btn_url_' . $c,
	        array(
	            'label' 	=> __( 'Button URL', 'talon' ),
	            'section' 	=> 'talon_slider',
	            'type' 		=> 'text',
	            'priority' 	=> 10
	        )
	    );
	    $wp_customize->add_setting(
	        'slide_btn_title_' . $c,
	        array(
	            'sanitize_callback' => 'talon_sanitize_text',
	        )
	    );
	    $wp_customize->add_control(
	        'slide_btn_title_' . $c,
	        array(
	            'label' 	=> __( 'Button text', 'talon' ),
	            'section' 	=> 'talon_slider',
	            'type' 		=> 'text',
	            'priority' 	=> 10
	        )
	    );  
	}

    //Menu style
    $wp_customize->add_section(
        'talon_menu_style',
        array(
            'title'         => __('Menu style', 'talon'),
            'priority'      => 16,
            'panel'         => 'talon_header_panel', 
        )
    );
    //Sticky menu
    $wp_customize->add_setting(
        'sticky_menu',
        array(
            'default'           =>  $defaults['sticky_menu'],
            'sanitize_callback' => 'talon_sanitize_sticky',
        )
    );
    $wp_customize->add_control(
        'sticky_menu',
        array(
            'type' => 'radio',
            'priority'    => 10,
            'label' => __('Sticky menu', 'talon'),
            'section' => 'talon_menu_style',
            'choices' => array(
                'sticky'   => __('Sticky', 'talon'),
                'static'   => __('Static', 'talon'),
            ),
        )
    );
    //Menu style
    $wp_customize->add_setting(
        'menu_style',
        array(
            'default'           => $defaults['menu_style'],
            'sanitize_callback' => 'talon_sanitize_menu_style',
            //'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        'menu_style',
        array(
            'type'      => 'radio',
            'priority'  => 11,
            'label'     => __('Menu style', 'talon'),
            'section'   => 'talon_menu_style',
            'choices'   => array(
                'inline'     => __('Inline', 'talon'),
                'centered'   => __('Centered', 'talon'),
            ),
        )
    );
	/**
	 * Colors
	 */
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => $defaults['primary_color'],
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label' 	=> __('Primary color', 'talon'),
                'section' 	=> 'colors',
                'priority' 	=> 11
            )
        )
    );	
    $wp_customize->add_setting(
        'site_title_color',
        array(
            'default'           => $defaults['site_title_color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_title_color',
            array(
                'label' 	=> __('Site title', 'talon'),
                'section' 	=> 'colors',
                'priority' 	=> 12
            )
        )
    );
    $wp_customize->add_setting(
        'site_desc_color',
        array(
            'default'           => $defaults['site_desc_color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_desc_color',
            array(
                'label' 	=> __('Site description', 'talon'),
                'section' 	=> 'colors',
                'priority' 	=> 13
            )
        )
    );
    $wp_customize->add_setting(
        'site_header_color',
        array(
            'default'           => $defaults['site_header_color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_header_color',
            array(
                'label' 	=> __('Header (menu background)', 'talon'),
                'section' 	=> 'colors',
                'priority' 	=> 14
            )
        )
    );    
    $wp_customize->add_setting(
        'menu_items_color',
        array(
            'default'           => $defaults['menu_items_color'],
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_items_color',
            array(
                'label' 	=> __('Menu items', 'talon'),
                'section' 	=> 'colors',
                'priority' 	=> 15
            )
        )
    );
    $wp_customize->add_setting(
        'header_text_color',
        array(
            'default'           => $defaults['header_text_color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_text_color',
            array(
                'label'     => __('Header text', 'talon'),
                'section'   => 'colors',
                'priority'  => 16
            )
        )
    );
    $wp_customize->add_setting(
        'header_subtext_color',
        array(
            'default'           => $defaults['header_subtext_color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_subtext_color',
            array(
                'label'     => __('Header subtext', 'talon'),
                'section'   => 'colors',
                'priority'  => 17
            )
        )
    );
    $wp_customize->add_setting(
        'footer_bg_color',
        array(
            'default'           => $defaults['footer_bg_color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_bg_color',
            array(
                'label'     => __('Footer background', 'talon'),
                'section'   => 'colors',
                'priority'  => 18
            )
        )
    );
    $wp_customize->add_setting(
        'footer_color',
        array(
            'default'           => $defaults['footer_color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_color',
            array(
                'label'     => __('Footer text color', 'talon'),
                'section'   => 'colors',
                'priority'  => 19
            )
        )
    );
    $wp_customize->add_setting(
        'body_color',
        array(
            'default'           => $defaults['body_color'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_color',
            array(
                'label'     => __('Body text color', 'talon'),
                'section'   => 'colors',
                'priority'  => 20
            )
        )
    );
	/**
	 * Fonts
	 */
    $wp_customize->add_panel( 'talon_typography_panel', array(
        'priority'       => 17,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Fonts', 'talon'),
    ) );	
    $wp_customize->add_section(
        'talon_fonts',
        array(
            'title' 	=> __('Font selection', 'talon'),
            'priority' 	=> 10,
            'panel'		=> 'talon_typography_panel',
            'description' => sprintf( '%1$s<a target="_blank" href="//fonts.google.com">%2$s</a>&#46;&nbsp;%3$s<a target="_blank" href="//athemes.com/documentation/talon">%4$s</a>',
				_x( 'Find the fonts ', 'Fonts option description', 'talon' ),
				_x( 'here', 'Fonts option description', 'talon' ),
				_x( 'If you need help, check the ', 'Fonts option description', 'talon' ),
				_x( 'documentation', 'Fonts option description', 'talon' )
			)
        )
    );
    //Body fonts family
    $wp_customize->add_setting(
        'body_font_family',
        array(
            'sanitize_callback' => 'talon_sanitize_text',
            'default' => $defaults['body_font_family'],
        )
    );
    $wp_customize->add_control(
        'body_font_family',
        array(
            'label' => __( 'Body font', 'talon' ),
            'section' => 'talon_fonts',
            'type' => 'text',
            'priority' => 12
        )
    );   
    //Headings fonts family
    $wp_customize->add_setting(
        'headings_font_family',
        array(
            'sanitize_callback' => 'talon_sanitize_text',            
            'default' => $defaults['headings_font_family'],
        )
    );
    $wp_customize->add_control(
        'headings_font_family',
        array(
            'label' => __( 'Headings font', 'talon' ),
            'section' => 'talon_fonts',
            'type' => 'text',
            'priority' => 15
        )
    );

    $wp_customize->add_setting(
        'font_weights',
        array(
            'default'           => $defaults['font_weights'],
            'sanitize_callback' => 'talon_sanitize_font_weights'
        )
    );
    $wp_customize->add_control(
        new Talon_Multiselect_Control(
            $wp_customize,
            'font_weights',
            array(
                'section' => 'talon_fonts',
                'label'   => __( 'Font weights to load', 'talon' ),
                'choices' => array(
                    '300'           => __( '300', 'talon' ),
                    '300italic'     => __( '300 italic',     'talon' ),
                    '400'           => __( '400',       'talon' ),
                    '400italic'     => __( '400 italic',     'talon' ),
                    '500'           => __( '500', 'talon' ),
                    '500italic'     => __( '500 italic', 'talon' ),
                    '600'           => __( '600', 'talon' ),
                    '600italic'     => __( '600 italic', 'talon' )
                ),
                'priority' => 16
            )
        )
    );

    $wp_customize->add_section(
        'talon_typography',
        array(
            'title'     => __('Typography', 'talon'),
            'priority'  => 11,
            'panel'     => 'talon_typography_panel',
        )
    );
    // Site title
    $wp_customize->add_setting(
        'site_title_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => $defaults['site_title_size'],
        )       
    );
    $wp_customize->add_control( 'site_title_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'talon_typography',
        'label'       => __('Site title', 'talon'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 80,
            'step'  => 1,
        ),
    ) );
    // Site desc
    $wp_customize->add_setting(
        'site_desc_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => $defaults['site_desc_size'],
        )       
    );
    $wp_customize->add_control( 'site_desc_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'talon_typography',
        'label'       => __('Site description', 'talon'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 80,
            'step'  => 1,
        ),
    ) );
    // Menu items
    $wp_customize->add_setting(
        'menu_items',
        array(
            'sanitize_callback' => 'absint',
            'default'           => $defaults['menu_items'],
        )       
    );
    $wp_customize->add_control( 'menu_items', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'talon_typography',
        'label'       => __('Menu items', 'talon'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 40,
            'step'  => 1,
        ),
    ) );
    // Body
    $wp_customize->add_setting(
        'body_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => $defaults['body_size'],
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'body_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'talon_typography',
        'label'       => __('Body (sitewide)', 'talon'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 80,
            'step'  => 1,
        ),
    ) );
    // SO titles
    $wp_customize->add_setting(
        'so_widgets_title',
        array(
            'sanitize_callback' => 'absint',
            'default'           => $defaults['so_widgets_title'],
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'so_widgets_title', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'talon_typography',
        'label'       => __('Builder section titles', 'talon'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 80,
            'step'  => 1,
        ),
    ) );
    // Index post titles
    $wp_customize->add_setting(
        'index_post_title',
        array(
            'sanitize_callback' => 'absint',
            'default'           => $defaults['index_post_title'],
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'index_post_title', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'talon_typography',
        'label'       => __('Index post titles', 'talon'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 80,
            'step'  => 1,
        ),
    ) );
    // Single post titles
    $wp_customize->add_setting(
        'single_post_title',
        array(
            'sanitize_callback' => 'absint',
            'default'           => $defaults['single_post_title'],
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'single_post_title', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'talon_typography',
        'label'       => __('Single post titles', 'talon'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 80,
            'step'  => 1,
        ),
    ) );
    // Sidebar widget titles
    $wp_customize->add_setting(
        'sidebar_widgets_title',
        array(
            'sanitize_callback' => 'absint',
            'default'           => $defaults['sidebar_widgets_title'],
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'sidebar_widgets_title', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'talon_typography',
        'label'       => __('Sidebar widget titles', 'talon'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 80,
            'step'  => 1,
        ),
    ) );

	/**
	 * Icons
	 */
    $wp_customize->add_section(
        'talon_icons',
        array(
            'title' 	=> __('Icons', 'talon'),
            'priority' 	=> 41,
            'description' => __('You can load an extra icon pack directly from a CDN by adding the URL here. Help for this is available ', 'talon') . '<a target="_blank" href="//athemes.com/documentation/talon">' . __('here', 'talon') . '</a>'
        )
    );
    $wp_customize->add_setting(
        'icons_url',
        array(
            'sanitize_callback' => 'esc_url_raw',
            'default' => '',
        )
    );
    $wp_customize->add_control(
        'icons_url',
        array(
            'label' => __( 'Icons URL', 'talon' ),
            'section' => 'talon_icons',
            'type' => 'text',
            'priority' => 10
        )
    );   
	/**
	 * Footer
	 */
    $wp_customize->add_section(
        'talon_footer',
        array(
            'title'         => __('Footer', 'talon'),
            'priority'      => 21,
        )
    );
    $wp_customize->add_setting(
        'footer_widget_areas',
        array(
            'default'           => '3',
            'sanitize_callback' => 'talon_sanitize_fwidgets',
        )
    );
    $wp_customize->add_control(
        'footer_widget_areas',
        array(
            'type'        => 'radio',
            'label'       => __('Footer widget area', 'talon'),
            'section'     => 'talon_footer',
            'description' => __('Choose the number of widget areas in the footer, then go to Appearance > Widgets and add your widgets.', 'talon'),
            'choices' => array(
                '1'     => __('One', 'talon'),
                '2'     => __('Two', 'talon'),
                '3'     => __('Three', 'talon'),
            ),
        )
    );
    /**
     * Blog
     */
    $wp_customize->add_section(
        'talon_blog',
        array(
            'title' => __('Blog options', 'talon'),
            'priority' => 19,
        )
    );  
    // Blog layout  
    $wp_customize->add_setting(
        'blog_layout',
        array(
            'default'           => 'list',
            'sanitize_callback' => 'talon_sanitize_blog',
        )
    );
    $wp_customize->add_control(
        'blog_layout',
        array(
            'type'      => 'radio',
            'label'     => __('Blog layout', 'talon'),
            'section'   => 'talon_blog',
            'priority'  => 11,
            'choices'   => array(
                'list'              => __( 'List', 'talon' ),
                'fullwidth'         => __( 'Full width (no sidebar)', 'talon' ),
                'masonry-layout'    => __( 'Masonry (grid style)', 'talon' )
            ),
        )
    );
    //Full width singles
    $wp_customize->add_setting(
        'fullwidth_single',
        array(
            'sanitize_callback' => 'talon_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'fullwidth_single',
        array(
            'type'      => 'checkbox',
            'label'     => __('Full width single posts?', 'talon'),
            'section'   => 'talon_blog',
            'priority'  => 12,
        )
    );
    //Excerpt
    $wp_customize->add_setting(
        'exc_length',
        array(
            'sanitize_callback' => 'absint',
            'default'           => $defaults['exc_length'],
        )       
    );
    $wp_customize->add_control( 'exc_length', array(
        'type'        => 'number',
        'priority'    => 13,
        'section'     => 'talon_blog',
        'label'       => __('Excerpt length', 'talon'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 200,
            'step'  => 5,
        ),
    ) );
    $wp_customize->add_setting(
        'custom_read_more',
        array(
            'sanitize_callback' => 'talon_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'custom_read_more',
        array(
            'label'         => __( 'Read more text', 'talon' ),
            'description'   => __( 'Fill this field to replace the [&hellip;] with a link', 'talon' ),
            'section'       => 'talon_blog',
            'type'          => 'text',
            'priority'      => 14
        )
     );

    //Meta
    $wp_customize->add_setting(
      'hide_meta_singles',
      array(
        'sanitize_callback' => 'talon_sanitize_checkbox',
        'default' => 0,     
      )   
    );
    $wp_customize->add_control(
      'hide_meta_singles',
      array(
        'type' => 'checkbox',
        'label' => __('Hide meta on single posts?', 'talon'),
        'section' => 'talon_blog',
        'priority' => 15,
      )
    );
    $wp_customize->add_setting(
      'hide_meta_index',
      array(
        'sanitize_callback' => 'talon_sanitize_checkbox',
        'default' => 0,     
      )   
    );
    $wp_customize->add_control(
      'hide_meta_index',
      array(
        'type' => 'checkbox',
        'label' => __('Hide meta on blog index?', 'talon'),
        'section' => 'talon_blog',
        'priority' => 16,
      )
    );    
    //Featured images
    $wp_customize->add_setting(
        'hide_featured_singles',
        array(
            'sanitize_callback' => 'talon_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'hide_featured_singles',
        array(
            'type' => 'checkbox',
            'label' => __('Hide featured images on single posts?', 'talon'),
            'section' => 'talon_blog',
            'priority' => 17,
        )
    );
}
add_action( 'customize_register', 'talon_customize_register' );

/**
 * Sanitize
 */
//Header type
function talon_sanitize_header( $input ) {
    if ( in_array( $input, array( 'has-image', 'has-slider', 'has-video', 'nothing' ), true ) ) {
        return $input;
    }
}
//Text
function talon_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
//Checkboxes
function talon_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
//Menu style
function talon_sanitize_menu_style( $input ) {
    if ( in_array( $input, array( 'inline', 'centered' ), true ) ) {
        return $input;
    }
}
//Menu style
function talon_sanitize_sticky( $input ) {
    if ( in_array( $input, array( 'sticky', 'static' ), true ) ) {
        return $input;
    }
}
//Footer widget areas
function talon_sanitize_fwidgets( $input ) {
    if ( in_array( $input, array( '1', '2', '3' ), true ) ) {
        return $input;
    }
}
//Blog layout
function talon_sanitize_blog( $input ) {
    if ( in_array( $input, array( 'list', 'fullwidth', 'masonry-layout' ), true ) ) {
        return $input;
    }
}
//Fonts
function talon_sanitize_font_weights( $input ) {

    $multi_values = !is_array( $input ) ? explode( ',', $input ) : $input;

    return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function talon_customize_preview_js() {
	wp_enqueue_script( 'talon_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'talon_customize_preview_js' );

/**
 * Load custom controls
 */
function talon_load_customize_controls() {

    require_once( trailingslashit( get_template_directory() ) . 'inc/controls/control-multicheckbox.php' );
}
add_action( 'customize_register', 'talon_load_customize_controls', 0 );
