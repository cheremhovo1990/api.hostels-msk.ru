<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 05.05.19
 * Time: 10:27
 */
declare(strict_types=1);


namespace App\Models\Organization\Repositories;


use App\Models\Organization\Organization;

/**
 * Class OrganizationRepository
 * @package App\Models\Organization\Repositories
 */
class OrganizationRepository
{
    /**
     * @return mixed
     */
    public static function getDropDown()
    {
        return Organization::pluck('name', 'id');
    }

    /**
     * @param int $id
     * @return Organization
     */
    public function oneByDetail(int $id)
    {
        $organization = Organization::
        select('organizations.*')
            ->leftJoin('parser_hostel.detail_organizations', 'parser_hostel.detail_organizations.organization_id', '=', 'organizations.id')
            ->leftJoin('parser_hostel.detail_organization', 'parser_hostel.detail_organization.organization_id', '=', 'parser_hostel.detail_organizations.id')
            ->where('parser_hostel.detail_organization.detail_id', '=', $id)
            ->first();

        return $organization;
    }

    /**
     * @param int $id
     * @return Organization
     */
    public function findOne(int $id): ?Organization
    {
        return Organization::where('id', $id)->first();
    }
}