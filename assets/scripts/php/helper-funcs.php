<?php
use AppData\Config;

function debug ($obj) {
    echo "<pre>";
    var_dump($obj);
    echo "</pre>";
}

function debug_r ($obj) {
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
}

function debug_export ($obj) {
    echo "<pre>";
    var_export($obj);
    echo "</pre>";
}

function redirect (string $header, string $path) : void {
    header($header . Config::get_dirs()->webRoot . $path);

    die;
}