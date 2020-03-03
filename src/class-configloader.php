<?php
/**
 * A config loader Class
 *
 * @package    WordPress
 * @subpackage Betam
 * @author     Adfab <dev@adfab.fr>
 * @copyright  All right reserved
 */

/**
 * A config loader Class.
 */

namespace App;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;

/**
 * Class ConfigLoader.
 */
class ConfigLoader implements LoaderInterface {

	/**
	 * Resolver property.
	 *
	 * @var LoaderResolverInterface $resolver Resolver.
	 */
	protected $resolver;

	/**
	 * Locator property.
	 *
	 * @var FileLocator $locator Locator.
	 */
	protected $locator;

	/**
	 * Context.
	 *
	 * @var $context
	 */
	protected $context;

	/**
	 * ConfigLoader constructor.
	 *
	 * @throws \Exception Exception.
	 */
	public function __construct() {
		if ( ! defined( 'CONFIG_PATHS' ) && file_exists( get_template_directory() . '/config' ) ) {
			define( 'CONFIG_PATHS', array( get_template_directory() . '/config' ) );
		}

		if ( ! defined( 'CONFIG_PATHS' ) ) {
			throw new \Exception( 'You must define a CONFIG_PATHS global constante' );
		}

		if ( ! is_array( CONFIG_PATHS ) ) {
			define( 'CONFIG_PATHS', array( CONFIG_PATHS ) );
		}

		$this->context = $this;
		$this->locator = new FileLocator( CONFIG_PATHS );
	}

	/**
	 * Get static instance.
	 *
	 * @return ConfigLoader ConfigLoader instance.
	 * @throws \Exception Exception.
	 */
	public static function getInstance() {
		return new self();
	}

	/**
	 * Set the context for the next load
	 *
	 * @param object $context Context.
	 *
	 * @return $this
	 */
	public function setContext( $context ) {
		$this->context = $context;

		return $this;
	}

	/**
	 * Load a resource if exist.
	 *
	 * @param mixed  $resource Resource.
	 * @param string $type     Type.
	 *
	 * @return mixed
	 * @throws \Exception Exception.
	 */
	public function load( $resource, string $type = null ) {
		$path = $this->locator->locate( $resource );

		$load = \Closure::bind(
			function ( $path ) {
				return include $path;
			},
			$this->context,
			( new \ReflectionObject( $this->context ) )->getName()
		);

		$this->context = $this;

		return $load( $path );
	}

	/**
	 * Define which file are supported.
	 *
	 * @param string $resource Resource.
	 * @param string $type     Type.
	 *
	 * @return bool
	 */
	public function supports( $resource, string $type = null ) {
		return is_string( $resource ) && 'php' === pathinfo( $resource, PATHINFO_EXTENSION );
	}

	/**
	 * Get the Resolver.
	 *
	 * @return LoaderResolverInterface $resolver.
	 */
	public function getResolver() {
		return $this->resolver;
	}

	/**
	 * Set the Resolver.
	 *
	 * @param LoaderResolverInterface $resolver Resolver.
	 */
	public function setResolver( LoaderResolverInterface $resolver ) {
		$this->resolver = $resolver;
	}

	/**
	 * Get the config paths.
	 *
	 * @return array
	 */
	public function getPaths() {
		return CONFIG_PATHS;
	}
}
