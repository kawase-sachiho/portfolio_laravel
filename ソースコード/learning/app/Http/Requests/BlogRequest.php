<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'title' => 'max:100',
            'content' => 'required',
            'learning_date' => 'required|date',
            'comment' => 'max:100',
            'study_time' => 'numeric|between:0,24|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'タイトルは100文字以内で入力してください',
            'content.required' => '内容は必ず入力してください',
            'learning_date.required' => '学習日は必ず入力してください',
            'leaning_date.date' => '正しい日付で入力してください',
            'comment.max' => 'コメントは100文字以内で入力してください',
            'study_time.numeric' => '勉強は整数で入力してください',
            'study_time.between' => '勉強時間が24時間以上になっています',
        ];
    }
}
