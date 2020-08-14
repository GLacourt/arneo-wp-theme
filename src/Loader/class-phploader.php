<?php
/**
 * PHP loader Class
 *
 * @package    WordPress
 * @author     Guillaume Lacourt <guillaume.lacourt@gmail.com>
 */

/**
 * PHP loader Class Class.
 */

namespace App\Loader;

/**
 * Class PHP Loader.
 */
class PHPLoader extends ContextLoader {
	/**
	 * @inheritDoc
	 */
	public function load( $resource, string $type = null ) {
		$path = $this->locator->locate( $resource );

		$load = \Closure::bind(
			function ( $resource ) {
				return include $resource;
			},
			$this->context,
			( new \ReflectionObject( $this->context ) )->getName()
		);

		$this->context = $this;

		return $load( $path );
	}

	/**
	 * @inheritDoc
	 */
	public function supports( $resource, string $type = null ): bool {
		return is_string( $resource ) && 'php' === pathinfo( $resource, PATHINFO_EXTENSION );
	}
}
