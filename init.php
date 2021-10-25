#!/usr/bin/env php
<?php

use League\CLImate\CLImate;

require "vendor/autoload.php";

$filesForReplace = [
    './composer.json.template',
    './tests/_laravel/composer.json',
    './src/Boilerplate.php',
    './src/BoilerplateFacade.php',
    './src/BoilerplateServiceProvider.php',
];

$filesForRename = [
    './src/Boilerplate.php' => './src/{package|studly}.php',
    './src/BoilerplateFacade.php' => './src/{package|studly}Facade.php',
    './src/BoilerplateServiceProvider.php' => './src/{package|studly}ServiceProvider.php',
    './composer.json.template' => './composer.json',
];

$climate = new CLImate();

require_once "init" . DIRECTORY_SEPARATOR . 'input_metadata.php';

do {
    $vendor = mb_strtolower(trim($climate->input('Vendor:')->prompt()) ?: 'peresmishnyk test');
} while (!trim($vendor));

do {
    $package = mb_strtolower(trim($climate->input('Package:')->prompt()) ?: 'boilerplate package');
} while (!trim($package));

$replaces = [];

foreach (['vendor', 'package', 'author', 'email'] as $varname) {
    foreach (['kebab', 'snake', 'studly', 'camel'] as $filter) {
        $replaces['{' . $varname . '|' . $filter . '}'] = \Illuminate\Support\Str::$filter($$varname);
    }
    $replaces['{' . $varname . '}'] = $$varname;
}

foreach ($filesForReplace as $file) {
    replaceInFile($file, $replaces);
}

foreach ($filesForRename as $old => $new) {
    rename($old, str_replace(array_keys($replaces), array_values($replaces), $new));
}

function replaceInFile($path, $replaces)
{
    // Normalize path
    $path = preg_replace('/^\.\//', __DIR__ . DIRECTORY_SEPARATOR, str_replace('/', DIRECTORY_SEPARATOR, $path));
    file_put_contents($path, str_replace(array_keys($replaces), array_values($replaces), file_get_contents($path)));
}

file_exists(__DIR__ . '/tests/_laravel/.env') || copy(__DIR__ . '/tests/_laravel/.env.example', __DIR__ . '/tests/_laravel/.env');

rmdir(__DIR__ . DIRECTORY_SEPARATOR . 'init');
unlink(__DIR__ . DIRECTORY_SEPARATOR . __FILE__);

exec('composer update');


