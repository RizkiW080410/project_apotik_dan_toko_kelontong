let cartCount = 0;
let cartItems = {};

const loginModalElement = document.getElementById('loginModal');
const loginModal = new bootstrap.Modal(loginModalElement);
const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
const cartOffcanvasElement = document.getElementById('cartSidebar');
const cartOffcanvas = new bootstrap.Offcanvas(cartOffcanvasElement);
const checkoutModalElement = document.getElementById('checkoutModal');
const checkoutModal = new bootstrap.Modal(checkoutModalElement);
const orderStatusModalElement = document.getElementById('orderStatusModal');
const orderStatusModal = new bootstrap.Modal(orderStatusModalElement);
const orderIcon = document.getElementById('orderIcon');
const successModalElement = document.getElementById('successModal');
const successModal = new bootstrap.Modal(successModalElement);

document.addEventListener('DOMContentLoaded', function () {
    const addButtons = document.querySelectorAll('.btn-add-to-cart');

    addButtons.forEach((btn) => {
        btn.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = this.getAttribute('data-price');
            const imgSrc = this.getAttribute('data-image');
            const img = this.closest('.product').querySelector('.product-img');

            animateToCart(img);
            cartCount++;
            const badge = document.getElementById('cartBadge');
            badge.classList.remove('d-none');
            badge.innerText = cartCount;
            badge.classList.add('bounce-badge');
            setTimeout(() => badge.classList.remove('bounce-badge'), 600);

            updateCartSidebar(productId, name, price, imgSrc);
        });
    });

    document.querySelectorAll('.open-cart').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            cartOffcanvas.show();
        });
    });

    orderIcon.addEventListener('click', function (e) {
        e.preventDefault();
        orderStatusModal.show();
    });

    document.getElementById('orderForm').addEventListener('submit', function (e) {
        e.preventDefault();
        buatPesanan();
    });

    checkoutModalElement.addEventListener('show.bs.modal', function () {
        const orderDetails = document.getElementById('orderDetails');
        orderDetails.innerHTML = '';

        let totalProduk = 0;

        for (let id in cartItems) {
            const item = cartItems[id];
            const itemElement = document.createElement('div');
            itemElement.className = 'd-flex justify-content-between mb-2';
            itemElement.innerHTML = `
                <div><strong>${item.name}</strong> x ${item.qty}</div>
                <div>${formatRupiah(item.price * item.qty)}</div>
            `;
            orderDetails.appendChild(itemElement);
            totalProduk += item.price * item.qty;
        }

        document.getElementById('totalProdukCheckout').innerText = formatRupiah(totalProduk);
        document.getElementById('totalOngkirCheckout').innerText = formatRupiah(0);
        document.getElementById('totalWithShipping').innerText = formatRupiah(totalProduk);
        document.getElementById('checkoutTotal').innerText = formatRupiah(totalProduk);

        setTimeout(() => {
            initMapAndRoute();
        }, 500);
    });
});

function animateToCart(imgElement) {
    const cartIcon = document.querySelector('.open-cart i');
    const imgClone = imgElement.cloneNode(true);
    const imgRect = imgElement.getBoundingClientRect();
    const cartRect = cartIcon.getBoundingClientRect();

    imgClone.style.position = 'fixed';
    imgClone.style.left = imgRect.left + 'px';
    imgClone.style.top = imgRect.top + 'px';
    imgClone.style.width = imgRect.width + 'px';
    imgClone.style.height = imgRect.height + 'px';
    imgClone.style.zIndex = 9999;
    imgClone.style.transition = 'all 0.8s ease-in-out';

    document.body.appendChild(imgClone);

    setTimeout(() => {
        imgClone.style.left = cartRect.left + 'px';
        imgClone.style.top = cartRect.top + 'px';
        imgClone.style.opacity = '0';
        imgClone.style.transform = 'scale(0.1)';
    }, 10);

    setTimeout(() => {
        imgClone.remove();
    }, 900);
}

