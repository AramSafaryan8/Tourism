<?php
declare(strict_types = 1);

namespace AppData;

class Config
{
    private static ?\stdClass $db = NULL;
    private static ?\stdClass $dirs = NULL;

    public static function init () : void {
        self::$db = new \stdClass();
        self::$db->type = 'mysql';
        self::$db->host = 'localhost';
        self::$db->name = 'tourism';
        self::$db->username = 'root';
        self::$db->pwd = '';

        self::$dirs = new \stdClass();
        self::$dirs->protocol = $_SERVER['SERVER_PROTOCOL'];
        self::$dirs->protocol = substr(self::$dirs->protocol, 0, strpos(self::$dirs->protocol, '/')) . '://';
        self::$dirs->root = $_SERVER['DOCUMENT_ROOT'];
        self::$dirs->webRoot = '/Tourism';
        self::$dirs->assets = self::$dirs->webRoot . '/assets';
        self::$dirs->scripts = self::$dirs->webRoot . '/assets/scripts';
        self::$dirs->content = self::$dirs->webRoot . '/assets/content';
        self::$dirs->controllers = self::$dirs->root . self::$dirs->webRoot . '/assets/controllers';
        self::$dirs->routers = self::$dirs->root . self::$dirs->webRoot . '/assets/routers';
        self::$dirs->models = self::$dirs->root . self::$dirs->webRoot . '/assets/models';
        self::$dirs->views = self::$dirs->root . self::$dirs->webRoot . '/assets/views';
    }

    public static function get_db () : ?\stdClass {
        return self::$db;
    }

    public static function get_dirs () : ?\stdClass {
        return self::$dirs;
    }
}

Config::init();