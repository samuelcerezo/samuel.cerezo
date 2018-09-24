<?php

define('SC_VERSION', 1.0);

add_theme_support('post-thumbnails');

register_nav_menus(
	array(
		'primary' => 'Menú principal',
	)
);

function sc_scripts()  {
	wp_enqueue_style('style', get_template_directory_uri().'/style.css', array(), uniqid());
	wp_enqueue_script('fitvid', get_template_directory_uri().'/js/jquery.fitvids.js', array('jquery'), uniqid(), true);
	wp_enqueue_script('theme', get_template_directory_uri().'/js/theme.js', array(), uniqid(), true);
	wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array('jquery'), uniqid(), true);
	wp_enqueue_style('main', get_template_directory_uri().'/css/main.css', array(), uniqid());
}

add_action('wp_enqueue_scripts', 'sc_scripts');

function sc_init() {

	$files = ['readme.html', 'wp-config-sample.php', 'licencia.txt', 'license.txt'];

	foreach ($files as $file) {
		if (file_exists(ABSPATH.$file)) {
			unlink(ABSPATH.$file);
		}
	}

}

add_action('init', 'sc_init');

function sc_fonts($controls_registry) {
	$fonts = $controls_registry->get_control('font')->get_settings('options');
	$fonts = array_merge(array('' => 'system'), $fonts);
	$controls_registry->get_control('font')->set_settings('options', $fonts);
}

add_action('elementor/controls/controls_registered', 'sc_fonts', 10, 1);

?>