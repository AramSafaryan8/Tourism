<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tourism/assets/app-data/config.php';

use AppData\Config;

$dirs = Config::get_dirs();

spl_autoload_register(function ($className) use ($dirs) {
    $path = explode('\\', strtolower($className));

    $dir = array_shift($path);

    switch ($dir) {
        case 'controllers':
            require_once $dirs->controllers . '/' . $path[0] . (($path[0] == 'controller') ? '.php' : '-controller.php');

            break;
        case 'appdata':
            require_once $dirs->root . $dirs->assets . '/app-data/' . $path[0] . '.php';

            break;
        case 'rendering':
            require_once $dirs->root . $dirs->scripts . '/php/rendering/' . $path[0] . '.php';

            break;
        case 'routers':
            require_once $dirs->root . $dirs->assets . '/routers/' . $path[0] . '.php';

            break;
        case 'models':
            require_once $dirs->models . '/'. $path[0] . '.php';

            break;
        case 'scripts':
            require_once $dirs->root . $dirs->scripts . '/php/'. $path[0] . '.php';

            break;
        
        default:
            echo 'The required class was not found: ';
            echo $className;

            break;
    }
});