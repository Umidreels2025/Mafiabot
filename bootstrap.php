<?php
require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/Config/config.php';

use Storage\RedisStore;
use Core\Bot;

$redis = new RedisStore($config['redis']);
$bot   = new Bot($config, $redis);