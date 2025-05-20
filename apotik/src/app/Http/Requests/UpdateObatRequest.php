<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateObatRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('obat_edit');
    }

    public function rules()
    {
        return [
            'jenis_id'          => ['required', 'exists:jenis,id'],
            'golongan_id'       => ['required', 'exists:golongans,id'],
            'kode_obat'         => ['required'],
            'nama_obat'         => ['required', 'string', 'max:255'],
            'komposisi'         => ['nullable', 'string'],
            'dosis'             => ['nullable', 'string'],
            'aturan_pakai'      => ['nullable', 'string'],
            'nomor_izin_edar'   => ['nullable', 'string', 'max:255'],
            'tanggal_kadaluarsa'=> ['nullable', 'date'],
            'harga'             => ['required', 'numeric', 'min:0'],
            'stok'              => ['required', 'integer', 'min:0'],
            'status_label'      => ['required'],
            'status'            => ['required'],
        ];
    }
}
