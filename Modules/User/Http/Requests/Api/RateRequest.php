<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RateRequest extends FormRequest
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
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'nullable|string',
            'product_id' => 'nullable|exists:products,id',
            'work_id'    => 'nullable|exists:works,id',
            'rated_user_id' => 'nullable|exists:users,id',
        ];
    }


    public function messages(): array
    {
        return [
            'rating.required' => __('user::rate.rating_required'),
            'rating.integer'  => __('user::rate.rating_integer'),
            'rating.min'      => __('user::rate.rating_min'),
            'rating.max'      => __('user::rate.rating_max'),

            'product_id.exists' => __('user::rate.product_not_found'),
            'work_id.exists'    => __('user::rate.work_not_found'),
            'rated_user_id.exists' => __('user::rate.user_not_found'),
        ];
    }

    /**
     * Custom attributes for validation errors.
     */
    public function attributes(): array
    {
        return [

            'rating' => __('user::rate.rating'),
            'comment' => __('user::rate.comment'),
            'product_id' => __('user::rate.product'),
            'work_id' => __('user::rate.work'),
            'rated_user_id' => __('user::rate.rated_user'),
        ];
    }
}
