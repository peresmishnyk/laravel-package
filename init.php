#!/usr/bin/env php
<?php


$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Init\\', __DIR__ . DIRECTORY_SEPARATOR . 'init');

require "init/Init.php";

new \Init\Init();


