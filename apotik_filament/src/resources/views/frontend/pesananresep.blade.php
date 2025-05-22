@extends('layouts.index')
@section('content')
<section class="py-5">
  <div class="container" style="max-width: 700px;"> <!-- Lebar maksimum dibatasi -->
    <div class="card shadow rounded-4 p-3 p-md-4">
      <div class="row justify-content-center">
        <div class="col-12">

          <!-- Info -->
          <div class="alert alert-info mt-3 mb-0 small">
            Silakan upload resep dokter dan isi data diri untuk konfirmasi produk obat.
            Tunggu admin merespon di tab <strong>Histori</strong> ya 😊
          </div>

          <!-- Upload Resep -->
          <div class="mt-4">
            <label for="uploadResep" class="form-label fw-semibold">Upload Resep Dokter</label>
            <input type="file" class="form-control" id="uploadResep" accept="image/*">
          </div>

          <!-- Catatan -->
          <div class="mt-3">
            <label for="catatanResep" class="form-label fw-semibold">Catatan Tambahan (Opsional)</label>
            <textarea id="catatanResep" class="form-control" rows="3" placeholder="Tulis catatan tambahan di sini..."></textarea>
          </div>

          <!-- Peta Lokasi -->
          <div class="mt-4">
            <label class="form-label fw-semibold">Lokasi Anda & Rute ke Apotek</label>
            <!-- Alert Penting GPS -->
            <div class="alert alert-danger mt-1 small fw-semibold" role="alert">
            <i class="bi bi-geo-alt-fill"></i> Penting! Aktifkan GPS atau izinkan lokasi di perangkat Anda agar peta dan total ongkir bisa muncul dengan akurat.
            </div>
            <div id="map" style="height: 300px; border-radius: 10px; margin-bottom: 15px;"></div>
          </div>
            <div class="alert alert-warning mt-2 small">
            Gratis Ongkir jika jarak tidak lebih dari 5 km jika lebih dihitung Rp3.000 per 1 km (dibulatkan ke atas).
            </div>

          <div id="ongkirInfo" class="mt-2 text-muted small fw-semibold">
            Ongkir: -
          </div>

          

          <!-- Tombol -->
          <div class="mt-4">
               <!-- ALERT PESANAN -->
        <div class="alert alert-info mt-3 small" role="alert">
          Silakan kirim pengajuan obat dan cek status beserta konfirmasi pesananmu di tab <strong>Pengajuan</strong> ya.
        </div>
        <button id="submitResepBtn" class="btn custom-btnn w-100 fw-semibold">
        Kirim Pengajuan Obat 
        </button>

          </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
