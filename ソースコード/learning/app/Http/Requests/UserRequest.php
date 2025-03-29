<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'=>'required|max:50',
            'email'=>'required|email',
            'password'=>'confirmed|string|min:8|nullable',
        ];
    }

    public function messages(){
        return[
            'name.required'=>'名前は必ず入力してください',
            'name.max'=>'名前は50文字以下で入力してください',
            'email.required'=>'メールアドレスは必ず入力してください',
            'email.email'=>'メールアドレスは正しい形式で入力してください',
            'password.confirmed'=>'パスワードが一致しません',
            'password.string'=>'パスワードは文字列で入力してください',
            'password.min'=>'パスワードは8文字以上で入力してください',
        ];
    }
}
