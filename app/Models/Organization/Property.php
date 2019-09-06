<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 02.03.19
 * Time: 15:18
 */
declare(strict_types=1);


namespace App\Models\Organization;


use Illuminate\Database\Eloquent\Model;


/**
 * Class Property
 * @package App\Models\Organization
 * @property PropertyGroup $group
 */
class Property extends Model
{
    protected $guarded = [];
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     *
     */
    public function group()
    {
        return $this->belongsTo(PropertyGroup::class, 'group_id', 'id');
    }
}