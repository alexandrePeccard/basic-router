<?php
namespace App\Router;

class Route {

    /**
     *
     * @var string
     */
    private $path;

    /**
     *
     * @var
     */
    private $callable;

    /**
     *
     * @var array
     */
    private $matches = [];

    /**
     *
     * @var array
     */
    private $params = [];

    /**
     *
     * @param string $path
     * @param callable $callable
     */
    public function __construct($path, $callable) {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    /**
     *
     * @param string $url
     * @return boolean
     */
    public function match($url) {
        $url = trim($url, '/');
        $matches = [];
        
        $path = preg_replace('#:([\w]*)#i', '([^/]*)', $this->path);
        
        $regex = "#^" . $path . "$#";
        
        if (! preg_match($regex, $url, $matches)) {
            return false;
        }
        
        array_shift($matches);
        
        $this->matches = $matches;
        
        return true;
    }

    /**
     *
     * @return mixed
     */
    public function call() {
        return call_user_func_array($this->callable, $this->matches);
    }

    /**
     *
     * @param string $param
     * @param string $regex
     * @return \App\Router\Route
     */
    public function with($param, $regex) {
        $this->param[$param] = $regex;
        
        return $this;
    }
}