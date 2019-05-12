<?php

use App\Models\Organization\Lodge;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Container\Container;
use Illuminate\Contracts\Filesystem\Factory;
use Intervention\Image\Facades\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = \App\Models\Image::where('model_type', Lodge::IMAGE_TOKEN)->all();

        foreach ($images as $image) {
            $image->delete();
        }

        $lodges = Lodge::all();
        foreach ($lodges as $lodge) {
            for ($i = 0; $i < 10; $i++) {
                $this->image($lodge, $i == 0 ? \App\Models\Image::STATUS_MAIN : \App\Models\Image::STATUS_NONE);
            }
        }
    }

    public function image(Lodge $lodge, $status)
    {
        $faker = \Faker\Factory::create();
        $url = $faker->imageUrl($width = 640, $height = 480);
        $client = new Client();
        $file = tmpfile();
        $response = $client->get($url, ['sink' => $file]);
        $mime = $response->getHeader('Content-Type')[0];
        $image = \App\Models\Image::newForLodge(
            $lodge->image_token,
            $this->getExtensionByMimeType($mime),
            $lodge->id,
            Lodge::IMAGE_TOKEN
        );
        $image->status = $status;
        $image->saveOrFail();

        Container::getInstance()->make(Factory::class)->disk('uploads')->put($image->getPathOriginal(), $file);

        $resource = Image::make(public_path(\App\Models\Image::ROOT_FOLDER . '/' . $image->getPathOriginal()));
        $ratio = $resource->width() / $resource->height();
        $width = \App\Models\Image::WIDTH;
        $resource->fit($width, ceil($width / $ratio))
            ->save(public_path(\App\Models\Image::ROOT_FOLDER . '/' . $image->getPath($width)));
    }

    public function getExtensionByMimeType($mimeType)
    {
        if (isset($this->mime[$mimeType])) {
            return $this->mime[$mimeType];
        }
        throw new \RuntimeException();
    }

    public $mime = [
        'image/png' => 'png',
        'image/jpeg' => 'jpeg',
    ];
}
