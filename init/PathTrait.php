<?php

namespace Init;

trait PathTrait
{
    protected $project_root;

    protected function getProjectRoot()
    {
        return $this->project_root;
    }

    protected function setProjectRoot($path)
    {
        $this->project_root = $path;
    }
}