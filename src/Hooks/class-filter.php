<?php
/**
 * Filter class
 *
 * @package    WordPress
 * @subpackage Arneo WordPress Theme
 */

/**
 * Filter class.
 */

namespace App\Hooks;

/**
 * Class Filter
 */
class Filter extends Hook implements HookableInterface {
	/**
	 * Do Filter.
	 *
	 * @param string $name Filter name.
	 * @param mixed  ...$params parameters.
	 *
	 * @return mixed|void
	 */
	public static function do( string $name, ...$params ) {
		do_filter( $name, ...$params );
	}

	/**
	 * Register Filter.
	 *
	 * @param string $name Filter name.
	 * @param mixed  ...$params parameters.
	 *
	 * @return mixed|void
	 */
	public static function add( string $name, ...$params ) {
		list( $callable, $priority, $args ) = self::get_parameters( $params );

		$callable = self::resolve_callable( $callable );

		add_filter( $name, $callable, $priority, $args );
	}

	/**
	 * Register array of Filters.
	 *
	 * @param array $filters array of Filters.
	 *
	 * @return mixed|void
	 */
	public static function adds( array $filters = array() ) {
		foreach ( $filters as $name => $params ) {
			self::add( $name, ...$params );
		}
	}

	/**
	 * Test if Filter exist with specific callable.
	 *
	 * @param string $name Filter name.
	 * @param null   $callable callable.
	 *
	 * @return bool|int|mixed
	 */
	public static function has( string $name, $callable = null ) {
		return has_filter( $name, $callable ?? false );
	}

	/**
	 * Remove Filter.
	 *
	 * @param string $name Filter name.
	 * @param mixed  ...$params parameters.
	 *
	 * @return mixed|void
	 */
	public static function remove( string $name, ...$params ) {
		list( $callable, $priority ) = self::get_parameters( $params );

		$callable = self::resolve_callable( $callable );

		remove_filter( $name, $callable, $priority );
	}
}
