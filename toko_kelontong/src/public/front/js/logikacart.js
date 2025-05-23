// logikacart.js

let cartItems = {};
let lastOrderIdFull = null;

const cartOffcanvas    = new bootstrap.Offcanvas(document.getElementById('cartSidebar'));
const checkoutModal    = new bootstrap.Modal(document.getElementById('checkoutModal'));
const orderStatusModal = new bootstrap.Modal(document.getElementById('orderStatusModal'));
const successModal     = new bootstrap.Modal(document.getElementById('successModal'));

document.addEventListener('DOMContentLoaded', () => {
  // — tombol “Add to cart”
  document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
    btn.addEventListener('click', () => {
      const id     = btn.dataset.id;
      const name   = btn.dataset.name;
      const price  = parseInt(btn.dataset.price, 10);
      const imgSrc = btn.dataset.image;
      const img    = btn.closest('.product').querySelector('.product-img');

      animateToCart(img);
      addToCart(id, name, price, imgSrc);
    });
  });

  // — buka sidebar keranjang
  document.querySelectorAll('.open-cart').forEach(btn => {
    btn.addEventListener('click', e => {
      e.preventDefault();
      cartOffcanvas.show();
    });
  });

  // — buka modal status pesanan
  const orderIcon = document.getElementById('orderIcon');
  if (orderIcon) {
    orderIcon.addEventListener('click', e => {
      e.preventDefault();
      orderStatusModal.show();
    });
  }

  // — submit checkout
  document.getElementById('orderForm')
          .addEventListener('submit', e => {
    e.preventDefault();
    buatPesanan();
  });

  // — saat checkout modal muncul, render detail + init map
  document.getElementById('checkoutModal')
          .addEventListener('show.bs.modal', () => {
    renderCheckoutModal();
    setTimeout(initMapAndRoute, 500);
  });
});

// Animasi terbang ke cart
function animateToCart(imgElement) {
  const cartIcon = document.querySelector('.open-cart i');
  const imgClone = imgElement.cloneNode(true);
  const from    = imgElement.getBoundingClientRect();
  const to      = cartIcon.getBoundingClientRect();

  Object.assign(imgClone.style, {
    position:   'fixed',
    left:       `${from.left}px`,
    top:        `${from.top}px`,
    width:      `${from.width}px`,
    height:     `${from.height}px`,
    zIndex:     9999,
    transition: 'all 0.8s ease-in-out'
  });
  document.body.appendChild(imgClone);

  setTimeout(() => {
    Object.assign(imgClone.style, {
      left:      `${to.left}px`,
      top:       `${to.top}px`,
      opacity:   '0',
      transform: 'scale(0.1)'
    });
  }, 10);

  setTimeout(() => imgClone.remove(), 900);
}

// ——— Cart logic ———

function addToCart(id, name, price, imgSrc) {
  if (!cartItems[id]) {
    cartItems[id] = { name, price, qty: 1, imgSrc };
  } else {
    cartItems[id].qty++;
  }
  updateCartUI();
}

function changeQty(id, delta) {
  if (!cartItems[id]) return;
  cartItems[id].qty += delta;
  if (cartItems[id].qty < 1) {
    delete cartItems[id];
  }
  updateCartUI();
}

function updateCartUI() {
  renderSidebar();
  updateTotal();
  updateCartBadge();
}

function renderSidebar() {
  const body = document.getElementById('cartSidebarBody');
  body.innerHTML = '';
  Object.entries(cartItems).forEach(([id, item]) => {
    const el = document.createElement('div');
    el.id = `sidebar-item-${id}`;
    el.className = 'd-flex justify-content-between align-items-center mb-3';
    el.innerHTML = `
      <div class="d-flex align-items-start gap-2">
        <img src="${item.imgSrc}" width="50" height="50" style="object-fit:cover;border-radius:8px;">
        <div><strong>${item.name}</strong><br><small class="text-muted">Rp${item.price.toLocaleString()}</small></div>
      </div>
      <div class="d-flex align-items-center gap-1">
        <button class="btn btn-sm btn-outline-secondary" onclick="changeQty('${id}', -1)">−</button>
        <span id="qty-${id}">${item.qty}</span>
        <button class="btn btn-sm btn-outline-secondary" onclick="changeQty('${id}', 1)">+</button>
      </div>`;
    body.appendChild(el);
  });
}

