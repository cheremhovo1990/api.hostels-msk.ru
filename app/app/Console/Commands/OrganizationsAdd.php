<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 27.10.18
 * Time: 13:03
 */
declare(strict_types=1);


namespace App\Console\Commands;


use App\Models\Pagination\Detail\Organization;
use Illuminate\Console\Command;

class OrganizationsAdd extends Command
{
    protected $signature = 'organizations:add';

    public function handle()
    {
        $organizations = Organization::all();
        foreach ($organizations as $organization) {
            $record = \App\Models\Organization\Organization::create([
                'name' => $organization->name,
            ]);
            $organization->organization_id = $record->id;
            $organization->save();
        }
    }
}