<?php

namespace Init;

use League\CLImate\CLImate;

/**
 *
 */
class Init
{
    use ReplaceInFilesTrait;
    use RenameFilesTrait;

    protected $project_root;
    protected $cli;

    /**
     *
     */
    public function __construct()
    {
        $this->setProjectRoot(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));
        $data = $this->userPrompt();
        $this->replaceInFiles($data);
        $this->renameFiles();
//        $this->cleanup();
    }

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
        $cli = $this->getClimate();
        $default = $default ?: '';
        $input = $cli->input($message . ($default !== '' ? '[' . $default . ']' : '') . ':');
        $input->defaultTo($default);
        $input->accept(function ($response) use ($pattern, $cli) {
            $is_valid = preg_match($pattern, trim($response));
            if (!$is_valid) {
                $cli->error('Allowed chars: ' . $pattern);
            }
            return $is_valid;
        });
        return $input->prompt();
    }







    protected function getProjectRoot()
    {
        return $this->project_root;
    }

    protected function setProjectRoot($path)
    {
        $this->project_root = $path;
    }

    protected function getClimate()
    {
        $this->cli = $this->cli ?? new CLImate();
        return $this->cli;
    }
}