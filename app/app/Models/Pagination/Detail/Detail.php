<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 09.10.18
 * Time: 7:19
 */
declare(strict_types=1);


namespace App\Models\Pagination\Detail;


use App\Models\Organization\Lodge;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Detail
 * @package App\Models\Pagination\Detail
 *
 * @property $id
 * @property string $title
 * @property $description_href
 * @property $img_href
 * @property $comment_href
 * @property $number_review
 * @property $branch_href
 * @property $number_branch
 *
 * @property Lodge $lodge
 */
class Detail extends Model
{
    protected $connection = 'parse';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lodge()
    {
        return $this->belongsTo(Lodge::class);
    }
}