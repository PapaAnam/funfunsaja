<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedback extends FormRequest
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
            'title' => 'required|unique:feedbacks|string',
            'content' => 'required|string',
            // 'thumbnail' => 'required|mimes:jpeg,png|file|max:1000',
            'tags' => 'required'
        ];
    }
}
