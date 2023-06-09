<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionStoreRequest extends FormRequest
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
            'bill_id' => 'required',
            'student_id' => 'required',
            'amount' => 'required|numeric|digits_between:3,191',
            'note' => 'max:191'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'student_id.required' => 'Kolom id pelajar wajib diisi!',

            'bill_id.required' => 'Kolom id tagihan wajib diisi!',

            'amount.required' => 'Kolom total bayar wajib diisi!',
            'amount.numeric' => 'Kolom total bayar harus angka!',
            'amount.digits_between' => 'Kolom total bayar maksimal 191 karakter!',

            'note.max' => 'Kolom keterangan maksimal 191 karakter!'
        ];
    }
}
