<?php

namespace Modules\City\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CityRequest extends FormRequest
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
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 400));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules['name'] = ['required', 'string', 'max:255'];
        $rules['shipping_fees'] = ['required', 'numeric', 'min:0'];

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'name' => __('city::city.City Name'),
            'shipping_fees' => __('city::city.Shipping Fees'),
        ];

        return $attributes;
    }
}
