<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePengirimanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pengiriman_edit');
    }

    public function rules()
    {
        return [
            'pesanan_id'   => ['required', 'exists:pesanans,id'],
            'pengirim_id'  => ['required', 'exists:pengirims,id'],
            'alamat'       => ['required', 'string', 'max:255'],
            'jarak'        => ['nullable', 'numeric', 'min:0'],
            'total'        => ['required', 'numeric', 'min:0'],
            'status'       => ['required'],
        ];
    }
}
