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
        $data['author'] = $this->prompt('Author', getenv('DEVELOPER_NAME'));
        $data['email'] = mb_strtolower($this->prompt('Email', getenv('DEVELOPER_EMAIL')));
        $data['vendor'] = mb_strtolower($this->prompt('Vendor', getenv('VENDOR_NAME')));
        $data['package'] = mb_strtolower($this->prompt('Package', ''));
        var_dump($data);
        die();
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