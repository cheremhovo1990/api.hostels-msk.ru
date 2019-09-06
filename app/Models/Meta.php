<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 09.05.19
 * Time: 11:43
 */
declare(strict_types=1);


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


/**
 * Class Meta
 * @package App\Models
 * @property $id
 * @property $page_identity
 * @property $description
 * @property $title
 * @property $h1
 */
class Meta extends Model
{
    const PAGE_IDENTITY_METRO_MAIN = 'metro_main';
    const PAGE_IDENTITY_METRO = 'metro';

    protected $guarded = [];
    /**
     * @var string
     */
    protected $table = 'meta';
}