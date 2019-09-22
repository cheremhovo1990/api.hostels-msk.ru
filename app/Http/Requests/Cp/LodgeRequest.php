<?php

namespace App\Http\Requests\Cp;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

/**
 * Class DetailRequest
 * @package App\Http\Requests\Cp
 */
class LodgeRequest extends FormRequest
{
    /**
     * @var array
     */
    protected $purifierFields = [
        'announce',
        'description',
    ];

    /**
     * @var array
     */
    protected $phones = [
        'phone'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     *
     */
    protected function prepareForValidation()
    {
        $this->request->replace(collect($this->all())->map(function ($value, $key) {
            if (in_array($key, $this->purifierFields)) {
                return Purifier::clean($value);
            } elseif (in_array($key, $this->phones)) {
                return preg_replace('~\D~', '', $value);
            } elseif ($key === 'schema_org_opening_hours') {
                return array_filter($value);
            } else {
                return $value;
            }
        })->all());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'announce' => 'string',
            'organization_id' => 'required|integer',
            'description' => 'string',
            'phone' => 'required|string|size:11',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'status' => 'required|integer',
            'opening_hours' => 'required|string',
            'schema_org_opening_hours.*' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'stations.*.id' => 'exists:metro_stations,id',
            'stations.*.distance' => 'integer',
            'administrative_district_id' => 'nullable|exists:administrative_districts,id',
            'municipality_id' => 'nullable|exists:municipalities,id',
            'image_token' => 'required|string',
        ];
    }
}
