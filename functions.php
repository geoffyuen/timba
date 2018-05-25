<?php
// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
// Add default posts and comments RSS feed links to head
// add_theme_support( 'automatic-feed-links' );


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



function my_assets() {
	// Configure your assets:
	$ass = [
		// [	'css' => 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css',
		// 	'js' => 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js',
		// 	'dep' => ['jquery'],
		// ],
		// [	'js' => 'https://cdnjs.cloudflare.com/ajax/libs/sticky-kit/1.1.3/sticky-kit.min.js',
		// 	'dep' => ['jquery'],
		// ],
		// [	'css' => 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.css',
		// 	'js' => 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.js',
		// ],
		[	'css' => '/style.css',
			'js' => '/js/main.js',
			'dep' => ['jquery'],
		],
	];
	// All done no more tinkering necessary.

	// Loop through array and enqueue assets
	foreach ( $ass as $idx => $asset ) {
		// Create defaults if not specified:
		$dep = array_key_exists('dep', $asset) ? $asset['dep'] : array();
		$in_footer = array_key_exists('in_footer', $asset) ? $asset['in_footer'] : true;
		$media = array_key_exists('media', $asset) ? $asset['media'] : false;

		// if asset is a url, use version number or generate a "random" numeric one from the handle
		// else? then assume local file relative to theme, convert path to uri and generate version from filetime
		if ( array_key_exists('css', $asset) ) {
			$handle = array_key_exists('handle', $asset) ? $asset['handle'] : 'style' . $idx;
			if (filter_var($asset['css'], FILTER_VALIDATE_URL)) {
				$version = array_key_exists('version', $asset) ? $asset['version'] : crc32($asset['css']);
			} else {
				$version = array_key_exists('version', $asset) ? $asset['version'] : filemtime(get_stylesheet_directory() . $asset['css']);
				$asset['css'] = get_stylesheet_directory_uri() . $asset['css'];
			}
			wp_enqueue_style( $handle, $asset['css'], $media, $version );
		}
		if ( array_key_exists('js', $asset) ) {
			$handle = array_key_exists('handle', $asset) ? $asset['handle'] : 'scriptjs' . $idx;
			if (filter_var($asset['js'], FILTER_VALIDATE_URL)) {
				$version = array_key_exists('version', $asset) ? $asset['version'] : crc32($asset['js']);
			} else {
				$version = array_key_exists('version', $asset) ? $asset['version'] : filemtime(get_template_directory() . $asset['js']);
				$asset['js'] = get_template_directory_uri() . $asset['js'];
			}
			wp_enqueue_script( $handle, $asset['js'], $dep, $version, $in_footer );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'my_assets' );




// SHORTCODE
// function weather_shortcode( $atts ){
// 	return '<p id="greeting" class="tdkrblue t14"></p>';
// }
// add_shortcode( 'weather', 'weather_shortcode' );


// TIMBER
include_once("includes/timber.php");


// ACF
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}