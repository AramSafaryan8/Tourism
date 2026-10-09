<?php
declare(strict_types = 1);

namespace Controllers;

use AppData\Config;
use Rendering\View;

class Controller
{
    public static function about () : View {
        return new View("/main_template.phtml",
            [
                '{{@title}}' => 'About page',
                '{{@links}}' => '<link rel="stylesheet" href="' . Config::get_dirs()->webRoot . '/public/styles/about.css" />',
                '{{@content}}' => new View('/about.php', [], false),
                '{{@popup}}' => ''
            ]
        );
    }

    public static function guides () : View {
        return new View('/main_template.phtml', [
            '{{@title}}' => 'Our guides',
            '{{@links}}' => '<link rel="stylesheet" href="' . Config::get_dirs()->webRoot . '/public/styles/guides.css" />',
            '{{@content}}' => new View('/guides.phtml', [], false),
            '{{@popup}}' => ''
        ]);
    }
}