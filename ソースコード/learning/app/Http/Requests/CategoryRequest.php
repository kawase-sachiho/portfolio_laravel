<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category_name'=>'required|max:50',
        ];
    }
    public function messages(){
        return[
            'category_name.required'=>'カテゴリー名は必ず入力してください',
            'category_name.max'=>'カテゴリー名は50文字以下で入力してください',
        ];
    }
}
