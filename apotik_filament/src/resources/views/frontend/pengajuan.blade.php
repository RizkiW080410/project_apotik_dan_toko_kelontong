@extends('layouts.index')
@section('content')
<!-- Section List Pengajuan -->
<section class="container py-5">
  <h2 class="fw-bold mb-4 text-center">Daftar Pengajuan Obat</h2>

  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div><strong>ID Pengajuan:</strong> #PJ001</div>
            <div><strong>Status:</strong> <span class="badge bg-warning text-white">Menunggu konfirmasi</span></div>
            <div><strong>Tanggal:</strong> 18 Mei 2025</div>
          </div>
          <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalDetailPengajuan">Lihat Detail</button>
        </div>
      </div>

        <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div><strong>ID Pengajuan:</strong> #PJ002</div>
            <div><strong>Status:</strong> <span class="badge bg-success text-white">Sudah Di konfirmasi</span></div>
            <div><strong>Tanggal:</strong> 19 Mei 2025</div>
          </div>
          <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalDetailPengajuan2">Lihat Detail</button>
        </div>
      </div>


      <!-- Tambahkan lebih banyak card pengajuan di sini jika perlu -->
    </div>
  </div>
</section>

<!-- Modal Detail Pengajuan -->
<div class="modal fade" id="modalDetailPengajuan" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalDetailLabel">Detail Pengajuan #PJ001</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <!-- Info Pemesan -->
        <div class="d-flex align-items-center mb-4">
          <img src="front/assets/user.png" alt="User" width="60" height="60" class="rounded-circle me-3 shadow-sm">
          <div>
            <h6 class="mb-0 fw-semibold">Melody Marks</h6>
            <small class="text-muted">melodymarks@gmail.com</small>
          </div>
        </div>
            <div class="mb-3">
              <span class="badge bg-primary px-3 py-2 rounded-pill">Pesanan dengan Resep Dokter</span>
            </div>

            <div class="mb-1 fw-semibold">Status Pesanan:</div>
            <div class="mb-3">
              <span class="badge bg-warning px-3 py-2 rounded-pill">Menunggu Konfirmasi</span>
            </div>

        <div class="alert alert-info small py-2 px-3 mb-3" role="alert">
          ⏳ Tunggu ya, pengajuanmu sedang diproses oleh admin. Jika sudah dicek, status akan berubah otomatis.
        </div>

        <!-- Foto Resep -->
        <div class="mb-3">
          <label class="fw-semibold">Foto Resep:</label>
          <div class="border rounded p-2 text-center">
            <img src="front/assets/resep.png" alt="Resep Dokter" class="img-fluid rounded" style="max-height: 400px;">
          </div>
        </div>

        <!-- Catatan -->
        <div class="mb-3">
          <label class="fw-semibold">Catatan:</label>
          <div class="bg-light border rounded p-3">
            Tolong pastikan obat generik ya, dan dikirim sebelum jam 5 sore.
          </div>
        </div>

        <!-- Estimasi Jarak dan Ongkir -->
        <div class="mb-3 d-flex justify-content-between">
          <span class="fw-semibold">Jarak ke Apotik:</span>
          <span class="text-muted">20 km</span>
        </div>
        <div class="mb-3 d-flex justify-content-between">
          <span class="fw-semibold">Ongkir Estimasi:</span>
          <span class="fw-bold text-success">Rp15.000</span>
        </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal Detail Pengajuan menunggu pembayaran-->
<div class="modal fade" id="modalDetailPengajuan2" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalDetailLabel">Detail Pengajuan #PJ001</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <!-- Info Pemesan -->
        <div class="d-flex align-items-center mb-4">
          <img src="front/assets/user.png" alt="User" width="60" height="60" class="rounded-circle me-3 shadow-sm">
          <div>
            <h6 class="mb-0 fw-semibold">Melody Marks</h6>
            <small class="text-muted">melodymarks@gmail.com</small>
          </div>
        </div>
            <div class="mb-3">
              <span class="badge bg-primary px-3 py-2 rounded-pill">Pesanan dengan Resep Dokter</span>
            </div>

            <div class="mb-1 fw-semibold">Status Pesanan:</div>
        <!-- Status & Info -->
        <div class="mb-3">
          <span class="badge bg-success px-3 py-2 rounded-pill text-white">Sudah Di Konfirmasi</span>
        </div>

        <div class="alert alert-info small py-2 px-3 mb-3" role="alert">
          ✅ Pengajuan mu sudah di konfirmasi oleh admin silahkan cek halaman pesanan untuk membayar tagihan
        </div>

        <!-- Foto Resep -->
        <div class="mb-3">
          <label class="fw-semibold">Foto Resep:</label>
          <div class="border rounded p-2 text-center">
            <img src="front/assets/resep.png" alt="Resep Dokter" class="img-fluid rounded" style="max-height: 400px;">
          </div>
        </div>

        <!-- Catatan -->
        <div class="mb-3">
          <label class="fw-semibold">Catatan:</label>
          <div class="bg-light border rounded p-3">
            Tolong pastikan obat generik ya, dan dikirim sebelum jam 5 sore.
          </div>
        </div>

        <!-- Estimasi Jarak dan Ongkir -->
        <div class="mb-3 d-flex justify-content-between">
          <span class="fw-semibold">Jarak ke Apotik:</span>
          <span class="text-muted">20 km</span>
        </div>
        <div class="mb-3 d-flex justify-content-between">
          <span class="fw-semibold">Ongkir Estimasi:</span>
          <span class="fw-bold text-success">Rp15.000</span>
        </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection
