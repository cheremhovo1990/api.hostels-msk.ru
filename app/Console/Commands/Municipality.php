<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 16.11.18
 * Time: 7:20
 */
declare(strict_types=1);


namespace App\Console\Commands;


use App\Models\AdministrativeDistrict;
use Illuminate\Console\Command;

class Municipality extends Command
{
    protected $signature = 'municipality:populate';

    public function handle()
    {
        $mulicipalities = json_decode(file_get_contents(base_path('data/mo.geojson')), true);
        foreach ($mulicipalities['features'] as $mulicipal) {
            $name = $mulicipal['properties']['NAME'];
            $nameDistrict = $mulicipal['properties']['NAME_AO'];
            $district = AdministrativeDistrict::where('name', $nameDistrict)->first();
            $geometry = $mulicipal['geometry'];
            \App\Models\Municipality::create([
                'name' => $name,
                'administrative_district_id' => $district->id,
                'geometry' => $geometry,
            ]);
        }
    }
}
