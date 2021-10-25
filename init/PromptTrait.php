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
    protected function userPrompt()
    {
        $data['author'] = $this->prompt('Author', getenv('DEVELOPER_NAME'));
        $data['email'] = mb_strtolower($this->prompt('Email', getenv('DEVELOPER_EMAIL'), '|^[a-zA-Z0-9\s\-\.@]+$|'));
        $data['vendor'] = mb_strtolower($this->prompt('Vendor', getenv('VENDOR_NAME')));
        $data['package'] = mb_strtolower($this->prompt('Package', (basename(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..')))));
        return $data;
    }

    protected function prompt($message, $default, $pattern = "|^[a-zA-Z0-9\s\-]+$|")
    {
        $default = $default ?: '';
        $input = $this->cli->input($message . ($default !== '' ? '[' . $default . ']' : '') . ':');
        $input->defaultTo($default);
        $input->accept(function ($response) use ($pattern) {
            $is_valid = preg_match($pattern, trim($response));
            if (!$is_valid) {
                $this->cli->error('Allowed chars: ' . $pattern);
            }
            return $is_valid;
        });
        return $input->prompt();
    }
}