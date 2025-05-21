<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.home');
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
        return view('frontend.profile');
    }
}
