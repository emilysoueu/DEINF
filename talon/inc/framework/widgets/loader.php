<?php

/**
 * Load all homepage widgets
 *
 * @package Talon
 */


/*
 * To override any of the widgets in your child theme
 * simply create a folder structure in your child like the one below 
 * and copy your desired widget file there
 */
$widgets = array('services', 'skills', 'facts', 'employees', 'portfolio', 'testimonials', 'clients', 'blog', 'button', 'social', 'video', 'separator', 'image');
foreach ( $widgets as $widget) {
	locate_template( '/inc/framework/widgets/widget-' . $widget . '.php', true, false );
}