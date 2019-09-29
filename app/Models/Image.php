<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 24.11.18
 * Time: 15:44
 */
declare(strict_types=1);


namespace App\Models;


use App\Events\ImageDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


/**
 * Class Image
 * @package App\Models
 * @property $id
 * @property $model_id
 * @property $model_type
 * @property $token
 * @property $status
 * @property $src
 */
class Image extends Model
{
    use Notifiable;

    /**
     *
     */
    const STATUS_NONE = 'NONE';
    /**
     *
     */
    const STATUS_MAIN = 'MAIN';

    /**
     * @var string
     */
    protected $table = 'images';

    public $timestamps = false;

    public $guarded = [];

    /**
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->status == static::STATUS_MAIN;
    }

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'deleted' => ImageDeleted::class,
    ];
}
