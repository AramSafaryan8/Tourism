<?php
declare(strict_types = 1);

namespace Routers;

use AppData\Config;
use Routers\Handler;
use Rendering\View;

class Router
{
    private const METHODS = ['GET' => 'Get', 'POST' => 'Post'];
    private $handlers = [];
    private $not_found_action = NULL;

    private function add_handler (string $method, string $path, $action) : void {
        $path = Config::get_dirs()->webRoot . $path;

        $this->handlers[$method . $path] = new Handler($method, $path, $action);
    }

    public function get (string $path, $action) : void {
        $this->add_handler(self::METHODS['GET'], $path, $action);
    }

    public function post (string $path, $action) : void {
        $this->add_handler(self::METHODS['POST'], $path, $action);
    }

    public function run () : void {
        $requestURI = parse_url($_SERVER['REQUEST_URI']);
        $path = $requestURI['path'];
        // $method = ucfirst(strtolower($_SERVER['REQUEST_METHOD']));
        $method = self::METHODS[$_SERVER['REQUEST_METHOD']];

        $callback = NULL;

        foreach ($this->handlers as $key => $handler) {
            if ($key == $method . $path) {
                $callback = $handler->action;

                break;
            }
        }

        if (!$callback) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');

            $callback = $this->not_found_action;
        }

        $view = call_user_func_array($callback, [array_merge($_GET, $_POST)]);

        if ($view instanceof View) {
            echo $view->render();
        }
    }

    public function set_not_found_action ($action) : void {
        $this->not_found_action = $action;
    }
}