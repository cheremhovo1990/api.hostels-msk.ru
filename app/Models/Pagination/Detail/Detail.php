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
 * @property string $name
 * @property string $title
 * @property int $rating
 * @property int $lodge_id
 * @property string $number_review
 * @property string $description_href
 * @property string $text
 * @property string $brand_img_href
 * @property float $latitude
 * @property float $longitude
 * @property string $address
 * @property string $branch_href
 * @property string $number_branch
 * @property string $work_hour
 * @property string $img_href
 * @property string $site
 * @property string $email
 * @property string $comment_href
 * @property int $parsed
 * @property int $deleted
 * @property int $comment
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Lodge $lodge
 * @property Description[] $descriptions
 * @property Phone[] $phones
 * @property Attribute[] $detailAttributes
 * @property Image[] $image
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions()
    {
        return $this->hasMany(Description::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailAttributes()
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
