document.addEventListener('DOMContentLoaded', function() {
    // Load Sidebar
    fetch('/Attendify-Management/app/views/templates/sidebar.php')  // Gunakan path absolut relatif terhadap root web
        .then(response => response.text())
        .then(data => {
            document.getElementById('sidebar-placeholder').innerHTML = data;
        })
        .catch(error => console.error('Error loading sidebar:', error));
});
