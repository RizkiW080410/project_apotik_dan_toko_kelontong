@extends('layouts.index')

@section('content')
    <!-- Konten hero carosel di awal -->
<section class="hero-section py-5">
  <div class="container">
    <div class="card p-4 shadow-lg rounded-4 overflow-hidden">

      <div id="heroCarousel" class="carousel slide" data-bs-interval="false">
        <div class="carousel-inner">

          <!-- Slide 1: Tanpa Resep Dokter -->
          <div class="carousel-item active">
            <div class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-5">
              <div class="text-area" style="max-width: 700px;">
                <h1 class="display-5 fw-bolder">
                  Pesan Produk Kesehatan<br>
                  <span class="text-primary">Tanpa Resep Dokter</span>
                </h1>
                <p class="lead text-muted fw-semibold">
                  Kami menyediakan berbagai produk kesehatan yang dapat langsung Anda pesan tanpa perlu resep dokter. Aman, mudah, dan langsung diantar ke rumah Anda.
                </p>
                <div class="mt-4 d-flex gap-3 flex-wrap">
                  <a href="#productpop" class="btn btn-success btn-lg">
                    <i class="bi bi-cart-plus"></i> Belanja Sekarang!
                  </a>
                  <button class="btn btn-outline-light btn-lg" data-bs-target="#heroCarousel" data-bs-slide="next">
                    Cek layanan pesan dengan resep dokter  →
                  </button>
                </div>
              </div>

              <div class="image-wrapper mt-4 mt-md-0 ms-md-4 d-flex justify-content-end align-items-end">
                <img src="front/assets/docter.png" alt="Doctor" class="hero-image" />
              </div>
            </div>
          </div>

          <!-- Slide 2: Dengan Resep Dokter -->
          <div class="carousel-item">
            <div class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-5">
              <div class="text-area" style="max-width: 700px;">
                <h1 class="display-5 fw-bolder">
                  Pesan Obat <span class="text-info">Dengan Resep Dokter</span>
                </h1>
                <p class="lead text-muted fw-semibold">
                  Upload resep dokter Anda secara online dan kami akan menyiapkan serta mengantarkan obat Anda dengan cepat dan aman langsung ke rumah.
                </p>
                <ul class="list-unstyled mt-4">
                  <li><i class="bi bi-check-circle-fill text-success me-2"></i>Upload Resep Secara Online</li>
                  <li><i class="bi bi-check-circle-fill text-success me-2"></i>Proses Validasi Cepat</li>
                  <li><i class="bi bi-check-circle-fill text-success me-2"></i>Obat Dijamin Keaslian & Keamanannya</li>
                  <li><i class="bi bi-check-circle-fill text-success me-2"></i>Pengiriman Langsung ke Rumah</li>
                </ul>
                <div class="mt-4 d-flex gap-3 flex-wrap">
                  <a href="/pesananresep" class="btn btn-info btn-lg d-inline-block text-white text-decoration-none">
                    Pesan Obat dengan Resep Dokter Anda
                  </a>

                  <button class="btn btn-outline-light btn-lg" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    ← Kembali
                  </button>
                </div>
              </div>

              <div class="image-wrapper mt-4 mt-md-0 ms-md-4 d-flex justify-content-end align-items-end">
                <img src="front/assets/dok.png" alt="Layanan" class="hero-image" />
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- End konten carosel di awal -->


<!-- Info Top Section -->
<section class="info-top py-4 bg-white">
  <div class="container">
    <div class="row text-center gy-4">
      <div class="col-6 col-md-3">
        <i class="bi bi-truck fs-3 bluee"></i>
        <h6 class="fw-semibold mt-2 darkk">Di Antar Sampai Rumah</h6>
        <small class="text-muted">Diantar dengan berbagai macam pilihan expedisi</small>
      </div>
      <div class="col-6 col-md-3">
        <i class="bi bi-shield-lock fs-3 bluee"></i>
        <h6 class="fw-semibold mt-2 darkk">Pembayaran Aman</h6>
        <small class="text-muted">Kami menjamin pembayaran aman</small>
      </div>
      <div class="col-6 col-md-3">
        <i class="bi bi-arrow-counterclockwise fs-3 bluee"></i>
        <h6 class="fw-semibold mt-2 darkk">Garansi Uang Kembali</h6>
        <small class="text-muted">Pengembalian uang 20 Hari</small>
      </div>
      <div class="col-6 col-md-3">
        <i class="bi bi-headset fs-3 bluee"></i>
        <h6 class="fw-semibold mt-2 darkk">24/9 Customer Support</h6>
        <small class="text-muted">Pelayanan yang ramah dan informatif </small>
      </div>
    </div>
  </div>
