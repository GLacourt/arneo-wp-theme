<?php
/**
 * Action class
 *
 * @package    WordPress
 * @subpackage Arneo WordPress Theme
 */

/**
 * Action class.
 */

namespace App\Hooks;

/**
 * Class Action
 */
class Action extends Hook implements HookableInterface {
	/**
	 * Do Action.
	 *
	 * @param string $name Action name.
	 * @param mixed  ...$params parameters.
	 *
	 * @return mixed|void
	 */
	public static function do( string $name, ...$params ) {
		do_action( $name, ...$params );
	}

	/**
	 * Register Action.
	 *
	 * @param string $name Action name.
	 * @param mixed  ...$params parameters.
	 *
	 * @return mixed|void
	 */
	public static function add( string $name, ...$params ) {
		list( $callable, $priority, $args ) = self::get_parameters( $params );

		$callable = self::resolve_callable( $callable );

		add_action( $name, $callable, $priority, $args );
	}

	/**
	 * Register array of Actions.
	 *
	 * @param array $actions array of Actions.
	 *
	 * @return mixed|void
	 */
	public static function adds( array $actions = array() ) {
		foreach ( $actions as $name => $params ) {
			self::add( $name, ...$params );
		}
	}

	/**
	 * Test if Action exist with specific callable.
	 *
	 * @param string $name Action name.
	 * @param null   $callable callable.
	 *
	 * @return bool|int|mixed
	 */
	public static function has( string $name, $callable = null ) {
		return has_action( $name, $callable ?? false );
	}

	/**
	 * Remove Action.
	 *
	 * @param string $name Action name.
	 * @param mixed  ...$params parameters.
	 *
	 * @return mixed|void
	 */
	public static function remove( string $name, ...$params ) {
		list( $callable, $priority ) = self::get_parameters( $params );

		$callable = self::resolve_callable( $callable );

		remove_action( $name, $callable, $priority );
	}
}
