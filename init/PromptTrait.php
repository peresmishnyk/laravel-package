<?php

namespace Init;

trait PromptTrait
{
    protected $cli;
    
    public function user_prompt(){
        // Get developer name
        $default = getenv('DEVELOPER_NAME') ?: '';
        do {
            $prompt = 'Author' . ($default !== '' ? '[' . $default . ']' : '') . ':';
            $input = $this->cli->input($prompt);
            $input->defaultTo($default);
            $author = trim($input->prompt());
            $this->cli->out($author);
            if ($author === '' && $default !== '') {
                $this->cli->out($default);
            }
        } while (!trim($author));

// Get developer email
        $default = getenv('DEVELOPER_EMAIL') ?: '';
        do {
            $prompt = 'Email' . ($default !== '' ? '[' . $default . ']' : '') . ':';
            $email = trim($this->cli->input($prompt)->prompt()) ?: $default;
        } while (!trim($email));

// Try to get developer email from env
        $env_email = getenv('DEVELOPER_EMAIL');
        do {
            if ($env_email) {
                $email = mb_strtolower(trim($this->cli->input('Email[' . $env_email . ']:')->prompt()) ?: $env_email);
            } else {
                $email = mb_strtolower(trim($this->cli->input('Email:')->prompt()));
            }
        } while (!trim($email));

        do {
            $vendor = mb_strtolower(trim($this->cli->input('Vendor:')->prompt()) ?: 'peresmishnyk test');
        } while (!trim($vendor));

        do {
            $package = mb_strtolower(trim($this->cli->input('Package:')->prompt()) ?: 'boilerplate package');
        } while (!trim($package));
    }
}