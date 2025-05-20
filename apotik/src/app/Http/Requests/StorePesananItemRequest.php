<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StorePesananItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pesanan_item_create');
    }

    public function rules()
    {
        return [
            'obat_id'    => ['required', 'exists:obats,id'],
            'pesanan_id' => ['required', 'exists:pesanans,id'],
            'qty'        => ['required', 'integer', 'min:1'],
            'total'      => ['required', 'numeric', 'min:0'],
        ];
    }
}
