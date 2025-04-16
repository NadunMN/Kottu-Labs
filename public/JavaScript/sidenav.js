 // JavaScript for additional functionality if needed
 document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        // You can add functionality here when icons are clicked
        console.log(this.querySelector('.nav-text').textContent + ' clicked');
    });
});