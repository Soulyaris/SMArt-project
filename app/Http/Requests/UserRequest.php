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
        return view('users.test',['output' => $this]);
        return [
            'name' => 'nullable|unique:users,name,'.$userInfo.'|min:3|max:60',
            'email' => 'nullable|email|unique,email'.$userInfo,
            'password' => 'nullable|confirmed|min:6|max:32'
        ];
    }
}