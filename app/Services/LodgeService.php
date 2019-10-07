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
use App\Models\Organization\Property;
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
        $this->imageRepository->update($model, $data['image_token'], Lodge::IMAGE_TOKEN);
        return $model;
    }

    public function createProperty($lodgeId, array $properties): Property
    {
        $property = Property::create([
            'lodge_id' => $lodgeId,
            'wi_fi' => $properties['wi_fi'],
            'reception_24_hour' => $properties['reception_24_hour'],
            'fridge' => $properties['fridge'],
            'television' => $properties['television'],
            'bunk_bed' => $properties['bunk_bed'],
            'single_beds' => $properties['single_beds'],
            'orthopedic_mattress' => $properties['orthopedic_mattress'],
            'security_24_hour' => $properties['security_24_hour'],
            'conditioner' => $properties['conditioner'],
            'soundproofing' => $properties['soundproofing'],
            'kitchen' => $properties['kitchen'],
            'bath' => $properties['bath'],
            'shower' => $properties['shower'],
            'washer' => $properties['washer'],
            'price_min' => $properties['price_min'],
            'drying_machine' => $properties['drying_machine'],
        ]);
        return $property;
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
        return $model;
    }

    public function updateProperty($lodgeId, $properties)
    {
        $property = Property::query()->where('lodge_id', '=', $lodgeId)->first();
        $property->update([
            'lodge_id' => $lodgeId,
            'wi_fi' => $properties['wi_fi'],
            'reception_24_hour' => $properties['reception_24_hour'],
            'fridge' => $properties['fridge'],
            'television' => $properties['television'],
            'bunk_bed' => $properties['bunk_bed'],
            'single_beds' => $properties['single_beds'],
            'orthopedic_mattress' => $properties['orthopedic_mattress'],
            'security_24_hour' => $properties['security_24_hour'],
            'conditioner' => $properties['conditioner'],
            'soundproofing' => $properties['soundproofing'],
            'kitchen' => $properties['kitchen'],
            'bath' => $properties['bath'],
            'shower' => $properties['shower'],
            'washer' => $properties['washer'],
            'price_min' => $properties['price_min'],
            'drying_machine' => $properties['drying_machine'],
        ]);
        return $property;
    }

    public function destroy(Lodge $lodge): void
    {
        $detail = $lodge->detail;
        if ($lodge->delete()) {
            $detail->lodge_id = null;
            $detail->update();
        }
    }
}
