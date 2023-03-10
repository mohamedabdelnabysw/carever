<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = User::where('email', $this->email)->first();
            if ($user && !Hash::check($this->password, $user->password)) {
                $validator->errors()->add('field', 'Password does not match');
            }
        });
    }
}
