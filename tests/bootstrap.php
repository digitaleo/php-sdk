<?php

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('UTC');

if (! file_exists(dirname(__FILE__) . '/../vendor/autoload.php')) {
    throw new RuntimeException('You have to run composer.phar install before runing PHPUnit');
}

require dirname(__FILE__) . '/../vendor/autoload.php';
