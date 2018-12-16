<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 27.10.18
 * Time: 11:47
 */
declare(strict_types=1);


namespace App\Models\Organization;


use App\Models\District;
use App\Models\Metro;
use App\Models\Municipality;
use App\Models\Pagination\Detail\Detail;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lodge
 * @package App\Models\Organization
 *
 * @property int $id
 * @property array $schema_org
 * @property Detail $detail
 * @property Municipality $municipality
 * @property District $district
 * @property Metro[] $stations
 */
class Lodge extends Model
{
    /**
     *
     */
    const IMAGE_TOKEN = 'vo2leen0Ni';

    /**
     * @var string
     */
    protected $connection = 'mysql';

    /**
     *
     */
    const STATUS_DISABLE = 0;
    /**
     *
     */
    const STATUS_ENABLE = 1;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'schema_org' => 'array',
    ];

    /**
     * @param array $data
     * @param Organization $organization
     * @return Lodge
     */
    public static function new(array $data, Organization $organization): self
    {
        /** @var self $model */
        $model = Lodge::make([
            'organization_id' => $organization->id,
            'city_id' => $data['city_id'],
            'announce' => $data['announce'],
            'description' => $data['description'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'opening_hours' => $data['opening_hours'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'status' => $data['status'],
            'administrative_district_id' => $data['administrative_district_id'],
            'municipality_id' => $data['municipality_id'],
            'image_token' => $data['image_token'],
        ]);
        $model->setSchemaOrg($data['schema_org_opening_hours'] ?? []);
        return $model;
    }

    /**
     * @param array $data
     */
    public function setSchemaOrg(array $data = [])
    {
        $this->schema_org = ['opening_hours' => $data];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detail()
    {
        return $this->hasOne(Detail::class, 'lodge_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'administrative_district_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stations()
    {
        return $this->belongsToMany(Metro::class, 'lodge_metro_station', 'lodge_id', 'metro_station_id')->withPivot('distance', '');
    }
}