document.addEventListener("DOMContentLoaded", function () {
    const carousels = document.querySelectorAll('.carousel-container');

    carousels.forEach(carousel => {
        const prevBtn = carousel.querySelector('.prev-btn');
        const nextBtn = carousel.querySelector('.next-btn');
        const carouselInner = carousel.querySelector('.carousel');

        let currentIndex = 0;
        let maxVisibleCards = getVisibleCardsCount();
        let cards = []; // Will be populated after fetch

        // Function to calculate how many cards should be visible based on screen width
        function getVisibleCardsCount() {
            const screenWidth = window.innerWidth;
            if (screenWidth <= 620) return 2;
            if (screenWidth <= 940) return 2;
            if (screenWidth <= 1260) return 3;
            return 4;
        }

        // Update the carousel when the current index changes
        function updateCarousel() {
            if (cards.length === 0) return; // No cards yet
            const cardWidth = cards[0].offsetWidth + 20; // Assuming margin/gap
            const newTransformValue = -(currentIndex * cardWidth);
            carouselInner.style.transform = `translateX(${newTransformValue}px)`;
        }

        // Handle next button click
        function handleNext() {
            if (currentIndex < cards.length - maxVisibleCards) {
                currentIndex++;
                updateCarousel();
            }
        }

        // Handle previous button click
        function handlePrev() {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        }

        // Attach event listeners to buttons
        prevBtn.addEventListener('click', handlePrev);
        nextBtn.addEventListener('click', handleNext);

        // Handle screen resize
        window.addEventListener('resize', () => {
            maxVisibleCards = getVisibleCardsCount(); // Recalculate based on new window size
            currentIndex = Math.min(currentIndex, cards.length - maxVisibleCards); // Ensure index is within bounds
            updateCarousel(); // Update the view
        });

        // Show loading state
        carouselInner.innerHTML = "<p class='width-window'>Loading...</p>";

        // Fetch data and update carousel
        fetch('/offer/getpublished')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error fetching offers:', data.error);
                    carouselInner.innerHTML = "<p>Failed to load offers. Please try again later.</p>";
                    return;
                }

                if (data.length === 0) {
                    carouselInner.innerHTML = `
                    <div class="no-offers-container" 
     style="text-align: center; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            padding: 2rem; 
            
            border-radius: 10px; 
             
            margin: 20px; 
            ">

    <i class="fas fa-box-open" 
       style="font-size: 3rem; 
              color: #6c757d; 
              margin-bottom: 1rem;"></i>

    <h3 style="font-size: 1.5rem; 
               color: #343a40; 
               margin-bottom: 0.5rem; 
               font-weight: 600;">
        No Offers published yet!
    </h3>

    <p style="color: #6c757d; 
             font-size: 1rem; 
             max-width: 400px; 
             line-height: 1.5;">
        We'll notify you when new offers arrive!
    </p>
</div>
                `;                    
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                    return;
                }

                // Generate cards HTML
                const offerCards = data.map(offer => `
                    <div class="card">
                        <div class="card-wapper">
                            <img src="${offer.offer_photo}" alt="Card image" class="card-img">
                            <div class="card-content">
                                <h3 class="card-title">${offer.offer_name || 'Card Title'}</h3>
                                <p class="card-text">${offer.offer_description || 'This is a brief description of the card content.'}</p>
                            <button class="view-button card-btn" offer-id="${offer.offer_id}">VIEW DETAILS</button>
                            </div>
                        </div>
                    </div>
                `).join('');
                
                // Update carousel content
                carouselInner.innerHTML = offerCards;
                carouselInner.addEventListener('click', function(e) {
                    const button = e.target.closest('.view-button');
                    if (button) {
                        const offerId = button.getAttribute('offer-id');
                        if (offerId) {
                            window.location.href = `/offer/offerview?id=${encodeURIComponent(offerId)}`;
                        }
                    }
                });

                // Reinitialize cards and update carousel
                cards = carouselInner.querySelectorAll('.card');
                maxVisibleCards = getVisibleCardsCount();
                currentIndex = 0; // Reset index
                updateCarousel(); // Initialize the carousel view
            })
            .catch(error => {
                console.error('Error fetching offers:', error);
                carouselInner.innerHTML = "<p>Failed to load offers. Please try again later.</p>";
            });
    });
});