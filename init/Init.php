<?php

namespace Init;

use League\CLImate\CLImate;

/**
 *
 */
class Init
{
    use PromptTrait;

    /**
     * @var CLImate
     */
    protected $cli;

    /**
     *
     */
    public function __construct()
    {
        $this->cli = new CLImate;
        $data = $this->user_prompt();
    }
}