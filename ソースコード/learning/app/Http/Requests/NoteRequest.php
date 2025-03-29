<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
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
            'title' => 'max:100|nullable',
            'content' => 'required',
            'registration_date' => 'required|date',
            'image' => 'image|mimes:jpeg,png,jpg,gif|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'タイトルは100文字以内で入力してください',
            'content.required' => '内容は必ず入力してください',
            'registration_date.required' => '登録日は必ず入力してください',
            'registration_date.date' => '正しい日付で入力してください',
            'image.image'=>'画像のアップロードエラー',
        ];
    }
}
