document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.querySelector('.sidebar');
  const toggleSidebarButton = document.getElementById('toggleSidebar');
  const closeSidebarButton = document.getElementById('closeSidebar');

  toggleSidebarButton.addEventListener('click', function() {
    sidebar.classList.toggle('active');
  });

  closeSidebarButton.addEventListener('click', function() {
    sidebar.classList.remove('active');
  });

  // Hide close button on large screens initially
  if (window.innerWidth > 800) {
    closeSidebarButton.style.display = 'none';
  }

  // Event listener to check window width and toggle close button visibility
  window.addEventListener('resize', function() {
    if (window.innerWidth > 800) {
      closeSidebarButton.style.display = 'none';
    } else {
      closeSidebarButton.style.display = 'block';
    }
  });
});

