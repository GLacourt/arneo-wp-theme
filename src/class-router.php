<?php
/**
 * Router class for Arneo WordPress Theme
 *
 * @package    WordPress
 * @subpackage Arneo WordPress Theme
 * @author     Arneo <dev@arneogroup.com>
 * @copyright  MIT
 */

/**
 * Router class for Arneo WordPress Theme
 *
 * This class give you a basic way to declare controller method.
 */

namespace App;

use Routes;

/**
 * Class Router
 */
class Router {

    /** @var mixed $routes */
    protected $routes;

    /**
     * Router constructor.
     *
     * @throws \Exception
     */
    public function __construct() {
        $this->routes = ConfigLoader::getInstance()->setContext( $this )->load( 'routes.php' );

        foreach ( $this->routes as $path => $action ) {
            if ( method_exists( $this, $action ) ) {
                Routes::map( $path, [ $this, $action ] );
            }
        }
    }
}
