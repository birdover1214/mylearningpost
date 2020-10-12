<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PostTime;

class PostRequest extends FormRequest
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
            'skill' => ['required'],
            'time' => ['required', new PostTime($this->id)],
            'comment' => ['required', 'max:100'],
        ];
    }


    public function messages()
    {
        return [
            'required' => 'この項目は必須です',
            'max' => ':max文字以下で入力してください'
        ];
    }
}
