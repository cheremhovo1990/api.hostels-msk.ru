<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 15:34
 */
declare(strict_types=1);


namespace App\Services;


use App\Models\Organization\Lodge;
use App\Models\Repositories\ImageRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class LodgeService
 * @package App\Services
 */
class LodgeService
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * LodgeService constructor.
     * @param ImageRepository $imageRepository
     */
    public function __construct(
        ImageRepository $imageRepository
    )
    {
        $this->imageRepository = $imageRepository;
    }


    /**
     * @param $data
     * @return Lodge
     * @throws \Throwable
     */
    public function create($data): Lodge
    {
        $model = Lodge::new($data);
        $model->saveOrFail();
        $this->saveProperties($model, $data['properties'] ?? []);
        $this->imageRepository->update($model, $data['image_token'], Lodge::IMAGE_TOKEN);
        return $model;
    }

    /**
     * @param Lodge $model
     * @param $data
     * @return Lodge
     * @throws \Throwable
     */
    public function update(Lodge $model, array $data): Lodge
    {
        $model->edit($data);
        $model->saveOrFail();
        $this->saveProperties($model, $data['properties'] ?? []);
        return $model;
    }

    /**
     * @param Lodge $model
     * @param array $properties
     */
    public function saveProperties(Lodge $model, array $properties)
    {
        DB::table('lodge_property')->where('lodge_id', $model->id)->delete();
        $rows = [];
        foreach ($properties as $property) {
            $rows[] = ['lodge_id' => $model->id, 'property_id' => $property];
        }
        DB::table('lodge_property')->insert($rows);
    }
}