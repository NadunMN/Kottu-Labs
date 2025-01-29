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

  // Dynamically adjust iframe height
  const adjustIframeHeight = () => {
    try {
      const iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
      iframe.style.minHeight = '100vh'; // Reset height to auto
      iframe.style.height = 'auto'; // Reset height to auto
      iframe.style.height = `${iframeDocument.documentElement.scrollHeight}px`;
    } catch (error) {
      console.error("Could not adjust iframe height:", error);
    }
  };

  iframe.addEventListener('load', () => {
    adjustIframeHeight();
    observeIframeContent();
  });

  // Observe iframe's content for changes
  const observeIframeContent = () => {
    try {
      const iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

      const observer = new MutationObserver(() => {
        adjustIframeHeight();
      });

      observer.observe(iframeDocument.body, {
        childList: true, // Observe addition/removal of nodes
        subtree: true,   // Observe all child nodes
        attributes: true // Observe attribute changes
      });
    } catch (error) {
      console.error("Could not observe iframe content:", error);
    }
  };
});
