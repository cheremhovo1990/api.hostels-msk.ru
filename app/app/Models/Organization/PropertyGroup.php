<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 02.03.19
 * Time: 15:17
 */
declare(strict_types=1);


namespace App\Models\Organization;


use Illuminate\Database\Eloquent\Model;

/**
 * Class PropertyGroup
 * @package App\Models\Organization
 * @property $name
 */
class PropertyGroup extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var bool
     */
    public $timestamps = false;
}