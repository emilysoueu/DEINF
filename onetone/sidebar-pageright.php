<?php
 global  $onetone_page_meta;
    $right_sidebar = (isset($onetone_page_meta['right_sidebar']) && $onetone_page_meta['right_sidebar']!="")?$onetone_page_meta['right_sidebar']:'';
	 if ( $right_sidebar && is_active_sidebar( $right_sidebar ) ){
	    dynamic_sidebar( $right_sidebar );
	 }
	 elseif( is_active_sidebar( 'default_sidebar' ) ) {
	    dynamic_sidebar('default_sidebar');
	 }
	