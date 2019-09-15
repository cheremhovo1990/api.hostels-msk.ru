<?php

declare(strict_types=1);


namespace App\Services;


class DeployService
{
    protected $uuid = "{5ad102b4-9a61-4def-9018-d21cf89af905}";

    public function run($uuid)
    {
        abort_if($uuid != $this->uuid, 404);

        chdir(base_path());
        exec('git reset --hard HEAD', $output);
        exec('git pull', $output);
        exec('composer install --no-dev --optimize-autoloader', $output);
        //exec('npm install', $output);
        //exec('npm run prod', $output);
        $output['success'] = true;
        return $output;
    }
}
