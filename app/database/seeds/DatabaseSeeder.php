<?php

use App\Models\Organization\Lodge;
use App\Models\Organization\LodgeMetroStation;
use App\Services\MetroDistanceService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $lodges = factory(Lodge::class, 100)->create();
        $lodges->each(function (Lodge $lodge) {
            $metroDistanceService = app(MetroDistanceService::class);
            $distance = 1000;
            $stations = $metroDistanceService->getMetro($lodge->latitude, $lodge->longitude, $distance)->all();
            foreach ($stations as $station) {
                $lodgeMetroStation = LodgeMetroStation::new($lodge->id, $station->id, $distance);
                $lodgeMetroStation->save();
            }
        });
        // $this->call(UsersTableSeeder::class);
    }
}
