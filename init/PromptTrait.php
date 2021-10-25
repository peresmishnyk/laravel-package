<?php

namespace Init;

use League\CLImate\CLImate;

/**
 *
 */
trait PromptTrait
{
    /**
     * @var CLImate
     */
    protected $cli;

    /**
     *
     */
    public function user_prompt()
    {
        $author = $this->prompt('Author', getenv('DEVELOPER_NAME'));
        $email = $this->prompt('Email', getenv('DEVELOPER_EMAIL'));
        var_dump($email);
        die();

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

    protected function prompt($message, $default)
    {
        $default = $default ?: '';
        $input = $this->cli->input($message . ($default !== '' ? '[' . $default . ']' : '') . ':');
        $input->defaultTo($default);
        $input->accept(function ($response) {
            return (trim($response) != '');
        });
        return $input->prompt();
    }
}