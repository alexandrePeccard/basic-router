<?php
namespace App\Router;

class Router {

    /**
     *
     * @var string
     */
    private $url;

    /**
     *
     * @var array
     */
    private $routes = [];

    /**
     *
     * @param string $url
     */
    public function __construct($url) {
        $this->url = $url;
    }

    /**
     *
     * @param string $path
     * @param callable $callable
     */
    public function get($path, $callable) {
        $route = new Route($path, $callable);
        $this->routes['GET'][] = $route;
        
        return $route;
    }

    /**
     *
     * @param string $path
     * @param callable $callable
     */
    public function post($path, $callable) {
        $route = new Route($path, $callable);
        $this->routes['POST'][] = $route;
        
        return $route;
    }

    /**
     *
     * @throws RouterException
     * @return callable
     */
    public function run() {
        if (! isset($_REQUEST)) {
            throw new RouterException("REQUEST METHOD DOES NOT EXIST");
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            
            if ($route->match($this->url)) {
                
                return $route->call();
            }
        }
        
        throw new RouterException('No matching routes.');
    }
}