<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePengajuanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pengajuan_edit');
    }

    public function rules()
    {
        return [
            'profile_id' => ['required', 'exists:profiles,id'],
            'catatan'   => ['nullable', 'string'],
            'alamat'    => ['required', 'string', 'max:255'],
            'jarak'     => ['nullable', 'numeric', 'min:0'],
            'total'     => ['required', 'numeric', 'min:0'],
            'status'    => ['required'],
        ];
    }
}
