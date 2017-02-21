<?php

// MENUS
register_nav_menus( array(
	'main_menu' => 'Main Menu',
	'footer_menu' => 'Footer Menu',
) );

// SIDEBARS/WIDGETS
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name'=>'Sidebar 1',
		'id' => 'sidebar-1',
	));
	register_sidebar(array(
		'name'=>'Sidebar 2',
		'id' => 'sidebar-2',
	));
}

// CSS, JS
function my_assets() {
	wp_enqueue_style( 'stylecss', get_stylesheet_uri(), array() );
	wp_enqueue_script( "sitejs", get_stylesheet_directory_uri() . "/static/site.js", array( "jquery" ), "1.12", true );
}
add_action( 'wp_enqueue_scripts', 'my_assets' );

// TIMBER
include_once("includes/timber.php");
