document.querySelectorAll('.submenu-toggle').forEach(function(toggle) {
    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        // Only toggle submenu items within the same <ul>
        var submenuItems = this.parentElement.querySelectorAll('.submenu-item');
        submenuItems.forEach(function(item) {
            item.style.display = item.style.display === 'block' ? 'none' : 'block';
        });
    });
});