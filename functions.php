<?php

define('SC_VERSION', 1.0);

add_theme_support('post-thumbnails');

register_nav_menus(
	array(
		'primary' => 'Menú principal',
	)
);

function sc_include($dir, $recursively = true) {

	if (is_dir($dir)) {

		// Variables locales
		$relative = str_replace(dirname(__FILE__).'/', '', $dir);
		$scan = scandir($dir);

		unset($scan[0], $scan[1]);

		$scan = sc_sort_array($scan, 'first');

		foreach($scan as $file) {
			if (is_dir($dir.'/'.$file) && $recursively == true) {
				sc_include($dir.'/'.$file);
			} else if (!is_dir($dir.'/'.$file)) {
				require($relative.'/'.$file);
			}
		}
	}
}

function sc_sort_array(&$array, $value) {

	if (count($array) > 0 && strpos(implode('', $array), $value) !== false) {

		// Variables globales
		$key = array_keys(preg_grep('/('.$value.')/i', $array))[0];
		$value = $array[$key];

		if($key) {
			unset($array[$key]);
		}

		array_unshift($array, $value);

	}

	return $array;

}

add_action('wp_enqueue_scripts', function() {

	wp_enqueue_style('style', get_template_directory_uri().'/style.css', array(), uniqid());
	wp_enqueue_style('fonts', get_template_directory_uri().'/fonts/css.php', array(), uniqid());
	wp_enqueue_style('main', get_template_directory_uri().'/css/main.css', array(), uniqid());

	wp_enqueue_script('fitvid', get_template_directory_uri().'/js/jquery.fitvids.js', array('jquery'), uniqid(), true);
	wp_enqueue_script('theme', get_template_directory_uri().'/js/theme.js', array(), uniqid(), true);
	wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array('jquery'), uniqid(), true);

	wp_enqueue_script('jquery-slick');

});

add_action('init', function() {

	$files = ['readme.html', 'wp-config-sample.php', 'licencia.txt', 'license.txt'];

	foreach ($files as $file) {
		if (file_exists(ABSPATH.$file)) {
			unlink(ABSPATH.$file);
		}
	}

});

add_action('elementor/controls/controls_registered', function($controls_registry) {

	$fonts = $controls_registry->get_control('font')->get_settings('options');

	foreach (scandir(get_template_directory().'/fonts') as $file) {

		if (!in_array($file, array('.', '..', 'css.php'))) {

			$fonts = array_merge(array($file => 'system'), $fonts);

		}

	}

	$controls_registry->get_control('font')->set_settings('options', $fonts);

}, 10, 1);

add_action('after_setup_theme', function() {

	if (!did_action('elementor/loaded')) {
		return;
	}

	include('elementor/init.php');

}, 50);

function sc_url($arg) {

	if (get_post_type($arg[1]) == 'attachment') {

		return wp_get_attachment_url($arg[1]);

	} else {

		if (function_exists('pll_get_post')) {
			return get_permalink(pll_get_post($arg[1]));
		} else {
			return get_permalink($arg[1]);
		}

	}

}

add_action('elementor/frontend/the_content', function($content) {

	$content = preg_replace_callback("/{{id-([0-9]+)}}/", "sc_url", $content);

	$replacements = array(
		'{{year}}' => date('Y')
	);

	$content = strtr($content, $replacements);

	return $content;
});

?>