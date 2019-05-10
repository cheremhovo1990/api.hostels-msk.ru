<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 09.05.19
 * Time: 17:06
 */
declare(strict_types=1);


namespace App\Services;


use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ToolService
 * @package App\Services
 */
class ToolService
{
    /**
     * @param Model|null $model
     */
    public function notFound(Model $model = null)
    {
        if (is_null($model)) {
            throw new NotFoundHttpException('The required page does not exist');
        }
    }
}