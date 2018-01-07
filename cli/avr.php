#!/usr/bin/env php
<?php

# Require composer autoload
require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Container\Container;
use Silly\Application;

Container::setInstance(new Container);

$version = '0.0.1';

$app = new Application('Adult Video Renamer CLI', $version);

$app->command('get path', function ($path) {
    $filename = basename($path);

    if ($serial = Serial::get($filename)) {
        $result = Parser::search($serial);

        output($result);
    } else {
        warning('Could get void serial.');
    }
});


// Run application.
try {
    $app->run();
} catch (Exception $e) {
    output($e->getMessage());
}
