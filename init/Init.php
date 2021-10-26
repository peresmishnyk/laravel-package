<?php

namespace Init;

use League\CLImate\CLImate;

/**
 *
 */
class Init
{
    use PathTrait;
    use PromptTrait;
    use ReplaceInFilesTrait;
    use RenameFilesTrait;


    /**
     *
     */
    public function __construct()
    {
        $this->setProjectRoot(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));
        $data = $this->userPrompt();
        $this->replaceInFiles($data);
        $this->renameFiles($data);
//        $this->cleanup();
    }
}