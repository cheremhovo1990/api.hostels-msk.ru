<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 18:42
 */
declare(strict_types=1);


namespace App\Models\Repositories;


use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ImageRepository
 * @package App\Models\Repositories
 */
class ImageRepository
{
    /**
     * @param Model $model
     * @param $imageToken
     * @param $modelToken
     */
    public function update(Model $model, $imageToken, $modelToken)
    {
        Image::where('token', $imageToken)
            ->update(['model_id' => $model->id, 'model_token' => $modelToken]);
    }
}