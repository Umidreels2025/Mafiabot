<?php

$config = require __DIR__ . '/Config/config.php';

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
});


use Storage\RedisStore;
use Core\Bot;

$redis = new RedisStore($config['redis']);
$bot   = new Bot($config, $redis);