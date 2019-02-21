<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 21.02.19
 * Time: 12:08
 */
declare(strict_types=1);


namespace App\Console\Commands;

use App\Models\Organization\Lodge;
use Illuminate\Console\Command;

class GenerateText extends Command
{
    public $signature = 'generate-text:test';

    public function handle()
    {
        /** @var Lodge $lodge */
        $lodge = Lodge::where('id', '=', 301)->first();
        $generateText = new \App\Services\GenerateText\GenerateText($lodge, 1);
        echo $generateText->getMetro() . PHP_EOL;
    }
}