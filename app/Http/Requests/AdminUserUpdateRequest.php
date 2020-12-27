<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminUserUpdateRequest extends FormRequest
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
        /*if (1) {
            dd(Auth::user()->name);
        }*/
        return [
            'avatar' => 'image',
            'name' => 'required|min:5|max:20|unique:users,name,' . $this->route('post'),
        ];
    }
}
