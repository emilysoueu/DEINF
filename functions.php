<?php
  /**
   * Theme Functions
   **/
  require_once dirname( __FILE__ ) . '/lib/kirki/kirki.php';
  
  // customizer controls
  require_once dirname( __FILE__ ) . '/lib/customizer-controls/editor/editor-control.php';
  require_once dirname( __FILE__ ) . '/lib/customizer-controls/editor/editor-page.php';
  
  load_template( trailingslashit( get_template_directory() ) . 'includes/theme-functions.php' );
  
  function onetone_register_options(){
	  require_once  dirname( __FILE__ ) . '/includes/options.php';
	  }
  add_action( 'init', 'onetone_register_options' );

  global $onetone_options_saved,
  $onetone_old_version,
  $onetone_option_name,
  $onetone_model_v,
  $onetone_customizer_section,
  $onetone_options_default;
  
  $onetone_options_saved = false;
  $onetone_old_version   = false;
  $onetone_model_v       = false;
  $onetone_customizer_section  = 0;
  $onetone_option_name   = onetone_option_name();
  $onetone_options_default = onetone_theme_options();
  
  if ( $theme_options = get_option($onetone_option_name) ) {
	  
	  $onetone_options_saved = true;
	  if( (isset($theme_options['section_content_0']) && $theme_options['section_content_0'] != '') ||
		  (isset($theme_options['section_content_1']) && $theme_options['section_content_1'] != '') ||
		  (isset($theme_options['section_content_2']) && $theme_options['section_content_2'] != '') ||
		  (isset($theme_options['section_content_3']) && $theme_options['section_content_3'] != '') 
		  ){
		  
		  $onetone_old_version = true;
	  }
	  
	  if( isset($theme_options['section_content_model_0']) ||
		  isset($theme_options['section_content_model_1']) ||
		  isset($theme_options['section_content_model_2']) ||
		  isset($theme_options['section_content_model_3']) ){
		  $onetone_model_v = true;
	  }
	  
	// customizer sections version
	for( $s=0; $s<10;$s++){
		
		$have_section_title = onetone_option_saved('section_title_'.$s);
		$have_menu_title = onetone_option_saved('menu_title_'.$s);
		
		if( $have_section_title != '' || $have_menu_title != '' ){
			$onetone_customizer_section = 1;
			break;
			
		}
		
		}
  
  }

  /**
   * Theme setup
   **/
  load_template( trailingslashit( get_template_directory() ) . 'includes/theme-setup.php' );
  
  
  /**
   * Theme widget
   **/
  load_template( trailingslashit( get_template_directory() ) . 'includes/theme-widget.php' );
  
   /**
   * Woocommerce template
   **/
  if (class_exists('WooCommerce')) {
	  require_once ( get_template_directory() .'/woocommerce/config.php' );
  }
  
  
  /**
   * Include the TGM_Plugin_Activation class.
   */
  load_template( trailingslashit( get_template_directory() ) . 'includes/class-tgm-plugin-activation.php' );
  
  add_action( 'tgmpa_register', 'onetone_theme_register_required_plugins' );
  
  /**
   * Register the required plugins for this theme.
   *
   */
  function onetone_theme_register_required_plugins() {
  
	  $plugins = array(
		  array(
			  'name'     				=> __('OneTone Companion','onetone'),
			  'slug'     				=> 'onetone-companion',
			  'source'   				=> '', 
			  'required' 				=> false, 
			  'version' 				=> '1.0.3',
			  'force_activation' 		=> false,
			  'force_deactivation' 	=> false,
			  'external_url' 			=> '',
		  ),
 );

	  /**
	   * Array of configuration settings. Amend each line as needed.
	   */
	  $config = array(
		  'id'           => 'onetone-companion',
		  'default_path' => '',
		  'menu'         => 'tgmpa-install-plugins',
		  'has_notices'  => true,
		  'dismissable'  => true,
		  'dismiss_msg'  => '',
		  'is_automatic' => false,
		  'message'      => '',   
  
	  );
  
	  tgmpa( $plugins, $config );
  
  }
  
