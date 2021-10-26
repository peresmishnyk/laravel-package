<?php

namespace Init;

trait LaravelPrepareTrait
{
    use PathTrait;
    public function laravelPrepare(){

        $cli = $this->getClimate();
        $cli->info('Prepare Laravel');

        $root_dir = $this->getProjectRoot();
        file_exists($root_dir . '/tests/_laravel/.env') || copy($root_dir . '/tests/_laravel/.env.example', $root_dir . '/tests/_laravel/.env');
        shell_exec("touch {$root_dir}/tests/_laravel/database/database.sqlite");
    }
}