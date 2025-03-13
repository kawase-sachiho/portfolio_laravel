<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LongGoalRequest extends FormRequest
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
            'long_term_goal_name' => 'required|max:100',
            'expire_date' => 'required|date',
            'finished_date' => 'nullable|date',
        ];
    }
    public function messages(): array
    {
        return [
            'long_term_goal_name.required' => '長期目標名は必ず入力してください',
            'long_term_goal_name.max' => '長期目標は50文字以下で入力してください',
            'expire_date.required' => '期限日は必ず入力してください',
            'expire_date.date' => '期限日は正しい日付で入力してください',
            'finished_date.date' => '終了日は正しい日付で入力してください'
        ];
    }
}
