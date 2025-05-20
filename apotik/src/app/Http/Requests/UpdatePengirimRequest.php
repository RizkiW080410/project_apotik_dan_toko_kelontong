<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePengirimRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pengirim_edit');
    }

    public function rules()
    {
        return [
            'name'           => ['required', 'string', 'max:255'],
            'nomor_telepon'  => ['required', 'string', 'max:20'],
            'email'          => ['nullable', 'email', 'max:255'],
            'jenis_kelamin'   => ['required'],
            'jenis_kendaraan' => ['required', 'string', 'max:255'],
        ];
    }
}
