#!/usr/bin/env php
<?php

// Require composer autoload
require __DIR__.'/../vendor/autoload.php';

use Silly\Application;
use Illuminate\Container\Container;

Container::setInstance(new Container);

$version = '0.0.1';

$app = new Application('Adult Video Renamer CLI', $version);

$app->addCommands([
    new \Avr\Commands\GetCommand,
]);

// Run application.
$app->run();
