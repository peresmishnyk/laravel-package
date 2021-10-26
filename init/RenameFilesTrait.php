<?php

namespace Init;

trait RenameFilesTrait
{
    use PathTrait;

    protected $filesForRename = [
        './src/Boilerplate.php' => './src/{package|studly}.php',
        './src/BoilerplateFacade.php' => './src/{package|studly}Facade.php',
        './src/BoilerplateServiceProvider.php' => './src/{package|studly}ServiceProvider.php',
        './composer.json.template' => './composer.json',
    ];

    protected function renameFiles($data)
    {
        foreach ($data as $key => $val) {
            foreach (['kebab', 'snake', 'studly', 'camel'] as $filter) {
                $replaces['{' . $key . '|' . $filter . '}'] = \Illuminate\Support\Str::$filter($val);
            }
            $replaces['{' . $key . '}'] = $val;
        }

        foreach ($this->filesForRename as $old => $new) {
            $old = preg_replace('/^\./', $this->getProjectRoot(), str_replace('/', DIRECTORY_SEPARATOR, $old));
            $new = preg_replace('/^\./', $this->getProjectRoot(), str_replace('/', DIRECTORY_SEPARATOR, $new));
            rename($old, str_replace(array_keys($replaces), array_values($replaces), $new));
        }
    }

}