<?php
/**
 * Arneo WordPress Theme functions and definitions
 *
 * @link null
 *
 * @package    WordPress
 * @subpackage Arneo WordPress Theme
 * @since      1.0.0
 */

/**
 * Entry file for Arneo WordPress Theme.
 */
//var_dump(realpath(__DIR__ . '/')); die;
require_once __DIR__ . '/../bedrock/workingdir/vendor/autoload.php';
//require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\StarterSite;
use App\Router;
use Timber\Timber;
use Symfony\Component\ErrorHandler\Debug;

if ( isset( $_SERVER['APP_DEBUG'] ) && 'production' !== WP_ENV ) {
	$debug = (bool) sanitize_text_field( wp_unslash( $_SERVER['APP_DEBUG'] ) );
}

if ( $debug ?? false ) {
	\Symfony\Component\ErrorHandler\Debug::enable();
}

define( 'THEME_VERSION', 1.0 );

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( Timber::class ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

new StarterSite();
new Router();
