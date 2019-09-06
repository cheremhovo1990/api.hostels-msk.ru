<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 23.10.18
 * Time: 20:22
 */
declare(strict_types=1);


namespace App\Console\Commands\gis;


use App\Models\Pagination\Detail\Detail;
use App\Models\Pagination\Detail\Organization;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class detailGroup extends Command
{
    protected $signature = 'detail:group';

    public function handle()
    {
        $groupDetails = DB::select('SELECT name, COUNT(*) as count, GROUP_CONCAT(id) as ids FROM details GROUP BY name HAVING count > 1');

        foreach ($groupDetails as $groupDetail) {
            /** @var $organization Organization */
            $organization = Organization::create(['name' => $groupDetail->name]);
            foreach (explode(',', $groupDetail->ids) as $id) {
                $detail = Detail::find($id);
                $organization->details()->save($detail);
            }
        }
    }
}