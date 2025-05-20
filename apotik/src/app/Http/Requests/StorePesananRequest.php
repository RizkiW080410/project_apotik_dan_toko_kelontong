<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StorePesananRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pesanan_create');
    }

    public function rules()
    {
        return [
            'profile_id'    => ['required', 'exists:profiles,id'],
            'nomor_pesanan' => ['required'],
            'total'         => ['required', 'numeric', 'min:0'],
            'status'        => ['required'],
            'pengajuan_id'  => ['nullable', 'exists:pengajuans,id'],
        ];
    }
}
