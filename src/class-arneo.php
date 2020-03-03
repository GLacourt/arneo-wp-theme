<?php
/**
 * Starter class for Arneo WordPress Theme
 *
 * @package    WordPress
 * @subpackage Arneo WordPress Theme
 * @author     Arneo <dev@arneogroup.com>
 * @copyright  MIT
 */

/**
 * Starter class for Arneo WordPress Theme
 *
 * This class contains:
 * 1. A loader to separate configuration and loading code.
 * 2. A translation component to let you handle static translations.
 * 3. An easy extend of timber behaviors and ability
 * 4. A good way to boost productivity with WordPress development.
 */

namespace App;

use App\Hooks\Action;
use App\Hooks\Filter;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;
use Timber\Post;
use Timber\Site;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

/**
 * Class Arneo
 */
class Arneo extends Site {
	/**
	 * Config Loader var.
	 *
	 * @var ConfigLoader $loader
	 */
	protected $loader;

	/**
	 * Global Request var.
	 *
	 * @var $request
	 */
	protected $request;

	/**
	 * Translator var.
	 *
	 * @var Translator $translator
	 */
	protected $translator;

	/**
	 * Mama constructor.
	 *
	 * @param ConfigLoader $loader ConfigLoader.
	 *
	 * @throws \Exception Default exception.
	 */
	public function __construct( ConfigLoader $loader ) {
		$this->loader  = $loader;
		$this->request = Request::createFromGlobals();

		Action::adds(
			array(
				'acf/settings/save_json' => array( array( $this, 'acfJsonSavePoint' ) ),
				'acf/settings/load_json' => array( array( $this, 'acfJsonLoadPoint' ) ),
			)
		);

		Filter::adds(
			array(
				'timber/twig'    => array( array( $this, 'addToTwig' ) ),
				'timber/context' => array( array( $this, 'initContext' ) ),
			)
		);

		$this->handleLocale();

		$this->load();

		parent::__construct();
	}

	/**
	 * This method should return the current locale or false if there is no locale.
	 *
	 * @return mixed
	 */
	public function getCurrentLocale() {
		return false;
	}

	/**
	 * ACF json save point
	 *
	 * @return string
	 */
	public function acfJsonSavePoint() {
		return $this->getAcfPath();
	}


	/**
	 * ACF json load point
	 *
	 * @param array $paths Array of paths.
	 *
	 * @return array
	 */
	public function acfJsonLoadPoint( array $paths ) {
		return array( $this->getAcfPath() );
	}

	/**
	 * Add Twig Extension
	 *
	 * @param \Twig_Environment $twig Twig environment.
	 *
	 * @return \Twig_Environment
	 * @throws \ReflectionException Reflection exception.
	 */
	public function addToTwig( \Twig_Environment $twig ) {
		$theme     = 'form_div_layout.html.twig';
		$reflect   = new \ReflectionClass( AppVariable::class );
		$directory = dirname( $reflect->getFileName() );
		$engine    = new TwigRendererEngine( array( $theme ), $twig );

		$twig->getLoader()->addPath( $directory . '/Resources/views/Form' );

		$twig->addRuntimeLoader(
			new FactoryRuntimeLoader(
				array(
					FormRenderer::class => function () use ( $engine ) {
						return new FormRenderer( $engine );
					},
				)
			)
		);

		$twig->addExtension( new FormExtension() );
		$twig->addExtension( new TranslationExtension( $this->translator ) );

		$twig->addGlobal( 'google_recaptcha_site_key', env( 'GOOGLE_RECAPTCHA_SITE_KEY' ) );

		$twig->addFilter( new \Twig_SimpleFilter( 'defer', array( $this, 'defer' ) ) );

		return $twig;
	}

	/**
	 * This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 *
	 * @return mixed
	 */
	public function initContext( $context ) {
		$post = new Post();

		if ( ! is_home() && ! is_404() ) {
			$home       = new Post( get_option( 'page_on_front' ) );
			$breadcrumb = array(
				$home->title() => $home->link(),
			);

			$parent = $post->parent();
			while ( $parent ) {
				$breadcrumb[ $parent->title() ] = $parent->link();
				$parent                         = $parent->parent();
			}

			if ( $post->type()->name === 'post' && $post->category() ) {
				$blog = $this->getBlogPage();

				$breadcrumb[ $blog->name() ] = $blog->link();

				$breadcrumb[ $post->category()->name() ] = str_replace( '/category', '/blog', $post->category()->link() );
			}

			$breadcrumb[ $post->title() ] = $post->link();
		}

		$context['post']       = $post;
		$context['site']       = $this;
		$context['breadcrumb'] = $breadcrumb ?? array();

		if ( ! isset( $context['term'] ) ) {
			$context['term'] = false;
		}

		return $context;
	}

	/**
	 * Setup the current locale to the translator.
	 */
	protected function handleLocale() {
		$locale = $this->getCurrentLocale();
		$path   = sprintf( '%s/../translations/messages.%s.yaml', __DIR__, $locale );

		if ( false !== $locale && file_exists( $path ) ) {
			$this->translator = new Translator( $locale );

			$this->translator->addLoader( 'yaml', new YamlFileLoader() );
			$this->translator->addResource( 'yaml', $path, $locale );
		}
	}

	/**
	 * Load configuration files.
	 *
	 * @Throws \Exception exception.
	 */
	protected function load() {
		/** Register Custom Post Types */
		foreach ( $this->loader->setContext( $this )->load( 'cpts.php' ) as $name => $config ) {
			register_post_type( $name, $config );
		}

		/** Register Custom Taxonomy */
		foreach ( $this->loader->load( 'taxonomies.php' ) as $taxonomy ) {
			call_user_func_array( 'register_taxonomy', $taxonomy );
		}

		foreach ( $this->loader->load( 'supports.php' ) as $feature ) {
			call_user_func_array( 'add_theme_support', $feature );
		}
	}

	/**
	 * Get Acf Path.
	 *
	 * @return string
	 */
	protected function getAcfPath() {
		$paths = $this->loader->getPaths();

		return sprintf( '%s/acf', array_shift( $paths ) );
	}
}
