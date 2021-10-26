<?php

namespace Init;

trait ReplaceInFilesTrait
{
    use PathTrait;
    use ClimateTrait;

    protected $fileForReplace = [
        './composer.json.template',
        './tests/_laravel/composer.json',
        './src/Boilerplate.php',
        './src/BoilerplateFacade.php',
        './src/BoilerplateServiceProvider.php',
    ];

    protected function replaceInFiles($data)
    {
        $cli = $this->getClimate();
        $cli->info('Replace placeholders');

        foreach ($data as $key => $val) {
            foreach (['kebab', 'snake', 'studly', 'camel'] as $filter) {
                $replaces['{' . $key . '|' . $filter . '}'] = \Illuminate\Support\Str::$filter($val);
            }
            $replaces['{' . $key . '}'] = $val;
        }

        $progress = $cli->progress()->total(count($this->fileForReplace));

        foreach ($this->fileForReplace as $file) {
            $this->replaceInFile($file, $replaces);
            $progress->advance();
        }
    }

    protected function replaceInFile($path, $replaces)
    {
        // Normalize path
        $path = preg_replace('/^\./', $this->getProjectRoot(), str_replace('/', DIRECTORY_SEPARATOR, $path));
        file_put_contents($path, str_replace(array_keys($replaces), array_values($replaces), file_get_contents($path)));
    }

}