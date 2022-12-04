<?php

namespace Websnack\ResetPassword\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $minPasswordLength = config('nova-password-reset.min_password_length');

        return [
            'current_password' => ['required', 'string', \Illuminate\Validation\Rules\Password::default()],
            'password' => ['required', 'confirmed', 'string', 'min:'.$minPasswordLength],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'password.required' => 'The password field is required.',
            'confirm_password.required' => 'The confirm password field is required.',
        ];
    }
}
