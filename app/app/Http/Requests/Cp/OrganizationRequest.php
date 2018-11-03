<?php

namespace App\Http\Requests\Cp;

use App\Models\Organization\Organization;
use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:255|unique:organizations,name',
            'status' => 'required|integer'
        ];
        $organization = $this->route('organization');
        if ($organization instanceof Organization) {
            $rules['name'] .= ',' . $organization->id;

        }
        return $rules;
    }
}
