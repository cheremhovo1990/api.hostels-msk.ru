<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 04.11.18
 * Time: 18:20
 */
declare(strict_types=1);


namespace App\Console\Commands;


use App\Models\City;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class MetroImportController extends Command
{
    public $signature = 'metro:import';

    public function handle()
    {
        $cities = City::all();
        foreach ($cities as $city) {
            $client = new Client(['base_uri' => 'https://api.hh.ru/metro', 'headers' => ['Accept' => 'application/json']]);
            $response = $client->get($city->hhArea->hh_arae_id);

            var_dump($response->getBody()->getContents());
        }
    }
}