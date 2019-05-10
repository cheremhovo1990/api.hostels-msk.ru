<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 8:39
 */
declare(strict_types=1);


namespace App\Models\Repositories;


use App\Models\Meta;

/**
 * Class MetaRepository
 * @package App\Models\Repositories
 */
class MetaRepository
{

    /**
     * @param $pageIdentify
     * @return Meta|null
     */
    public function findOneByPageIdentify($pageIdentify): ?Meta
    {
        return Meta::where('page_identify', '=', $pageIdentify)->first();
    }
}