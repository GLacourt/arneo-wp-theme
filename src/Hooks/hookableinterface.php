<?php
/**
 * Hookable Interface
 *
 * @package    WordPress
 * @subpackage Arneo WordPress Theme
 */

/**
 * Hookable Interface.
 */

namespace App\Hooks;

/**
 * Interface HookableInterface
 */
interface HookableInterface {
	/**
	 * Do Hook.
	 *
	 * @param string $name Hook name.
	 * @param mixed  ...$params parameters.
	 *
	 * @return mixed|void
	 */
	public static function do( string $name, ...$params );

	/**
	 * Register Hook.
	 *
	 * @param string $name Hook name.
	 * @param mixed  ...$params parameters.
	 *
	 * @return mixed|void
	 */
	public static function add( string $name, ...$params );

	/**
	 * Register array of Hooks.
	 *
	 * @param array $hooks array of Hooks.
	 *
	 * @return mixed|void
	 */
	public static function adds( array $hooks );

	/**
	 * Test if Hook exist with specific callable.
	 *
	 * @param string $name Hook name.
	 * @param null   $callable callable.
	 *
	 * @return bool|int|mixed
	 */
	public static function has( string $name, $callable = null );

	/**
	 * Remove Hook.
	 *
	 * @param string $name Hook name.
	 * @param mixed  ...$params parameters.
	 *
	 * @return mixed|void
	 */
	public static function remove( string $name, ...$params );
}
