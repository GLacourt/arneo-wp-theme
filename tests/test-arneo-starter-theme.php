<?php
/**
 * Test.
 *
 * @package    WordPress
 */

/**
 * Test example.
 */

/**
 * Class TestTimberStarterTheme
 */
class TestTimberStarterTheme extends WP_UnitTestCase {

	/**
	 * Before test.
	 */
	public function setUp() {
		self::_setupStarterTheme();
		switch_theme( basename( dirname( dirname( __FILE__ ) ) ) );
		require_once __DIR__ . '/../public functions.php';
	}

	/**
	 * After test.
	 */
	public function tearDown() {
		switch_theme( 'twentythirteen' );
	}

	/**
	 * Test Timber context.
	 */
	public function testTimberExists() {
		$context = Timber::context();
		$this->assertTrue( is_array( $context ) );
	}

	/**
	 * Loading PHP functions.
	 */
	public function testFunctionsPHP() {
		$context = Timber::context();
		$this->assertEquals( 'StarterSite', get_class( $context['site'] ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
		$this->assertEquals( 'bar', $context['foo'] );
	}

	/**
	 * Loading test.
	 */
	public function testLoading() {
		$str = Timber::compile( 'tease.twig' );
		$this->assertStringStartsWith( '<article class="tease tease-" id="tease-">', $str );
		$this->assertStringEndsWith( '</article>', $str );
	}

	/**
	 * Test theme is containing default "foo bar!" message.
	 */
	public function testTwigFilter() {
		$str = Timber::compile_string( '{{ "foo" | myfoo }}' );
		$this->assertEquals( 'foo bar!', $str );
	}

	/**
	 * Do some setup.
	 */
	public static function setupStarterTheme() {
		$dest = WP_CONTENT_DIR . '/themes/' . basename( dirname( dirname( __FILE__ ) ) );
		$src  = realpath( __DIR__ . '/../../' . basename( dirname( dirname( __FILE__ ) ) ) );
		if ( is_dir( $src ) && ! file_exists( $dest ) ) {
			symlink( $src, $dest );
		}
	}
}
