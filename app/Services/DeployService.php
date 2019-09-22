<?php

declare(strict_types=1);


namespace App\Services;


class DeployService
{
    protected $uuid = "{24c954f6-63d7-418a-b911-77b8683dca69}";

    public function run($uuid)
    {
        abort_if($uuid != $this->uuid, 404);


        chdir(base_path());
        exec('git reset --hard HEAD', $output);
        exec('git pull', $output);
        exec('composer install --no-dev --optimize-autoloader', $output);
        exec('artisan migrate');
        //exec('npm install', $output);
        //exec('npm run prod', $output);
        $output['success'] = true;
        return $output;
    }
}
