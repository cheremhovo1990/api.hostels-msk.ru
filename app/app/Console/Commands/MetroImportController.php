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
use App\Models\Metro;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MetroImportController extends Command
{
    public $signature = 'metro:import';

    public function handle()
    {
        $cities = City::all();
        foreach ($cities as $city) {
            $client = new Client(['base_uri' => 'https://api.hh.ru/metro', 'headers' => ['Accept' => 'application/json']]);
            $response = $client->get($city->hhArea->hh_arae_id);

            $response = json_decode($response->getBody()->getContents(), true);

            foreach ($response['0']['lines'] as $line) {
                $hexColor = $line['hex_color'];
                $nameLine = $line['name'];
                foreach ($line['stations'] as $station) {
                    $id = $station['id'];
                    $name = $station['name'];
                    $latitude = $station['lat'];
                    $longitude = $station['lng'];
                    $order = $station['order'];
                    $metro = Metro::create([
                        'name' => $name,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'order' => $order,
                        'hex_color' => $hexColor,
                        'line_name' => $nameLine,
                    ]);
                    DB::table('metro_station_hh_metro')->insert(
                        [
                            'metro_station_id' => $metro->id,
                            'hh_metro_id' => $id
                        ]
                    );
                }
            }
        }
    }
}