<?php
/**
 * A config loader Class
 *
 * @package    WordPress
 * @author     Guillaume Lacourt <guillaume.lacourt@gmail.com>
 * @copyright  MIT
 */

/**
 * A config loader Class.
 */

namespace App;

use App\Loader\ContextLoader;
use App\Loader\ContextLoaderInterface;
use App\Loader\PHPLoader;
use App\Loader\YamlLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\LoaderResolverInterface;

/**
 * Class ConfigLoader.
 */
class ConfigLoader extends ContextLoader {

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
	 * @var DelegatingLoader $loader
	 */
	protected $loader;

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

		$this->context  = $this;
		$this->locator  = new FileLocator( CONFIG_PATHS );
		$this->resolver = new LoaderResolver(
			array (
				new PHPLoader( $this->locator ),
				new YamlLoader( $this->locator ),
			)
		);
		$this->loader   = new DelegatingLoader( $this->resolver );
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
	 * @inheritDoc
	 */
	public function load( $resource, string $type = null ) {
		if ( false !== ( $loader = $this->resolver->resolve( $resource, $type ) ) && $loader instanceof ContextLoaderInterface ) {
			$loader->setContext( $this->context );
		}

		return $this->loader->load( $resource, $type );
	}

	/**
	 * @inheritDoc
	 */
	public function supports( $resource, string $type = null ): bool {
		return $this->loader->supports( $resource, $type );
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
