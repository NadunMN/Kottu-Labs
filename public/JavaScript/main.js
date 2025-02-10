let topDiv = document.getElementById('home-top-main');

window.addEventListener('scroll', () => {
  if (window.scrollY > 100) {
    topDiv.classList.add('hidden');
  } else {
    topDiv.classList.remove('hidden');
  }
});
