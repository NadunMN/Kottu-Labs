  // Quantity Selector
  document.querySelectorAll('.quantity-btn').forEach(button => {
    button.addEventListener('click', () => {
        const input = document.querySelector('.quantity-number');
        let value = parseInt(input.value);
        
        if (button.classList.contains('plus')) {
            value++;
        } else {
            value = value > 1 ? value - 1 : 1;
        }
        input.value = value;
    });
});

// Color Selection
document.querySelectorAll('.color-circle').forEach(color => {
    color.addEventListener('click', () => {
        document.querySelectorAll('.color-circle').forEach(c => c.classList.remove('active'));
        color.classList.add('active');
    });
});

// Tab Switching
document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
        const tabId = tab.dataset.tab;
        
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        
        tab.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    });
});

// Image Gallery
document.querySelectorAll('.thumbnail').forEach(thumb => {
    thumb.addEventListener('click', () => {
        const mainImage = document.querySelector('.main-image');
        mainImage.src = thumb.src.replace('thumbnail', 'main-image');
    });
});