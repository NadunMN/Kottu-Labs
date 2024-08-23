document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.carousel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    let currentIndex = 0;
    const totalCards = document.querySelectorAll('.card').length;
    const maxVisibleCards = 4;

    nextBtn.addEventListener('click', () => {
        if (currentIndex < totalCards - maxVisibleCards) {
            currentIndex++;
            updateCarousel();
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    function updateCarousel() {
        const cardWidth = document.querySelector('.card').offsetWidth + 20; // 20 for margin
        const newTransformValue = -(currentIndex * cardWidth);
        carousel.style.transform = `translateX(${newTransformValue}px)`;
    }
});
