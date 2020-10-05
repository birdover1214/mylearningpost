<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\CurrentPassword;

class EditUserRequest extends FormRequest
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
        return [
            'user_image' => ['nullable', 'image'],
            'name' => ['required', 'string', 'max:20'],
            'introduction' => ['nullable', 'max:100'],
            'email' => ['required', 'string', 'email', 'unique:users,email,'.Auth::user()->email.',email', 'max:255'],
            'password' => ['nullable', 'min:8', 'max:255', 'confirmed'],
            'password_confirmation' => ['nullable'],
            'skills' => ['required'],
            'current_password' => ['required', 'min:8', new CurrentPassword]
        ];
    }

    public function messages()
    {
        return [
            'required' => 'この項目は必須です',
            'image' => '選択されたファイルは使用できません',
            'string' => '文字列で入力してください',
            'max' => ':max文字以下で入力してください',
            'min' => ':min文字以上で入力してください',
            'email' => 'メールアドレスの入力形式が違います',
            'confirmed' => '確認フィールドと一致しません',
            'unique' => '入力されたメールアドレスは既に登録されています',
        ];
    }
}
