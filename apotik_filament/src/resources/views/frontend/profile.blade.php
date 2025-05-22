@extends('layouts.index')
@section('content')

<section class="py-5">
    <div class="container">
      <div class="card shadow rounded-4 p-4 mx-auto" style="max-width: 500px;">
        <div class="text-center mb-4">
          <img 
            src="{{ $user->avatar ?? asset('front/assets/user.png') }}" 
            class="rounded-circle shadow" 
            width="100" height="100" alt="Avatar"
          >
          <h6 class="mt-2 fw-bold" id="profilNama">{{ $profile->nama_lengkap ?? $user->name }}</h6>
        </div>

        <ul class="list-group list-group-flush small">
          <li class="list-group-item d-flex justify-content-between">
            <span>Email</span>
            <span class="fw-semibold text-end">{{ $user->email }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Nomor Telepon</span>
            <span class="fw-semibold text-end">{{ $profile->nomor_telepon ?? '-' }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Tanggal Lahir</span>
            <span class="fw-semibold text-end">{{ $profile->tanggal_lahir ?? '-' }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Jenis Kelamin</span>
            <span class="fw-semibold text-end">{{ $profile->jenis_kelamin ?? '-' }}</span>
          </li>
        </ul>

        <div class="mt-4 text-center">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger rounded-pill w-100">Keluar Akun</button>
          </form>
        </div>
      </div>
    </div>
</section>

@endsection