</section>
<!-- End Top Product -->

<!-- Populer Product Cards -->
<section class="product-promos py-5">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="image-wrapper">
            <img src="front/assets/vitc.png" alt="Nivea Serum" class="card-img-top">
          </div>
          <div class="card-body bg-light text-center">
            <h6 class="mb-0 fw-semibold">Immunoboost 1000mg Vitamin C Effervescent</h6>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100 position-relative">
          <div class="image-wrapper">
            <img src="front/assets/paratusin.png" alt="Beta Karoten" class="card-img-top">
           
          </div>
          <div class="card-body bg-light text-center">
            <h6 class="mb-0 fw-semibold">Paratusin Tablet</h6>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="image-wrapper">
            <img src="front/assets/purel.png" alt="Ecurerin" class="card-img-top">
          </div>
          <div class="card-body bg-light text-center">
            <h6 class="mb-0 fw-semibold">Purell Advanced Hand Sanitizer</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Populer Product -->

<!-- Produk Populer -->
<section id="productpop" class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Produk Populer</h4>
    <div class="d-flex gap-2">
      <button class="btn btn-light border rounded-circle shadow-sm" id="prevBtn">
        <i class="bi bi-chevron-left"></i>
      </button>
      <button class="btn btn-light border rounded-circle shadow-sm" id="nextBtn">
        <i class="bi bi-chevron-right"></i>
      </button>
    </div>
  </div>

  <div class="row g-4 flex-nowrap overflow-auto" id="productList">

    <!-- CARD 1 -->
    <div class="col-10 col-sm-6 col-md-4 col-lg-3 flex-shrink-0">
      <div class="card h-100 border rounded shadow-sm p-2 d-flex flex-column">
        <div class="position-relative">
          <img src="front/assets/amox.png" class="card-img-top" alt="Produk 1">
          <span class="position-absolute top-0 start-0 badge bg-danger m-2">Perlu Resep Dokter</span>
        </div>
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <p class="text-muted small mb-1">Antibiotik</p>
            <h6 class="card-title fw-semibold">Amoxicillin Capsuelles 500mg</h6>
          </div>
          <hr class="my-2">
        </div>
        <div class="card-footer bg-transparent border-0">
          <div class="d-flex flex-column">
            <p class="text-danger fw-bold mb-2 harga-produk">Rp.15.000</p>
          </div>
        </div>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="col-10 col-sm-6 col-md-4 col-lg-3 flex-shrink-0">
      <div class="card h-100 border rounded shadow-sm p-2 d-flex flex-column">
        <div class="position-relative">
          <img src="front/assets/vitc2.png" class="card-img-top" alt="Produk 2">
          <span class="position-absolute top-0 start-0 badge bg-success m-2">Tanpa Resep Dokter</span>
        </div>
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <p class="text-muted small mb-1">Vitamin</p>
            <h6 class="card-title fw-semibold">Immunoboost 1000mg Vitamin C Effervescent</h6>
          </div>
          <hr class="my-2">
        </div>
        <div class="card-footer bg-transparent border-0">
          <div class="d-flex flex-column">
            <p class="text-danger fw-bold mb-2 harga-produk">Rp.25.000</p>
            <button class="btn custom-btn w-100 cart-icon-populer">
              <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="col-10 col-sm-6 col-md-4 col-lg-3 flex-shrink-0">
      <div class="card h-100 border rounded shadow-sm p-2 d-flex flex-column">
        <div class="position-relative">
          <img src="front/assets/oxy.png" class="card-img-top" alt="Produk 3">
          <span class="position-absolute top-0 start-0 badge bg-danger m-2">Perlu Resep Dokter</span>
        </div>
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <p class="text-muted small mb-1">Narkotik</p>
            <h6 class="card-title fw-semibold">Oxycodone and Acetaminophen 325mg</h6>
          </div>
          <hr class="my-2">
        </div>
        <div class="card-footer bg-transparent border-0">
          <div class="d-flex flex-column">
            <p class="text-danger fw-bold mb-2 harga-produk">Rp.45.000</p>
          </div>
        </div>
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="col-10 col-sm-6 col-md-4 col-lg-3 flex-shrink-0">
      <div class="card h-100 border rounded shadow-sm p-2 d-flex flex-column">
        <div class="position-relative">
          <img src="front/assets/anti.png" class="card-img-top" alt="Produk 4">
          <span class="position-absolute top-0 start-0 badge bg-success m-2">Tanpa Resep Dokter</span>
        </div>
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <p class="text-muted small mb-1">Antiseptic</p>
            <h6 class="card-title fw-semibold">First Aid Antiseptic Ointment</h6>
          </div>
          <hr class="my-2">
        </div>
        <div class="card-footer bg-transparent border-0">
          <div class="d-flex flex-column">
            <p class="text-danger fw-bold mb-2 harga-produk">Rp.19.000</p>
              <button class="btn custom-btn w-100 cart-icon-populer">
              <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
            </button>
          </div>
        </div>
      </div>
    </div>

      <!-- CARD 3 -->
    <div class="col-10 col-sm-6 col-md-4 col-lg-3 flex-shrink-0">
      <div class="card h-100 border rounded shadow-sm p-2 d-flex flex-column">
        <div class="position-relative">
          <img src="front/assets/oxy.png" class="card-img-top" alt="Produk 3">
          <span class="position-absolute top-0 start-0 badge bg-danger m-2">Perlu Resep Dokter</span>
        </div>
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <p class="text-muted small mb-1">Narkotik</p>
            <h6 class="card-title fw-semibold">Oxycodone and Acetaminophen 325mg</h6>
          </div>
          <hr class="my-2">
        </div>
        <div class="card-footer bg-transparent border-0">
          <div class="d-flex flex-column">
            <p class="text-danger fw-bold mb-2 harga-produk">Rp.45.000</p>
          </div>
        </div>
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="col-10 col-sm-6 col-md-4 col-lg-3 flex-shrink-0">
      <div class="card h-100 border rounded shadow-sm p-2 d-flex flex-column">
        <div class="position-relative">
          <img src="front/assets/anti.png" class="card-img-top" alt="Produk 4">
          <span class="position-absolute top-0 start-0 badge bg-success m-2">Tanpa Resep Dokter</span>
        </div>
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <p class="text-muted small mb-1">Antiseptic</p>
            <h6 class="card-title fw-semibold">First Aid Antiseptic Ointment</h6>
          </div>
          <hr class="my-2">
        </div>
        <div class="card-footer bg-transparent border-0">
          <div class="d-flex flex-column">
            <p class="text-danger fw-bold mb-2 harga-produk">Rp.19.000</p>
          <button class="btn custom-btn w-100 cart-icon-populer">
            <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
          </button>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
