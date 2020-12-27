<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserChangeEmailRequest extends FormRequest
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
        $user = Auth::user();
        if ($user->is_verified) {
            return [
                'email' => 'required|email|unique:users,email|unique:temp_emails,new_email,' . $user->id,
            ];
        }
        return [
            'email' => 'required|email|unique:users,email,' . $user->id . '|unique:temp_emails,new_email,' . $user->id,
        ];
    }
}
