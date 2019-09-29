<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 25.11.18
 * Time: 11:09
 */
declare(strict_types=1);


namespace App\Events;


use App\Models\Image;
use Illuminate\Support\Facades\Storage;

/**
 * Class ImageDeleted
 * @package App\Events
 */
class ImageDeleted
{
    /**
     * @var Image
     */
    private $image;

    /**
     * ImageDeleted constructor.
     * @param Image $image
     */
    public function __construct(
        Image $image
    )
    {
        $this->image = $image;
    }

    /**
     *
     */
    public function deleteImage(): void
    {
        /*Storage::disk('uploads')->delete($this->image->getPath(Image::WIDTH));
        Storage::disk('uploads')->delete($this->image->getPathOriginal());*/
    }
}
