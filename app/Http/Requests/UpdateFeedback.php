<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\FeedBack;
use Route;
use Storage;

class UpdateFeedback extends FormRequest
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
        $c = Route::current()->parameters['feedback'];
        $file = 'public/'.$c->thumbnail;
        $thumbIsNull = !Storage::exists($file) || !$c->thumbnail;
        return [
            'title' => $c->title != $this->title ? 'required|unique:contents|string' : 'required|string',
            'content' => 'required|string',
            // 'thumbnail' => $thumbIsNull ? 'required|mimes:jpeg,png|file|max:1000' : 'mimes:jpeg,png|file|max:1000',
            'tags' => 'required'
        ];
    }
}
