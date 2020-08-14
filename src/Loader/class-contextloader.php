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
 * Class ContextLoader
 */
abstract class ContextLoader extends FileLoader implements ContextLoaderInterface {

	/**
	 * @var mixed $context
	 */
	protected $context;

	/**
	 * Set the context for the next load
	 *
	 * @param object|null $context Context.
	 *
	 * @return ContextLoaderInterface
	 */
	public function setContext( $context = null ): ContextLoaderInterface {
		$this->context = $context ?? $this;

		return $this;
	}
}
