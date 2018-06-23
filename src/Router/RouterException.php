<?php
namespace App\Router;

class RouterException extends \Exception {

    public function __construct($msg) {
        echo ($msg);
    }
}