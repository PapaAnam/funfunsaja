<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSlider extends FormRequest
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
            'image' => 'required|file|max:2000|mimes:jpeg,png',
            'content' => 'required|string',
            // 'url' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Deskripsi wajib diisi'
        ];
    }
}
