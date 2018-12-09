<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 09.12.18
 * Time: 17:43
 */
declare(strict_types=1);


namespace App\Models\Repositories;


use App\Models\Pagination\Detail\Detail;

/**
 * Class DetailRepository
 * @package App\Models\Repositories
 */
class DetailRepository
{
    /**
     * @param int $id
     * @return Detail[]
     */
    public function allByOrganization(int $id)
    {
        $details = Detail::select('details.*')
            ->leftJoin('detail_organization', 'detail_organization.detail_id', '=', 'details.id')
            ->leftJoin('detail_organizations', 'detail_organizations.id', '=', 'detail_organization.organization_id')
            ->where('detail_organizations.organization_id', '=', $id)
            ->paginate();

        return $details;
    }
}