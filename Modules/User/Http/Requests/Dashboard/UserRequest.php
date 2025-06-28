<?php

namespace Modules\User\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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

        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email', 'max:255'],
        ];

        if ($this->isMethod('post')) {
            $rules['type'] =  ['required', 'in:doctor,technician'];
            $rules['password'] = [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ];
        } else {
            $rules['password'] = [
                'nullable',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'type' => __('auth::common.type'),
            'name' => __('auth::common.name'),
            'email' => __('auth::common.email'),
            'password' => __('auth::common.password'),
        ];

        return $attributes;
    }
}
