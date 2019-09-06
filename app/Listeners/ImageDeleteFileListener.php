<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 25.11.18
 * Time: 11:12
 */
declare(strict_types=1);


namespace App\Listeners;


use App\Events\ImageDeleted;

/**
 * Class ImageDeleteFileListener
 * @package App\Listeners
 */
class ImageDeleteFileListener
{
    /**
     * @param ImageDeleted $deleted
     */
    public function handle(ImageDeleted $deleted)
    {
        $deleted->deleteImage();
    }
}