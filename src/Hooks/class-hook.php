<?php
/**
 * Hook class
 *
 * @package    WordPress
 * @subpackage Arneo WordPress Theme
 */

/**
 * Hook class.
 */
namespace App\Hooks;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Hook
 */
class Hook {
	/**
	 * Get parameters of Hooks.
	 *
	 * @param array $params parameters.
	 *
	 * @return array
	 * @throws \ArgumentCountError Exception.
	 */
	protected static function get_parameters( array $params = array() ) {
		if ( count( $params ) < 1 || count( $params ) > 3 ) {
			throw new \ArgumentCountError();
		}

		return array(
			$params[0],
			$params[1] ?? 10,
			$params[2] ?? 1,
		);
	}

	/**
	 * Resolve a callable.
	 *
	 * @param callable $callable callable.
	 *
	 * @return array
	 */
	protected static function resolve_callable( $callable ) {
		if ( is_string( $callable ) && false !== strpos( $callable, '::' ) ) {
			list( $class, $action ) = explode( '::', $callable );

			if ( self::$container instanceof ContainerInterface && self::$container->has( $class ) ) {
				return array( self::$container->get( $class ), $action );
			}

			if ( class_exists( $class ) ) {
				return array( new $class(), $action );
			}
		}

		return $callable;
	}
}
