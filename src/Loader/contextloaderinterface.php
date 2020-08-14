<?php
/**
 * Context Loader Interface
 *
 * @package    WordPress
 * @author     Guillaume Lacourt <guillaume.lacourt@gmail.com>
 * @copyright  MIT
 */

/**
 * Context Loader Interface.
 */

namespace App\Loader;

/**
 * Interface ContextLoaderInterface
 */
interface ContextLoaderInterface {
	/**
	 * Set the new scope context.
	 *
	 * @param $context
	 *
	 * @return self
	 */
	public function setContext( $context ): self;
}
