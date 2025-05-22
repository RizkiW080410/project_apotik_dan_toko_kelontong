@extends('layouts.index')
@section('content')
<section class="container py-5">
  <h2 class="fw-bold mb-4 text-center">Daftar Pesanan Anda</h2>

  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">

      <!-- Card Pengajuan 1: Dengan Resep -->
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div><strong>ID Pengajuan:</strong> #PJ001</div>
            <div class="mb-1">
              <span class="badge bg-primary px-2 py-1">Pesanan dengan Resep Dokter</span>
            </div>
            <!-- <div><strong>Status:</strong> <span class="badge bg-danger text-white">Menunggu Pembayaran</span></div> -->
            <div><strong>Tanggal:</strong> 18 Mei 2025</div>
          </div>
          <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalPesananResep">Lihat Detail</button>
        </div>
      </div>

      <!-- Card Pengajuan 2: Tanpa Resep -->
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div><strong>ID Pesanan:</strong> #PJ002</div>
            <div class="mb-1">
              <span class="badge bg-success px-2 py-1">Pesanan Tanpa Resep Dokter</span>
            </div>
            <!-- <div><strong>Status:</strong> <span class="badge bg-danger text-white">Menunggu Pembayaran</span></div> -->
            <div><strong>Tanggal:</strong> 19 Mei 2025</div>
          </div>
          <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalPesananNonResep">Lihat Detail</button>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- Modal untuk Pesanan dengan Resep -->
<div class="modal fade" id="modalPesananResep" tabindex="-1" aria-labelledby="modalPesananResepLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl modal-fullscreen-md-down">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPesananResepLabel">Detail Pesanan #PJ001</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body p-4">
        <div class="card border-0 shadow rounded-4 overflow-hidden">
          <div class="card-body p-4">
            <!-- Profil -->
            <div class="d-flex align-items-center mb-4">
              <img src="front/assets/user.png" alt="User" width="60" height="60" class="rounded-circle shadow-sm me-3">
              <div>
                <h5 class="mb-0 fw-semibold">Melody Marks</h5>
                <small class="text-muted">melodymarks@gmail.com</small>
              </div>
            </div>

            <!-- Jenis Pesanan -->
            <div class="mb-3">
              <span class="badge bg-primary px-3 py-2 rounded-pill">Pesanan dengan Resep Dokter</span>
            </div>

            <!-- Status -->
            <div class="mb-1 fw-semibold">Status Pesanan:</div>
            <div class="mb-3">
              <span class="badge bg-danger px-3 py-2 rounded-pill">Menunggu Pembayaran</span>
            </div>

            <!-- Alert info -->
            <div class="alert alert-success small py-2 px-3 mb-3" role="alert">
              ✅ Obat kamu sudah disiapkan oleh apotek sesuai resep yang kamu upload. Berikut daftar obatnya:
              <ul class="mb-1 mt-2">
                <li>Paracetamol 500mg - 10 tablet</li>
                <li>Amoxicillin 500mg - 10 kapsul</li>
                <li>Vitamin C 500mg - 1 strip</li>
              </ul>
              💳 Silakan lakukan pembayaran dengan klik tombol <strong>Bayar Sekarang</strong> di bawah ya.
            </div>

            <!-- Foto Resep -->
            <div class="mb-3">
              <label class="fw-semibold">Foto Resep Dokter:</label>
              <div class="border rounded p-2 text-center">
                <img src="front/assets/resep.png" alt="Resep Dokter" class="img-fluid rounded" style="max-height: 400px; width: auto;">
              </div>
            </div>

            <!-- Catatan -->
            <div class="mb-3">
              <label class="fw-semibold">Catatan:</label>
              <div class="bg-light border rounded p-3">
                Tolong pastikan obat generik ya, dan dikirim sebelum jam 5 sore.
              </div>
            </div>

            <!-- Ongkir info -->
            <div class="alert alert-info fw-medium" role="alert">
              Gratis Ongkir jika jarak tidak lebih dari 5 km, jika lebih dihitung Rp3.000 per 1 km (dibulatkan ke atas).
            </div>

            <!-- Jarak dan Ongkir -->
            <div class="mb-3 d-flex justify-content-between">
              <span class="fw-semibold">Jarak dari Apotik ke Alamat Kamu:</span>
              <span class="text-muted">20 km</span>
            </div>

            <div class="mb-3 d-flex justify-content-between">
              <span class="fw-semibold">Total Ongkir:</span>
              <span class="text-success fw-bold">Rp15.000</span>
            </div>

            <!-- ✅ Total Produk & Total Pembayaran -->
            <div class="mb-3 d-flex justify-content-between">
              <span class="fw-semibold">Total Harga Produk:</span>
              <span class="text-dark fw-semibold">Rp50.000</span>
            </div>

            <div class="mb-4 d-flex justify-content-between border-top pt-3">
              <span class="fw-bold">Total Pembayaran:</span>
              <span class="text-success fw-bold">Rp65.000</span>
            </div>

            <!-- Tombol -->
            <div class="d-grid mt-2">
              <button class="btn btn-success fw-semibold py-2" style="border-radius: 12px;">
                Bayar Sekarang
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal untuk Pesanan tanpa Resep -->
<div class="modal fade" id="modalPesananNonResep" tabindex="-1" aria-labelledby="modalPesananNonResepLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl modal-fullscreen-md-down">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPesananNonResepLabel">Detail Pesanan #PJ002</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body p-4">
        <div class="card border-0 shadow rounded-4 overflow-hidden">
          <div class="card-body p-4">
            <div class="d-flex align-items-center mb-4">
              <img src="front/assets/user.png" alt="User" width="60" height="60" class="rounded-circle shadow-sm me-3">
              <div>
                <h5 class="mb-0 fw-semibold" id="namaUser">Nama Pengguna</h5>
                <small class="text-muted" id="emailUser">email@pengguna.com</small>
              </div>
            </div>

            <div class="mb-3">
              <span class="badge bg-success px-3 py-2 rounded-pill">Pesanan Tanpa Resep Dokter</span>
            </div>

            <div class="mb-1 fw-semibold">Status Pesanan:</div>
            <div class="mb-3">
              <span class="badge bg-danger px-4 py-2 rounded-pill">Menunggu pembayaran</span>
            </div>

            <div class="alert alert-success small py-2 px-3 mb-3" role="alert">
              🛒 Berikut detail produk yang kamu pesan. Silakan lakukan pembayaran jika sudah sesuai.
            </div>

            <div class="mb-3">
              <label class="fw-semibold">Daftar Produk:</label>
              <ul class="list-group" id="listProdukTanpaResep"></ul>
            </div>

            <div class="mb-3 d-flex justify-content-between">
              <span class="fw-semibold">Total Produk:</span>
              <span class="text-dark total-produk">Rp0</span>
            </div>

            <div class="mb-3 d-flex justify-content-between">
              <span class="fw-semibold">Ongkir:</span>
              <span class="text-dark total-ongkir">Rp0</span>
            </div>

            <div class="mb-4 d-flex justify-content-between border-top pt-3">
              <span class="fw-bold">Total Pembayaran:</span>
              <span class="text-success fw-bold total-bayar">Rp0</span>
            </div>

            <div class="d-grid">
              <button class="btn btn-success fw-semibold py-2" style="border-radius: 12px;">
                💳 Bayar Sekarang
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection