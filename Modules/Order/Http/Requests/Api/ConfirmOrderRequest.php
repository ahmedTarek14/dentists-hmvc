<?php

namespace Modules\Order\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConfirmOrderRequest extends FormRequest
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
            'product_price'   => ['required', 'numeric', 'min:0'],
            'shipping_fees'   => ['required', 'numeric', 'min:0'],
            'total_price'     => ['required', 'numeric', 'min:0'],
            'service_number'  => ['required', 'string', 'max:255'],
            'requester_id'    => ['required', 'exists:users,id'],
            'provider_id'     => ['nullable', 'exists:users,id'],
            'city_from_id'    => ['required', 'exists:cities,id'],
            'city_to_id'      => ['required', 'exists:cities,id'],
            'product_id'      => ['nullable', 'exists:products,id'],
            'work_id'         => ['nullable', 'exists:works,id'],
        ];
    }

    /**
     * Custom attributes for validation errors.
     */
    public function attributes(): array
    {
        return [
            'product_price'  => __('order::common.product_price'),
            'shipping_fees'  => __('order::common.shipping_fees'),
            'total_price'    => __('order::common.total_price'),
            'service_number' => __('order::common.service_number'),
            'requester_id'   => __('order::common.requester'),
            'provider_id'    => __('order::common.provider'),
            'city_from_id'   => __('order::common.city_from'),
            'city_to_id'     => __('order::common.city_to'),
            'product_id'     => __('order::common.product'),
            'work_id'        => __('order::common.work'),
        ];
    }
}
