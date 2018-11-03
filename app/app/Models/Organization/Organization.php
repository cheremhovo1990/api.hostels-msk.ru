<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 27.10.18
 * Time: 11:36
 */
declare(strict_types=1);


namespace App\Models\Organization;


use App\Helpers\OrganizationHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Organization
 * @package App\Models\Organization
 * @property int $id
 * @property string $name
 * @property int $status
 */
class Organization extends Model
{
    use SoftDeletes;

    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;
    protected $guarded = [];
    protected $dates = ['delete_at'];

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return OrganizationHelper::getNameDropDown()[$this->status];
    }
}