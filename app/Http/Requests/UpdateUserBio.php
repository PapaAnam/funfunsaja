<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserBio extends FormRequest
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
        $userExist = $this->user()->bio()->first();
        $nin_upload_exist = $userExist ? ($userExist->nin_upload ? true : false) : false;
        return [
            'nin' => 'required|numeric|min:10000000000000',
            'name' => 'required|string|min:4',
            'city_born' => 'required|string|min:4',
            'birthdate' => 'required|date|date_format:Y-m-d|before:'.date('Y-m-d', strtotime('-10 years')),
            'gender' => 'required|min:0|max:1',
            'address' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'region_id' => 'required',
            'village_id' => 'required',
            'post_code' => 'required|numeric|min:10000|max:99999',
            'married' => 'required|min:0|max:1',
            'nin_upload' => $nin_upload_exist ? 'nullable|file|mimes:jpeg,png|max:2000' : 'required|file|mimes:jpeg,png|max:2000',
        ];
    }

    public function messages()
    {
        return [
            'birthdate.before' => 'Minimal umur 10 tahun',
            'nin.min' => 'NIK tidak valid',
        ];
    }
}
