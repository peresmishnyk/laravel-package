<?php

namespace Init;

use League\CLImate\CLImate;

/**
 *
 */
class Init
{
    use RenameFilesTrait;

    protected $project_root;
    protected $cli;

    protected $fileForReplace = [
        './composer.json.template',
        './tests/_laravel/composer.json',
        './src/Boilerplate.php',
        './src/BoilerplateFacade.php',
        './src/BoilerplateServiceProvider.php',
    ];

    /**
     *
     */
    public function __construct()
    {
        $this->setProjectRoot(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));
        $data = $this->userPrompt();
        $this->replaceInFiles($data);
//        $this->renameFiles();
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


    protected function replaceInFiles($data)
    {
        foreach ($data as $key => $val) {
            foreach (['kebab', 'snake', 'studly', 'camel'] as $filter) {
                $replaces['{' . $key . '|' . $filter . '}'] = \Illuminate\Support\Str::$filter($val);
            }
            $replaces['{' . $key . '}'] = $val;
        }

        foreach ($this->filesForReplace as $file) {
            replaceInFile($file, $replaces);
        }
    }

    protected function replaceInFile($path, $replaces)
    {
        // Normalize path
        $path = preg_replace('/^\.\//', $this->getProjectRoot(), str_replace('/', DIRECTORY_SEPARATOR, $path));
        file_put_contents($path, str_replace(array_keys($replaces), array_values($replaces), file_get_contents($path)));
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