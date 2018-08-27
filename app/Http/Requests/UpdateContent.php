<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Content;
use Route;
use Storage;

class UpdateContent extends FormRequest
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
        $url              = Route::current()->parameters['content'];
        $c = Content::where('url', $url)->first();
        $file           = 'public/'.$c->thumbnail;
        $thumbIsNull    = !Storage::exists($file) || !$c->thumbnail;
        return [
            'title'     => $c->title != $this->title ? 'required|unique:contents|string|min:10' : 'required|string|min:10',
            'content'   => 'required|string|min:300',
            // 'thumbnail' => $thumbIsNull ? 'required|mimes:jpeg,png|file|max:1000' : 'mimes:jpeg,png|file|max:1000',
            'fee'       => $this->type == '1' ? 'required|numeric|min:1' : 'nullable',
            'tags'      => 'required'
        ];
    }
}