<!-- End Populer product -->



<!-- product -->
<section id="producttanparesep" class="container mt-7">
  <!-- Garis pembatas -->
  <hr class="border-top border-2 border-secondary opacity-25 my-5" />

  <div class="row">
    <!-- Sidebar Kategori -->
    <div class="col-lg-3 mb-4">
      <h5 class="fw-bold mb-2">Belanja Sekarang !</h5>
      <h6 class="fw-semibold mb-3">Kaetgori Produk</h6>
      <div class="list-group kategori-list shadow-sm">
      <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-kategori="Vitamin">
        Vitamin <i class="bi bi-plus-circle-fill"></i>
      </a>
      <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-kategori="Obat Batuk">
        Obat Batuk <i class="bi bi-plus-circle-fill"></i>
      </a>
      <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-kategori="Obat Flu">
        Obat Flu <i class="bi bi-plus-circle-fill"></i>
      </a>
      <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-kategori="Obat Demam">
        Obat Demam <i class="bi bi-plus-circle-fill"></i>
      </a>
      <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-kategori="Obat Luka">
        Obat Luka <i class="bi bi-plus-circle-fill"></i>
      </a>
      <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-kategori="Obat Alergi">
        Obat Alergi <i class="bi bi-plus-circle-fill"></i>
      </a>
      <a href="#" id="lihat-semua" class="list-group-item list-group-item-action fw-bold text-center text-primary">
        Lihat Semua Produk
      </a>

      </div>
    </div>

    <!-- Daftar Produk -->
    <div class="col-lg-9">
      <div class="row g-4">
        <!-- Card Produk -->
        <div class="col-6 col-md-4 col-lg-3" data-kategori="Obat Batuk">
          <div class="card card-obat h-100 position-relative">
            <span class="badge bg-success text-white position-absolute top-0 start-0 rounded-end px-2 py-1 small z-1">
              Tanpa Resep
            </span>
            <div class="img-hover-container">
              <img src="front/assets/tusin.png" class="card-img-top" alt="Paratusin">
            </div>
            <div class="card-body px-3 pt-3">
              <p class="text-muted small mb-1 d-flex justify-content-start align-items-center gap-1">
                Obat Batuk
              </p>
              <h6 class="fw-semibold mb-2 small">Paratusin  1 Strip 10 Tablet</h6>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center px-3 py-2 bg-white border-0">
              <span class="harga-produk fw-bold">Rp16.500</span>
              <div class="cart-icon rounded-circle d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-cart-plus-fill"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Card Produk Lain -->
        <div class="col-6 col-md-4 col-lg-3"data-kategori="Vitamin">
          <div class="card card-obat h-100 position-relative">
            <span class="badge bg-success text-white position-absolute top-0 start-0 rounded-end px-2 py-1 small z-1">
              Tanpa Resep
            </span>
            <div class="img-hover-container">
              <img src="front/assets/vitc.png" class="card-img-top" alt="Vitamin C">
            </div>
            <div class="card-body px-3 pt-3">
              <p class="text-muted small mb-1 d-flex justify-content-start align-items-center gap-1">
                Vitamin
              </p>
              <h6 class="fw-semibold mb-2 small">Vitamin C 1000mg</h6>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center px-3 py-2 bg-white border-0">
              <span class="harga-produk fw-bold">Rp29.000</span>
              <div class="cart-icon rounded-circle d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-cart-plus-fill"></i>
              </div>
            </div>
          </div>
        </div>

              
        <div class="col-6 col-md-4 col-lg-3"data-kategori="Obat Demam">
          <div class="card card-obat h-100 position-relative">
            <span class="badge bg-success text-white position-absolute top-0 start-0 rounded-end px-2 py-1 small z-1">
              Tanpa Resep
            </span>
            <div class="img-hover-container">
              <img src="front/assets/dem.png" class="card-img-top" alt="Vitamin C">
            </div>
            <div class="card-body px-3 pt-3">
              <p class="text-muted small mb-1 d-flex justify-content-start align-items-center gap-1">
                Obat Demam
              </p>
              <h6 class="fw-semibold mb-2 small">Vermint 12 Kapsul 250mg</h6>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center px-3 py-2 bg-white border-0">
              <span class="harga-produk fw-bold">Rp29.000</span>
              <div class="cart-icon rounded-circle d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-cart-plus-fill"></i>
              </div>
            </div>
          </div>
        </div>

        
        <div class="col-6 col-md-4 col-lg-3"data-kategori="Obat Batuk">
          <div class="card card-obat h-100 position-relative">
            <span class="badge bg-success text-white position-absolute top-0 start-0 rounded-end px-2 py-1 small z-1">
              Tanpa Resep
            </span>
            <div class="img-hover-container">
              <img src="front/assets/vickss.png" class="card-img-top" alt="Vitamin C">
            </div>
            <div class="card-body px-3 pt-3">
              <p class="text-muted small mb-1 d-flex justify-content-start align-items-center gap-1">
                Obat Batuk
              </p>
              <h6 class="fw-semibold mb-2 small">Vicks Formula 44 Sirup 100 ml</h6>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center px-3 py-2 bg-white border-0">
              <span class="harga-produk fw-bold">Rp38.000</span>
              <div class="cart-icon rounded-circle d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-cart-plus-fill"></i>
              </div>
            </div>
          </div>
        </div>

        
        <div class="col-6 col-md-4 col-lg-3" data-kategori="Obat Luka">
          <div class="card card-obat h-100 position-relative">
            <span class="badge bg-success text-white position-absolute top-0 start-0 rounded-end px-2 py-1 small z-1">
              Tanpa Resep
            </span>
            <div class="img-hover-container">
              <img src="front/assets/betadine.png" class="card-img-top" alt="Vitamin C">
            </div>
            <div class="card-body px-3 pt-3">
              <p class="text-muted small mb-1 d-flex justify-content-start align-items-center gap-1">
                Obat Luka
              </p>
              <h6 class="fw-semibold mb-2 small">Betadine Antiseptik</h6>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center px-3 py-2 bg-white border-0">
              <span class="harga-produk fw-bold">Rp31.000</span>
              <div class="cart-icon rounded-circle d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-cart-plus-fill"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3" data-kategori="Obat Flu">
          <div class="card card-obat h-100 position-relative">
            <span class="badge bg-success text-white position-absolute top-0 start-0 rounded-end px-2 py-1 small z-1">
              Tanpa Resep
            </span>
            <div class="img-hover-container">
              <img src="front/assets/bod.png" class="card-img-top" alt="Vitamin C">
            </div>
            <div class="card-body px-3 pt-3">
              <p class="text-muted small mb-1 d-flex justify-content-start align-items-center gap-1">
                Obat flu
              </p>
              <h6 class="fw-semibold mb-2 small">Bodrek Flu Dan Batuk Berdahak PE 4 Kaplet</h6>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center px-3 py-2 bg-white border-0">
              <span class="harga-produk fw-bold">Rp8.000</span>
              <div class="cart-icon rounded-circle d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-cart-plus-fill"></i>
              </div>
            </div>
          </div>
        </div>

                <div class="col-6 col-md-4 col-lg-3" data-kategori="Obat Flu">
          <div class="card card-obat h-100 position-relative">
            <span class="badge bg-success text-white position-absolute top-0 start-0 rounded-end px-2 py-1 small z-1">
              Tanpa Resep
            </span>
            <div class="img-hover-container">
              <img src="front/assets/pan.png" class="card-img-top" alt="Vitamin C">
            </div>
            <div class="card-body px-3 pt-3">
              <p class="text-muted small mb-1 d-flex justify-content-start align-items-center gap-1">
                Obat flu
              </p>
              <h6 class="fw-semibold mb-2 small">Panadol Anak Paracetamol 60ml</h6>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center px-3 py-2 bg-white border-0">
              <span class="harga-produk fw-bold">Rp20.000</span>
              <div class="cart-icon rounded-circle d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-cart-plus-fill"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3"data-kategori="Obat Alergi">
          <div class="card card-obat h-100 position-relative">
             <span class="badge bg-danger text-white position-absolute top-0 start-0 rounded-end px-2 py-1 small z-1">
              Perlu Resep
            </span>
            <div class="img-hover-container">
              <img src="front/assets/alergi.png" class="card-img-top" alt="Vitamin C">
            </div>
            <div class="card-body px-3 pt-3">
              <p class="text-muted small mb-1 d-flex justify-content-start align-items-center gap-1">
              Obat Alergi
              </p>
              <h6 class="fw-semibold mb-2 small">Telfast 60 mg 10 Tablet</h6>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center px-3 py-2 bg-white border-0">
              <span class="harga-produk fw-bold">Rp77.000</span>
            </div>
          </div>
        </div>

        <!-- Tambahin cardnya ki -->

      </div>
    </div>
  </div>
</section>
@endsection