function updateTotal() {
  const sum = Object.values(cartItems)
                    .reduce((acc, it) => acc + it.price * it.qty, 0);
  document.getElementById('cartTotal').innerText = `Rp${sum.toLocaleString()}`;
}

function updateCartBadge() {
  const totalQty = Object.values(cartItems)
                         .reduce((acc, it) => acc + it.qty, 0);
  const badge = document.getElementById('cartBadge');
  if (totalQty > 0) {
    badge.innerText = totalQty;
    badge.classList.remove('d-none');
  } else {
    badge.classList.add('d-none');
  }
}

// ——— Render checkout modal detail ———

function renderCheckoutModal() {
  const det = document.getElementById('orderDetails');
  det.innerHTML = '';
  let totalProduk = 0;

  Object.values(cartItems).forEach(item => {
    const row = document.createElement('div');
    row.className = 'd-flex justify-content-between mb-2';
    row.innerHTML = `<div><strong>${item.name}</strong> x ${item.qty}</div>
                     <div>${formatRupiah(item.price * item.qty)}</div>`;
    det.appendChild(row);
    totalProduk += item.price * item.qty;
  });

  document.getElementById('totalProdukCheckout').innerText = formatRupiah(totalProduk);

  // shipping cost sudah diisi oleh map.js
  const ongkir = parseInt(
    (document.getElementById('shippingCost').value || '')
      .replace(/\D/g, ''),
    10
  ) || 0;

  document.getElementById('totalOngkirCheckout').innerText = formatRupiah(ongkir);
  document.getElementById('totalWithShipping').innerText = formatRupiah(totalProduk + ongkir);
  document.getElementById('checkoutTotal').innerText   = formatRupiah(totalProduk + ongkir);
}

// … selanjutnya fungsi buatPesanan(), handleMidtransResult(), initMapAndRoute(), formatRupiah() …


function buatPesanan() {
  const items  = Object.entries(cartItems).map(([id,i]) => ({ id: parseInt(id), qty: i.qty, price: i.price }));
  const alamat = document.getElementById('userAddress').value.trim();
  const jarak  = parseFloat(document.getElementById('distance').value) || 0;
  const ongkir = parseInt(document.getElementById('shippingCost').value.replace(/\D/g,''),10) || 0;
  const total  = items.reduce((sum,i)=>sum + i.qty*i.price,0) + ongkir;

  fetch('/checkout', {
    method: 'POST',
    credentials: 'same-origin',
    headers: {
      'Content-Type': 'application/json',
      'Accept':       'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    // kirim sesuai validasi controller
    body: JSON.stringify({ cart: items, alamat, jarak, ongkir, total })
  })
  .then(res => {
    if (!res.ok) return res.json().then(err => { throw err });
    return res.json();
  })
  .then(data => {
    lastOrderIdFull = data.order_id_full;
    window.snap.pay(data.snap_token, {
      onSuccess: handleMidtransResult,
      onPending: handleMidtransResult,
      onError:   () => alert('Pembayaran gagal.'),
      onClose:   () => alert('Anda belum menyelesaikan pembayaran.')
    });
  })
  .catch(err => {
    console.error('Checkout error detail:', err);
    const msg = err.message || (err.errors ? Object.values(err.errors).flat().join('\n') : 'Terjadi kesalahan.');
    alert('Gagal membuat pesanan:\n' + msg);
  });
}


function handleMidtransResult(result) {
  fetch('/checkout/status', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      order_id_full:      lastOrderIdFull,
      transaction_status: result.transaction_status
    })
  })
  .then(r => r.json())
  .then(js => {
    if (js.success) {
      // reset UI
      cartItems = {};
      cartCount = 0;
      document.getElementById('cartBadge').classList.add('d-none');
      cartOffcanvas.hide();
      checkoutModal.hide();
      successModal.show();
    } else {
      alert('Gagal update status: ' + js.message);
    }
  })
  .catch(err => {
    console.error('Error update status', err);
    alert('Error menghubungi server saat update status.');
  });
}

