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

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Yaml Loader.
 */
class YamlLoader extends FileLoader {
	/**
	 * @inheritDoc
	 */
	public function load( $resource, string $type = null ) {
		return Yaml::parse(file_get_contents($resource));
	}

	/**
	 * @inheritDoc
	 */
	public function supports( $resource, string $type = null ) {
		return is_string( $resource ) && 'yaml' === pathinfo( $resource, PATHINFO_EXTENSION );
	}
}
