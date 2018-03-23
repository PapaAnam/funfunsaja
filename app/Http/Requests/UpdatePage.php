<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Page;
use Route;

class UpdatePage extends FormRequest
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
        $id = Route::current()->parameters['id'];
        $page = Page::find($id);
        $isSame = trim($page->title) == trim($this->title);
        $thereIs = trim($page->thumbnail);
        return [
            'title' => $isSame ? 'required|string|min:10' : 'required|unique:pages|string|min:10',
            'content' => 'required|string|min:300',
            // 'thumbnail' => $thereIs ? 'mimes:jpeg,png|file|max:1000' : 'required|mimes:jpeg,png|file|max:1000',
            'tags' => 'required'
        ];
    }
}