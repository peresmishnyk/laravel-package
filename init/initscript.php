#!/usr/bin/env php
<?php


$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('Init\\', realpath(__DIR__ . '/../init'));

require "init/Init.php";

new \Init\Init();


