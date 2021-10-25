<?php

// Try to get developer name from env
$env_developer = getenv('DEVELOPER_NAME');
do {
    if ($env_developer){
        $author = trim($climate->input('Author['.$env_developer.']:')->prompt()) ?: $env_developer;
    } else {
        $author = trim($climate->input('Author:')->prompt());
    }
} while (!trim($author));

// Try to get developer email from env
$env_email = getenv('DEVELOPER_EMAIL');
do {
    if ($env_email){
        $email = mb_strtolower(trim($climate->input('Email['.$env_email.']:')->prompt()) ?: $env_email);
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