<?php

namespace Modules\Order\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            api_response_error($validator->errors()->first())
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'product_id'     => ['nullable', 'exists:products,id', 'prohibited_with:work_id'],
            'work_id'        => ['nullable', 'exists:works,id', 'prohibited_with:product_id'],
            'provider_id'    => ['required_with:work_id', 'nullable', 'exists:users,id'],
            'city_to_id'     => ['required', 'exists:cities,id'],
            'district_to_id' => ['required', 'exists:districts,id'],
        ];
    }

    /**
     * Custom attributes for validation errors.
     */
    public function attributes(): array
    {
        return [
            'product_id'  => __('order::common.product'),
            'work_id'     => __('order::common.work'),
            'provider_id' => __('order::common.provider'),
            'city_to_id'  => __('order::common.city_to'),
            'district_to_id'  => __('order::common.district_to'),
        ];
    }
}
