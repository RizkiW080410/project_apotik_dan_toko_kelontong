document.addEventListener('DOMContentLoaded', () => {
  // ——— Scroll kategori ———
  const scrollContainer = document.getElementById('categoryScroll');
  const scrollAmount    = 150;
  const btnLeft         = document.getElementById('scrollLeft');
  const btnRight        = document.getElementById('scrollRight');

  if (scrollContainer && btnLeft) {
    btnLeft.addEventListener('click', () => {
      scrollContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
  }
  if (scrollContainer && btnRight) {
    btnRight.addEventListener('click', () => {
      scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
  }

  // ——— Hero-card intersection animation ———
  const heroCard = document.querySelector('.hero-card');
  if (heroCard) {
    new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) heroCard.classList.add('show');
      },
      { threshold: 0.3 }
    ).observe(heroCard);
  }

  // ——— Promo-card intersection animations ———
  const promoTargets = [
    ...document.querySelectorAll('.scroll-container > div'),
    document.querySelector('.promo-card.left'),
    document.querySelector('.promo-card.right'),
  ].filter(Boolean);

  const promoObs = new IntersectionObserver(
    entries => {
      entries.forEach(e => {
        if (!e.isIntersecting) return;
        if (e.target.classList.contains('left')) {
          e.target.classList.add('show-left');
        } else if (e.target.classList.contains('right')) {
          e.target.classList.add('show-right');
        } else {
          e.target.classList.add('show');
        }
      });
    },
    { threshold: 0.3 }
  );

  promoTargets.forEach(el => promoObs.observe(el));
});

document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const products   = document.querySelectorAll('.product');

    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        // 1) Toggle styling tombol
        filterBtns.forEach(b => {
          b.classList.remove('active');
          b.classList.add('btn-outline-secondary');
          b.style.backgroundColor = '';
          b.style.color = '';
        });
        btn.classList.add('active');
        btn.classList.remove('btn-outline-secondary');
        btn.style.backgroundColor = '#A34B2B';
        btn.style.color = '#fff';

        // 2) Filter produk
        const selectedId = btn.getAttribute('data-category-id'); // "" = All
        products.forEach(card => {
          const cardCat = card.getAttribute('data-category-id') || '';
          if (!selectedId || cardCat === selectedId) {
            card.style.display = '';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  });