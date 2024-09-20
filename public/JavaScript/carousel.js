document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.carousel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentIndex = 0;
    let maxVisibleCards = getVisibleCardsCount();

    function getVisibleCardsCount() {
        const screenWidth = window.innerWidth;
        if (screenWidth <= 620) {
            return 1; // Mobile screens
        } else if (screenWidth <= 940) {
            return 2; // Tablet screens
        } else if (screenWidth <= 1260) {
            return 3; // Desktop screens
        } else {
            return 4; // Large desktop screens
        }
    }

    function updateCarousel() {
        const cardWidth = document.querySelector('.card').offsetWidth + 20; // Adjust based on gap or margin
        const newTransformValue = -(currentIndex * cardWidth);
        carousel.style.transform = `translateX(${newTransformValue}px)`;
    }

    nextBtn.addEventListener('click', () => {
        if (currentIndex < document.querySelectorAll('.card').length - maxVisibleCards) {
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

    // Update card count and size on window resize
    window.addEventListener('resize', () => {
        maxVisibleCards = getVisibleCardsCount();
        currentIndex = 0; // Reset index
        updateCarousel();
    });

    updateCarousel();
});
