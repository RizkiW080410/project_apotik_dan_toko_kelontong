<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('profile_edit');
    }

    public function rules()
    {
        return [
            'user_id'        => ['required', 'exists:users,id'],
            'nama_lengkap'   => ['required', 'string', 'max:255'],
            'nomor_telepon'  => ['required', 'string', 'max:20'],
            'jenis_kelamin'  => ['required', 'in:laki-laki,perempuan'],
            'tanggal_lahir'  => ['required', 'date'],
        ];
    }
}
