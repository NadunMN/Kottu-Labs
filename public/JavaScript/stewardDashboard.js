document.addEventListener('DOMContentLoaded', () => {

    const sidebarOptions = document.querySelectorAll(".sidebar ul li");
  
    const defaultOption = document.getElementById("viewOrderStatus");
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
    iframe.src = '/profile/view-order-status';
  
    
    const iframeSources = {
      viewOrderStatus: '/profile/view-order-status',
      customerArrivals: '/profile/customer-arrivals',
      customerPayments: '/profile/customer-payments'
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
  