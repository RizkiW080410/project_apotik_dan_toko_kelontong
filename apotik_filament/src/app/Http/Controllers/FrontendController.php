<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $obats = Obat::with('jenis')->get();
        return view('frontend.home', compact('obats'));
    }

    public function pengajuan()
    {
        return view('frontend.pengajuan');
    }

    public function pesanan()
    {
        return view('frontend.pesanan');
    }

    public function pesananresep()
    {
        return view('frontend.pesananresep');
    }

    public function profile()
    {
        $user = auth()->user();
        $profile = $user->profile;
        return view('frontend.profile', compact('user', 'profile'));
    }
}
