<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 16.11.18
 * Time: 20:02
 */
declare(strict_types=1);


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


/**
 * Class Municipality
 * @package App\Models
 *
 * @property $id
 * @property $administrative_distance
 * @property $name
 * @property $geometry
 */
class Municipality extends Model
{
    /**
     * @var string
     */
    protected $table = 'municipalities';

    /**
     * @var array
     */
    protected $casts = [
        'geometry' => 'array',
    ];

    protected $guarded = [];
}