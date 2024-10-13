document.addEventListener("DOMContentLoaded", function() {
    const carousels = document.querySelectorAll('.carousel-container');

    carousels.forEach(carousel => {
        const prevBtn = carousel.querySelector('.prev-btn');
        const nextBtn = carousel.querySelector('.next-btn');
        const carouselInner = carousel.querySelector('.carousel');
        const cards = carouselInner.querySelectorAll('.card');

        let currentIndex = 0;
        let maxVisibleCards = getVisibleCardsCount();

        // Function to calculate how many cards should be visible based on screen width
        function getVisibleCardsCount() {
            const screenWidth = window.innerWidth;
            if (screenWidth <= 620) {
                return 1; // For mobile
            } else if (screenWidth <= 940) {
                return 2; // For tablets
            } else if (screenWidth <= 1260) {
                return 3; // For desktops
            } else {
                return 4; // For large desktops
            }
        }

        // Update the carousel when the current index changes
        function updateCarousel() {
            const cardWidth = cards[0].offsetWidth + 20; // Assuming margin/gap
            const newTransformValue = -(currentIndex * cardWidth);
            carouselInner.style.transform = `translateX(${newTransformValue}px)`;
        }

        // Handle next button click
        nextBtn.addEventListener('click', () => {
            if (currentIndex < cards.length - maxVisibleCards) {
                currentIndex++;
                updateCarousel();
            }
        });

        // Handle previous button click
        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });

        // Handle screen resize
        window.addEventListener('resize', () => {
            maxVisibleCards = getVisibleCardsCount(); // Recalculate based on new window size
            currentIndex = 0; // Reset index to avoid out-of-bound errors
            updateCarousel(); // Update the view
        });

        updateCarousel(); // Initialize the carousel view
    });
});
