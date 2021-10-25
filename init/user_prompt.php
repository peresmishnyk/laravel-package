<?php

use League\CLImate\CLImate;

$climate = $climate ?? new CLImate();

// Get developer name
$default = getenv('DEVELOPER_NAME') ?: '';
do {
    $prompt = 'Author' . ($default !== '' ? '[' . $default . ']' : '') . ':';
    $input = $climate->input($prompt);
    $input->defaultTo($default);
    $author = trim($$input->prompt());
    $climate->out($author);
    if ($author === '' && $default !== '') {
        $climate->out($default);
    }
} while (!trim($author));

// Get developer email
$default = getenv('DEVELOPER_EMAIL') ?: '';
do {
    $prompt = 'Email' . ($default !== '' ? '[' . $default . ']' : '') . ':';
    $email = trim($climate->input($prompt)->prompt()) ?: $default;
} while (!trim($email));

// Try to get developer email from env
$env_email = getenv('DEVELOPER_EMAIL');
do {
    if ($env_email) {
        $email = mb_strtolower(trim($climate->input('Email[' . $env_email . ']:')->prompt()) ?: $env_email);
    } else {
        $email = mb_strtolower(trim($climate->input('Email:')->prompt()));
    }
} while (!trim($email));

do {
    $vendor = mb_strtolower(trim($climate->input('Vendor:')->prompt()) ?: 'peresmishnyk test');
} while (!trim($vendor));

do {
    $package = mb_strtolower(trim($climate->input('Package:')->prompt()) ?: 'boilerplate package');
} while (!trim($package));