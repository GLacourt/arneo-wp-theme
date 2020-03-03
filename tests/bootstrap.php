<?php
/**
 * Bootstrap File for tests.
 *
 * @package    WordPress
 * @subpackage Arneo WordPress Theme
 */

/**
 * Bootstrap File for tests.
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load plugin.
 */
function _manually_load_plugin() {
	$plugins_dir = dirname( __FILE__ ) . '/../../../plugins';
	$timber      = $plugins_dir . '/timber/timber.php';
	if ( file_exists( $timber ) ) {
		require_once $timber;
	} else {
		$timber_library = $plugins_dir . '/timber-library/timber.php';
		if ( file_exists( $timber_library ) ) {
			require_once $timber_library;
		}
	}
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );
require $_tests_dir . '/includes/bootstrap.php';
