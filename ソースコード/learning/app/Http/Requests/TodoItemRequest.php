<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoItemRequest extends FormRequest
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
            'item_name'=>'required|max:100',
            'expire_date'=>'required|date',
            'finished_date' => 'nullable|date',
        ];
    }

    public function messages() :array{
        return[
            'item_name.required'=>'項目名は必ず入力してください',
            'item_name.max'=>'項目名は100文字以下で入力してください',
            'expire_date.required'=>'期限日は必ず入力してください',
            'expire_date.date'=>'正しい日付で入力してください',
            'finished_date.date' => '終了日は正しい日付で入力してください',
        ];
    }
}
