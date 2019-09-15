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
 * @property $name
 * @property $extension
 * @property $token
 * @property $folder
 * @property $status
 */
class Image extends Model
{
    use Notifiable;
    /**
     *
     */
    const ROOT_FOLDER = 'uploads';
    /**
     *
     */
    const WIDTH = 160;
    /**
     *
     */
    const STATUS_NONE = 'none';
    /**
     *
     */
    const STATUS_MAIN = 'main';
    /**
     * @var string
     */
    protected $table = 'images';

    /**
     * @param string $token
     * @param string $extension
     * @param null $modelId
     * @param null $modelToken
     * @return Image
     */
    public static function newForLodge(string $token, string $extension, $modelId = null, $modelToken = null): self
    {
        $model = new static();
        $model->model_id = $modelId;
        $model->model_type = $modelToken;
        $model->token = $token;
        $model->name = uniqid('', true);
        $model->extension = $extension;
        $model->folder = 'lodge';
        return $model;
    }

    /**
     * @param int $width
     * @return string
     */
    public function getFullName(int $width = null): string
    {
        if (is_null($width)) {
            return $this->name . '.' . $this->extension;
        } else {
            return $this->name . '.' . $width . '.' . $this->extension;
        }
    }

    /**
     * @return string
     */
    public function getFolderOriginal(): string
    {
        return $this->folder . '/' . $this->token . '/original';
    }

    /**
     * @return string
     */
    public function getPathOriginal(): string
    {
        return $this->folder . '/' . $this->token . '/original' . '/' . $this->getFullName();
    }

    /**
     * @param int $width
     * @return string
     */
    public function getPath(int $width): string
    {
        return $this->folder . '/' . $this->token . '/' . $this->getFullName($width);
    }

    /**
     * @param int $width
     * @return string
     */
    public function getUrl(int $width): string
    {
        return $this->folder . '/' . $this->token . '/' . $this->getFullName($width);
    }


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