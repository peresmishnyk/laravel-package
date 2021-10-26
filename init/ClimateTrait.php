<?php

namespace Init;

use League\CLImate\CLImate;

trait ClimateTrait
{
    /**
     * @var CLImate
     */
    protected $cli;

    protected function getClimate()
    {
        $this->cli = $this->cli ?? new CLImate();
        return $this->cli;
    }

}