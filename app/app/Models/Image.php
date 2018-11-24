<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 24.11.18
 * Time: 15:44
 */
declare(strict_types=1);


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


/**
 * Class Image
 * @package App\Models
 * @property $name
 * @property $extension
 * @property $token
 */
class Image extends Model
{
    /**
     * @var string
     */
    protected $table = 'images';

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
    public function getFolderOriginal()
    {
        return $this->token . '/original';
    }

    /**
     * @param int $width
     * @return string
     */
    public function getFolder(int $width)
    {
        return $this->token . '/' . $this->getFullName($width);
    }

    /**
     * @param int $width
     * @return string
     */
    public function getUrl(int $width): string
    {
        return $this->token . '/' . $this->getFullName($width);
    }
}