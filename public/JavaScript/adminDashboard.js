document.addEventListener('DOMContentLoaded', () => {

  const sidebarOptions = document.querySelectorAll(".sidebar ul li");

  const defaultOption = document.getElementById("dashboard");
  defaultOption.classList.add("selected");

 
  sidebarOptions.forEach((option) => {
    option.addEventListener("click", () => {
      
      sidebarOptions.forEach((opt) => opt.classList.remove("selected"));
      
      option.classList.add("selected");
    });
  });

  const menuItems = document.querySelectorAll('.menu-item');
  const iframe = document.getElementById('dynamicIframe');
  // Set default iframe source to dashboard
  iframe.src = '/profile/dashboard';

  
  const iframeSources = {
    dashboard: '/profile/dashboard',
    staff: '/profile/staff',
    updatemenu: '/profile/update-menu',
    viewreservations: '/profile/view-reservations',
    updateoffers: '/profile/update-offers',
    feedbacks: '/profile/feedbacks',
    orderhistory: '/profile/order-history'
  };

  menuItems.forEach(item => {
    item.addEventListener('click', () => {
      const itemId = item.id; 
      if (iframeSources[itemId]) {
        iframe.src = iframeSources[itemId]; 
      } else {
        iframe.src = '';
      }
    });
  });
});
