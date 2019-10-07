<?php

declare(strict_types=1);


namespace App\UseCases;


use App\Models\Organization\Lodge;
use App\Models\Organization\LodgeMetroStation;
use App\Models\Pagination\Detail\Detail;
use App\Models\Repositories\ImageRepository;
use App\Services\LodgeService;
use Illuminate\Support\Facades\DB;

class LodgeUseCase
{
    /**
     * @var LodgeService
     */
    private $lodgeService;
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    public function __construct(
        ImageRepository $imageRepository,
        LodgeService $lodgeService
    )
    {
        $this->lodgeService = $lodgeService;
        $this->imageRepository = $imageRepository;
    }

    public function createByDetail(Detail $detail, array $data): Lodge
    {
        $lodge = DB::transaction(function () use ($data, $detail) {
            $lodge = Lodge::newForDetail($data);
            $lodge->saveOrFail();
            $lodge->detail()->save($detail);
            $data['properties']['price_min'] = $data['price_min'];
            $this->lodgeService->createProperty($lodge->id, $data['properties']);
            if (isset($data['stations'])) {
                foreach ($data['stations'] as $station) {
                    $lodgeMetroStation = LodgeMetroStation::new($lodge->id, $station['id'], $station['distance']);
                    $lodgeMetroStation->save();
                }
            }
            $this->imageRepository->update($lodge, session()->getId(), Lodge::IMAGE_TOKEN);
            return $lodge;
        });
        return $lodge;
    }

    public function update(Lodge $lodge, array $data): Lodge
    {
        $lodge->edit($data);
        $lodge->saveOrFail();
        $data['properties']['price_min'] = $data['price_min'];
        $this->lodgeService->updateProperty($lodge->id, $data['properties']);
        return $lodge;
    }
}
