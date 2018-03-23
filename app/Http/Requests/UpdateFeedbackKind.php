<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\FeedBackKind;
use Route;

class UpdateFeedbackKind extends FormRequest
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
        $p = FeedBackKind::find($id);
        return [
            'name' => $p->name == $this->name ? 'required|string' : 'required|string|unique:feedback_kinds',
            'path' => $p->path == $this->path ? 'required|string' : 'required|string|unique:feedback_kinds',
        ];
    }
}
