// second.js

document.addEventListener('DOMContentLoaded', function () {
    const ratingInitial    = document.querySelector('.rating-initial');
    const ratingDetails    = document.querySelector('.rating-details');
    const ratingButtons    = document.querySelectorAll('.emoji-btn');
    const recentEmojiDisplay = document.getElementById('recentEmoji');
    const detailTitle      = document.getElementById('detailTitle');
    const submitFeedbackButton = document.getElementById('submitFeedback');
    const closeRatingButton    = document.getElementById('closeRating');
    const feedbackTextarea     = document.getElementById('feedbackText');
    const thankYouModal     = new bootstrap.Modal(document.getElementById('thankYouModal'));
    const closePopupButton  = document.querySelector('#thankYouModal .btn-secondary');

    ratingButtons.forEach(button => {
        button.addEventListener('click', function () {
            const rating = this.getAttribute('data-rating');
            const emoji  = this.textContent;

            recentEmojiDisplay.textContent = emoji;

            switch (rating) {
                case 'bad':
                    detailTitle.textContent = 'Ada yang kurang memuaskan? Beritahu kami:';
                    break;
                case 'decent':
                    detailTitle.textContent = 'Terima kasih! Ada masukan lebih lanjut?';
                    break;
                case 'love-it':
                    detailTitle.textContent = 'Senang mendengarnya! Ada hal spesifik yang Anda sukai?';
                    break;
                default:
                    detailTitle.textContent = 'Bagikan Lebih Detail';
            }

            ratingInitial.classList.add('d-none');
            ratingDetails.classList.remove('d-none');
            setTimeout(() => ratingDetails.classList.add('show'), 10);
        });
    });

    submitFeedbackButton.addEventListener('click', function () {
        const feedback    = feedbackTextarea.value;
        const recentEmoji = recentEmojiDisplay.textContent;
        // TODO: Kirim rating & feedback ke server via fetch/AJAX

        thankYouModal.show();
    });

    closeRatingButton.addEventListener('click', function () {
        ratingDetails.classList.remove('show');
        setTimeout(() => {
            ratingInitial.classList.remove('d-none');
            ratingDetails.classList.add('d-none');
            recentEmojiDisplay.textContent = '';
            feedbackTextarea.value         = '';
            detailTitle.textContent        = 'Bagikan Lebih Detail';
        }, 300);
    });

    closePopupButton.addEventListener('click', function () {
        thankYouModal.hide();
        // Kembalikan ke tampilan awal
        ratingDetails.classList.remove('show');
        setTimeout(() => {
            ratingInitial.classList.remove('d-none');
            ratingDetails.classList.add('d-none');
            recentEmojiDisplay.textContent = '';
            feedbackTextarea.value         = '';
            detailTitle.textContent        = 'Bagikan Lebih Detail';
        }, 300);
    });
});



// ======= bagian “See More” untuk produk tambahan =======
document.addEventListener("DOMContentLoaded", function () {
    const btnSeeMore    = document.querySelector(".btn-see-more");
    const extraProducts = document.querySelectorAll(".extra-product");

    // Jika tombol atau produk tambahan tidak ada, hentikan di sini
    if (!btnSeeMore || extraProducts.length === 0) return;

    btnSeeMore.addEventListener("click", function () {
        extraProducts.forEach(product => {
            product.classList.remove("d-none");
        });
        // Sembunyikan tombol setelah menampilkan semua
        btnSeeMore.style.display = "none";
    });
});
