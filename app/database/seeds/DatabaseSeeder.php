<?php

use App\Models\Organization\Lodge;
use App\Models\Organization\LodgeMetroStation;
use App\Services\MetroDistanceService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lodge_property')->delete();
        $this->call(PropertySeeder::class);
        DB::delete('delete from lodges');
        DB::delete('delete from lodge_metro_station');


        $lodges = factory(Lodge::class, 100)->create();

        $lodges->each(function (Lodge $lodge) {
            $metroDistanceService = app(MetroDistanceService::class);
            $distance = 1000;
            $stations = $metroDistanceService->getMetro($lodge->latitude, $lodge->longitude, $distance)->all();
            foreach ($stations as $station) {

                $lodgeMetroStation = LodgeMetroStation::new(
                    $lodge->id,
                    $station->id,
                    $metroDistanceService->distance($lodge->latitude, $lodge->longitude, $station)
                );
                $lodgeMetroStation->save();
            }
        });
        $this->call(ImageSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
