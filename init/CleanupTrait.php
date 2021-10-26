<?php

namespace Init;

trait CleanupTrait
{
    use PathTrait;

    public function cleanup()
    {
        $cli = $this->getClimate();
        $cli->info('Cleanup');

        $root_dir = $this->getProjectRoot();
        $this->removeDir($root_dir . DIRECTORY_SEPARATOR . 'init');
        unlink($root_dir . DIRECTORY_SEPARATOR . 'init.php');

        exec('composer update');
    }

    protected function removeDir($dirname) {
        if (is_dir($dirname)) {
            $dir = new \RecursiveDirectoryIterator($dirname, \RecursiveDirectoryIterator::SKIP_DOTS);
            foreach (new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::CHILD_FIRST) as $object) {
                if ($object->isFile()) {
                    unlink($object);
                } elseif($object->isDir()) {
                    rmdir($object);
                } else {
                    throw new Exception('Unknown object type: '. $object->getFileName());
                }
            }
            rmdir($dirname); // Now remove
        } else {
            throw new Exception('This is not a directory');
        }
    }
}