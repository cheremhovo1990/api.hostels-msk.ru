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
use App\Models\MetroStation;
use App\Models\Municipality;
use App\Models\Pagination\Detail\Detail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Lodge
 * @package App\Models\Organization
 *
 * @property int $id
 * @property int $organization_id
 * @property int $city_id
 * @property int $administrative_district_id
 * @property int $municipality_id
 * @property int $status
 * @property string $announce
 * @property string $description
 * @property string $phone
 * @property string $address
 * @property string $opening_hours
 * @property string $latitude
 * @property string $longitude
 * @property string $image_token
 * @property array $schema_org
 * @property array $data
 * @property Detail $detail
 * @property Municipality $municipality
 * @property District $district
 * @property MetroStation[] $stations
 * @property Organization $organization
 */
class Lodge extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
    protected $casts = [
        'schema_org' => 'array',
        'data' => 'array',
    ];

    /**
     * @param array $data
     * @param Organization $organization
     * @return Lodge
     */
    public static function new(array $data, Organization $organization): self
    {
        $model = new self();
        $model->organization_id = $organization->id;
        $model->image_token = $data['image_token'];
        $model->edit($data);
        $model->setData([
            'source' => '2gis'
        ]);
        return $model;
    }

    /**
     * @param array $data
     */
    public function edit(array $data)
    {
        $this->city_id = $data['city_id'];
        $this->announce = $data['announce'];
        $this->description = $data['description'];
        $this->phone = $data['phone'];
        $this->address = $data['address'];
        $this->opening_hours = $data['opening_hours'];
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
        $this->status = $data['status'];
        $this->administrative_district_id = $data['administrative_district_id'];
        $this->municipality_id = $data['municipality_id'];
        $this->setSchemaOrg($data['schema_org_opening_hours'] ?? []);
    }

    /**
     * @param array $data
     */
    public function setSchemaOrg(array $data = [])
    {
        $this->schema_org = ['opening_hours' => $data];
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
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
        return $this->belongsToMany(MetroStation::class, 'lodge_metro_station', 'lodge_id', 'metro_station_id')
            ->using(LodgeMetroStation::class)
            ->withPivot('distance');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * @return array
     */
    public function getPhone(): array
    {
        if (preg_match('~(\d)(\d{3})(\d{3})(\d{2})(\d{2})~', $this->phone, $match)) {
            $raw = $this->phone;
            $country = $match[1];
            if ($match[1] == 7) {
                $raw = '+' . $this->phone;
                $country = '+' . $match[1];
            }
            return [
                'raw' => $raw,
                'country' => $country,
                'code' => $match[2],
                'user' => "$match[3]-$match[4]-$match[5]",
            ];
        } else {
            return [];
        }
    }
}