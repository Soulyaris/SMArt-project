<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userInfo = $this->user;
        return [
            'name' => 'nullable|string|unique:users,name,'.$userInfo.'|min:2|max:60',
            'email' => 'nullable|email|unique:users,email,'.$userInfo,
            'password' => 'nullable|string|confirmed|min:6|max:32',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
