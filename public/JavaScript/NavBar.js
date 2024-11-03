function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    const dropdownContent = document.querySelector('.dropdown-content');

    // Hide the dropdown content if it's open
    dropdownContent.classList.remove('show1');

    // Toggle the 'show' class on the nav-links
    navLinks.classList.toggle('show');
}

function toggleMenuprofile() {
    const dropdownContent = document.querySelector('.dropdown-content');
    const navLinks = document.querySelector('.nav-links');

    // Hide the nav-links if it's open
    navLinks.classList.remove('show');

    // Toggle the 'show1' class on the dropdown content
    dropdownContent.classList.toggle('show1');
}
