<?php
/**
 * Yaml loader Class
 *
 * @package    WordPress
 * @author     Guillaume Lacourt <guillaume.lacourt@gmail.com>
 */

/**
 * Yaml loader Class Class.
 */

namespace App\Loader;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Yaml Loader.
 */
class YamlLoader extends ContextLoader {
	/**
	 * @inheritDoc
	 */
	public function load( $resource, string $type = null ) {
		$path = $this->locator->locate( $resource );

		return Yaml::parse( file_get_contents( $path ) );
	}

	/**
	 * @inheritDoc
	 */
	public function supports( $resource, string $type = null ): bool {
		return is_string( $resource ) && 'yaml' === pathinfo( $resource, PATHINFO_EXTENSION );
	}
}
