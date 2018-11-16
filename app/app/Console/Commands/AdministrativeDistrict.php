<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 14.11.18
 * Time: 19:15
 */
declare(strict_types=1);


namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AdministrativeDistrict extends Command
{
    protected $signature = 'administrative-district:populate';

    public function handle()
    {
        $okrugs = json_decode(file_get_contents(base_path('/data/ao.geojson')), true);
        foreach ($okrugs['features'] as $feature) {
            $name = $feature['properties']['NAME'];
            $abbrev = $feature['properties']['ABBREV'];
            $geometry = $feature['geometry'];
            DB::insert(
                'INSERT INTO administrative_districts set name = :name, abbrev = :abbrev, geometry = :geometry, created_at = :created_at, updated_at = :updated_at',
                [
                    ':name' => $name,
                    ':abbrev' => $abbrev,
                    ':geometry' => json_encode($geometry),
                    ':created_at' => date('Y-m-d H:i'),
                    ':updated_at' => date('Y-m-d H:i'),
                ]
            );
            echo 'DONE - ' . $name . PHP_EOL;
        }
    }
}