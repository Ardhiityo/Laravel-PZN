<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "username" => ["required", "min:5"],
            "password" => ["required", Password::min(5)->letters()->symbols()->numbers()]
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            "username" => strtoupper($this->input("username"))
        ]);
    }

    protected function passedValidation()
    {
        return $this->merge([
            "password" => bcrypt($this->input("password"))
        ]);
    }
}
