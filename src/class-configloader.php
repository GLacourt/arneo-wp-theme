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
use Symfony\Component\Config\Loader\DelegatingLoader;
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


	protected $loader;

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
		$this->loader  = new DelegatingLoader([
		    new PHPLoader( $this->locator ),
            new YamlLoader( $this->locator ),
        ]);
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
	 * @inheritDoc
	 */
	public function load( $resource, string $type = null ) {
		return $this->loader->load( $resource, $type );
	}

	/**
	 * @inheritDoc
	 */
	public function supports( $resource, string $type = null ): bool {
		return $this->loader->supports( $resource, $type );
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
