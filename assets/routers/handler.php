<?php
declare(strict_types = 1);

namespace Routers;

class Handler
{
    public string $method = "";
    public string $path = "";
    public $action;

    public function __construct (string $method, string $path, $action) {
        $this->method = $method;
        $this->path = $path;
        $this->action = $action;
    }
}