function updateCartSidebar(productId, name, price, imgSrc) {
    const sidebarBody = document.getElementById('cartSidebarBody');
    let item = document.querySelector(`#sidebar-item-${productId}`);

    if (item) {
        updateQty(productId, 1);
        return;
    }

    item = document.createElement('div');
    item.className = "d-flex justify-content-between align-items-center mb-3";
    item.id = `sidebar-item-${productId}`;
    item.innerHTML = `
        <div class="d-flex align-items-start gap-2">
          <img src="${imgSrc}" alt="${name}" width="50" height="50" style="object-fit:cover; border-radius:8px;">
          <div>
            <strong>${name}</strong><br>
            <small class="text-muted">Rp${parseInt(price).toLocaleString()}</small>
          </div>
        </div>
        <div class="d-flex align-items-center gap-1">
          <button class="btn btn-sm btn-outline-secondary" onclick="updateQty('${productId}', -1)">−</button>
          <span id="qty-${productId}">1</span>
          <button class="btn btn-sm btn-outline-secondary" onclick="updateQty('${productId}', 1)">+</button>
        </div>
    `;
    sidebarBody.appendChild(item);

    cartItems[productId] = {
        name,
        price: parseInt(price),
        qty: 1
    };

    updateTotal();
}

function updateQty(productId, change) {
    const qtyElement = document.getElementById(`qty-${productId}`);
    const currentQty = parseInt(qtyElement.innerText);
    const newQty = currentQty + change;

    if (newQty < 1) {
        const itemElement = document.getElementById(`sidebar-item-${productId}`);
        if (itemElement) itemElement.remove();
        cartCount -= currentQty;
        if (cartCount <= 0) {
            cartCount = 0;
            document.getElementById('cartBadge').classList.add('d-none');
        } else {
            document.getElementById('cartBadge').innerText = cartCount;
        }
        delete cartItems[productId];
    } else {
        qtyElement.innerText = newQty;
        cartItems[productId].qty = newQty;
        cartCount += change;
        document.getElementById('cartBadge').innerText = cartCount;
    }

    updateTotal();
}

function updateTotal() {
    const totalElement = document.getElementById('cartTotal');
    let total = 0;
    for (let id in cartItems) {
        total += cartItems[id].price * cartItems[id].qty;
    }
    totalElement.innerText = "Rp" + total.toLocaleString();
}

function buatPesanan() {
    const items = [];
    for (let id in cartItems) {
        items.push({
            id,
            qty: cartItems[id].qty,
            price: cartItems[id].price
        });
    }

    const alamat = document.getElementById('userAddress').value.trim();
    const jarak = parseFloat(document.getElementById('distance').value || 0);
    const ongkir = parseInt(document.getElementById('shippingCost').value.replace(/\D/g, '')) || 0;
    const total = Object.values(cartItems).reduce((sum, item) => sum + item.qty * item.price, 0) + ongkir;

    fetch('/checkout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            items, alamat, jarak, ongkir, total
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.snap_token) {
            // Panggil Midtrans Snap
            window.snap.pay(data.snap_token, {
                onSuccess: function (result) {
                    // Berhasil bayar
                    cartItems = {};
                    cartCount = 0;
                    document.getElementById('cartBadge').classList.add('d-none');
                    cartOffcanvas.hide();
                    checkoutModal.hide();
                    successModal.show();
                },
                onPending: function (result) {
                    alert("Pembayaran sedang diproses...");
                },
                onError: function (result) {
                    alert("Pembayaran gagal. Silakan coba lagi.");
                },
                onClose: function () {
                    alert("Anda belum menyelesaikan pembayaran.");
                }
            });
        } else {
            alert('Gagal membuat pesanan.');
        }
    })
    .catch(() => alert('Terjadi kesalahan saat membuat pesanan.'));
}

function formatRupiah(angka) {
    return 'Rp' + angka.toLocaleString('id-ID');
}

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
