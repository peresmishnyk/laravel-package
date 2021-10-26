<?php

namespace Init;

trait CleanupTrait
{
    use PathTrait;

    public function cleanup()
    {
        $root_dir = $this->getProjectRoot();
        rmdir($root_dir . DIRECTORY_SEPARATOR . 'init');
        unlink($root_dir . DIRECTORY_SEPARATOR . 'init.php');

        exec('composer update');
    }
}