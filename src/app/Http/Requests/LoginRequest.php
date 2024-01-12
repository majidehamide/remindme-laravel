<?php

namespace App\Http\Requests;

use App\DataTransferObjects\LoginUserDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'     => 'required|email',
            'password'  => 'required'
        ];
    }

    public function toDTO(): LoginUserDTO{
        return new LoginUserDTO(
            email: $this->email,
            password: $this->password
        );
    }
}
