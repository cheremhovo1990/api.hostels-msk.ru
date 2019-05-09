<?php

namespace App\Http\Requests\Cp;

use App\Models\Meta;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MetaRequest extends FormRequest
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
        $meta = $this->route('metum');
        $rule = Rule::unique('meta', 'page_identify');
        if (!is_null($meta)) {
            $rule->ignore($meta, 'id');
        }
        return [
            'page_identify' => [
                'required',
                $rule,
                Rule::in([Meta::PAGE_IDENTITY_METRO_MAIN, Meta::PAGE_IDENTITY_METRO])
            ],
            'description' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'h1' => 'required|string|max:255',
        ];
    }
}
