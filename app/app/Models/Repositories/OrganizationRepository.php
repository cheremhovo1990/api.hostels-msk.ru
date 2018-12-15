<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 09.12.18
 * Time: 18:27
 */
declare(strict_types=1);


namespace App\Models\Repositories;


use App\Models\Organization\Organization;

/**
 * Class OrganizationRepository
 * @package App\Models\Repositories
 */
class OrganizationRepository
{

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
}