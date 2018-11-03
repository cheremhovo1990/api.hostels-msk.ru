<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 23.10.18
 * Time: 20:51
 */
declare(strict_types=1);


namespace App\Models\Pagination\Detail;


use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $connection = 'parse';
    protected $table = 'detail_organizations';
    protected $guarded = [];
    public function details()
    {
        return $this->belongsToMany(Detail::class);
    }
}