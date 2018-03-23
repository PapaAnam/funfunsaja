<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositTransaction extends FormRequest
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
            'deposit' => 'required|numeric|min:50000',
            'sender_name' => 'required|string',
            'sender_bill' => 'required',
            'send_time' => 'required|date_format:d/m/Y H:i',
            'proof' => 'required|file|max:2000|mimes:jpeg,png',
            'receiver' => 'required'
        ];
    }
}
