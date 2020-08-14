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

use Symfony\Component\Config\Loader\FileLoader;

/**
 * Class PHP Loader.
 */
class PHPLoader extends FileLoader {
	/**
	 * @inheritDoc
	 */
	public function load( $resource, string $type = null ) {
		$load = \Closure::bind(
			function ( $resource ) {
				return include $resource;
			},
			$this->context,
			( new \ReflectionObject( $this->context ) )->getName()
		);

		$this->context = $this;

		return $load( $resource );
	}

	/**
	 * @inheritDoc
	 */
	public function supports( $resource, string $type = null ) {
		return is_string( $resource ) && 'php' === pathinfo( $resource, PATHINFO_EXTENSION );
	}
}