function formatRupiah(a) {
  return 'Rp' + a.toLocaleString('id-ID');
}

// … (initMapAndRoute tetap sama seperti sebelumnya) …


function updateCheckoutTotal(ongkir) {
    const totalProdukElement = document.getElementById('totalProdukCheckout');
    const totalOngkirElement = document.getElementById('totalOngkirCheckout');
    const totalKeseluruhanElement = document.getElementById('totalWithShipping');
    const checkoutTotalElement = document.getElementById('checkoutTotal');

    const totalProduk = Object.values(cartItems).reduce((sum, item) => sum + item.qty * item.price, 0);
    const totalKeseluruhan = totalProduk + ongkir;

    totalProdukElement.innerText = formatRupiah(totalProduk);
    totalOngkirElement.innerText = formatRupiah(ongkir);
    totalKeseluruhanElement.innerText = formatRupiah(totalKeseluruhan);
    checkoutTotalElement.innerText = formatRupiah(totalKeseluruhan);
}

function initMapAndRoute() {
    const tokoLat = -6.246761;
    const tokoLng = 106.729114;
    const mapContainer = document.getElementById('map');

    if (!mapContainer) return;

    const map = L.map('map').setView([tokoLat, tokoLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([tokoLat, tokoLng]).addTo(map).bindPopup("Toko").openPopup();

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;

            L.marker([userLat, userLng]).addTo(map).bindPopup("Lokasi Anda");

            // Ambil alamat otomatis
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${userLat}&lon=${userLng}`)
                .then(res => res.json())
                .then(geoData => {
                    const address = geoData.display_name || 'Lokasi tidak diketahui';
                    document.getElementById('userAddress').value = address;
                })
                .catch(() => {
                    document.getElementById('userAddress').value = 'Gagal mendeteksi alamat';
                });

            fetch(`https://router.project-osrm.org/route/v1/driving/${tokoLng},${tokoLat};${userLng},${userLat}?overview=full&geometries=geojson`)
                .then(res => res.json())
                .then(data => {
                    if (data.routes && data.routes.length > 0) {
                        const route = data.routes[0];
                        const distance = route.distance / 1000;
                        const ongkir = Math.ceil(distance) * 5000;

                        document.getElementById('distance').value = distance.toFixed(2);
                        document.getElementById('shippingCost').value = formatRupiah(ongkir);

                        L.geoJSON(route.geometry, {
                            style: { color: 'blue', weight: 4 }
                        }).addTo(map);

                        map.fitBounds([
                            [tokoLat, tokoLng],
                            [userLat, userLng]
                        ]);

                        updateCheckoutTotal(ongkir);
                    } else {
                        document.getElementById('distance').value = 'Tidak ditemukan';
                        document.getElementById('shippingCost').value = formatRupiah(0);
                        updateCheckoutTotal(0);
                    }
                })
                .catch(() => {
                    document.getElementById('distance').value = 'Gagal menghitung';
                    document.getElementById('shippingCost').value = formatRupiah(0);
                    updateCheckoutTotal(0);
                });
        }, function (err) {
            alert("Gagal mendeteksi lokasi: " + err.message);
            document.getElementById('distance').value = 'Tidak terdeteksi';
            document.getElementById('shippingCost').value = formatRupiah(0);
            updateCheckoutTotal(0);
        });
    } else {
        alert("Geolocation tidak didukung oleh browser kamu.");
        document.getElementById('distance').value = 'Tidak didukung';
        document.getElementById('shippingCost').value = formatRupiah(0);
        updateCheckoutTotal(0);
    }
}

document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    fetch('/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ email, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            loginModal.hide();
            alert("Login berhasil!");
            window.location.reload();
        } else {
            alert(data.message || 'Email atau password salah.');
        }
    })
    .catch(() => alert('Terjadi kesalahan saat mengirim login.'));
});
