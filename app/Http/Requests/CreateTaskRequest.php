<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array{
     *     title: string,
     *     description: string,
     *     category: string,
     *     status: string
     * }|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required|max: 255',
            'category' => 'required|max: 255',
            'status' => 'required|max: 20'
        ];
    }
}
