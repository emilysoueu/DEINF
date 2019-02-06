<?php
global $onetone_options_default, $onetone_homepage_actived, $onetone_customizer_section;
$option_name   = onetone_option_name();
Kirki::add_config( $option_name, array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'option',
	'option_name'   => $option_name
) );

$f = 1;
$p = 1;
$s = 1;
$section = '';
if(!$onetone_options_default)
	$options = onetone_theme_options();
else
	$options = $onetone_options_default;
  
foreach($options as $key=>$option ){

 if($option['type']=='panel'){
		$display = 1;
		
		if( $onetone_customizer_section != '1' && in_array($option['slug'],array( 'onetone_homepage_sections', 'onetone_homepage_options' ))){
			$display = 0;
			}
	}
	
	if($display == 1){

	if( $option['type']=='panel' ){
		Kirki::add_panel( $option['slug'], array(
		  'priority'    => $p,
		  'title'       => $option['label'],
		  'description' => '',
		  ) );
		  $p++;
		  $s = 1;
	}elseif($option['type']=='section'){
		
		Kirki::add_section( $option['slug'], array(
		  'title'          => $option['label'],
		  'description'    => '',
		  'panel'          => $option['panel'], 
		  'priority'       => $s,
		  'capability'     => 'edit_theme_options',
		  'theme_supports' => '',
	  ) );
	  
	$section = $option['slug'];
	$s++;
	$f = 1;
	
	}else{
		
		$default = array(
		
			'choices'         => '',
			'row_label'       => '',
			'fields'          => '',
			'active_callback' => '',
			'transport'       => 'refresh',
			'output'          => '',
			'js_vars'         => '',
			'partial_refresh' => '',
			'description'     =>''
		
		);
		
		$option = array_merge($default, $option);
			
		Kirki::add_field( $option_name, $option );
		
		$f++;
		
		}
	}
	}