<?php
declare(strict_types = 1);

namespace Controllers;

use AppData\Config;
use Scripts\EErrors;
use Rendering\View;

abstract class Errors
{
    public static function index (array $request = []) : View {
        $err = NULL;
        $errComponent = (!isset($request['type']) || empty($err = EErrors::get($request['type'])))
            ? self::not_found()
            : self::get_component($err);

        header($_SERVER['SERVER_PROTOCOL'] . ' ' . (empty($err) ? '404 Not Found' : $err['headers']['statusCode'] . ' ' . $err['headers']['reason']));

        return new View('/main_template.phtml', [
            '{{@title}}' => 'Error',
            '{{@content}}' => $errComponent
        ]);
    }

    private static function not_found () : View {
        $err = EErrors::get('notfound');

        return new View('/error.phtml', [
            '{{@err-title}}' => $err['title'],
            '{{@err-msg}}' => $err['msg']
        ]);
    }

    public static function get_component (array $errObj) : View {
        return new View('/error.phtml', [
            '{{@err-title}}' => $errObj['title'],
            '{{@err-msg}}' => $errObj['msg']
            // '{{@err-msg-additional}}' => (isset($request['desc'])) ? '<p>' . urldecode($request['desc']) . '</p>' : ''
        ]);
    }
}