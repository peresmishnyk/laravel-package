<?php

namespace Init;

trait ReplaceInFilesTrait
{
    use PathTrait;

    protected $fileForReplace = [
        './composer.json.template',
        './tests/_laravel/composer.json',
        './src/Boilerplate.php',
        './src/BoilerplateFacade.php',
        './src/BoilerplateServiceProvider.php',
    ];

    protected function replaceInFiles($data)
    {
        foreach ($data as $key => $val) {
            foreach (['kebab', 'snake', 'studly', 'camel'] as $filter) {
                $replaces['{' . $key . '|' . $filter . '}'] = \Illuminate\Support\Str::$filter($val);
            }
            $replaces['{' . $key . '}'] = $val;
        }

        foreach ($this->fileForReplace as $file) {
            $this->replaceInFile($file, $replaces);
        }
    }

    protected function replaceInFile($path, $replaces)
    {
        // Normalize path
        $path = preg_replace('/^\./', $this->getProjectRoot(), str_replace('/', DIRECTORY_SEPARATOR, $path));
        file_put_contents($path, str_replace(array_keys($replaces), array_values($replaces), file_get_contents($path)));
    }

}