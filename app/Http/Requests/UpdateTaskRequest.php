<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array{
     *      title: string,
     *      description: string,
     *      category: string,
     *      status: string,
     *      id: string
     *  }|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'title' => 'required|max:255',
            'description' => 'required|max: 255',
            'category' => 'required|max: 255',
            'status' => 'required|max: 20'
        ];
    }
}
