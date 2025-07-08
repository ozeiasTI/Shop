// funcoes.js
document.querySelectorAll('.submenu-toggle').forEach(toggle => {
    toggle.addEventListener('click', function () {
        this.classList.toggle('ativo');
        let submenu = this.nextElementSibling;

        while (submenu && submenu.classList.contains('submenu-item')) {
            submenu.classList.toggle('ativo');
            submenu = submenu.nextElementSibling;
        }
    });
});

document.getElementById('dark-toggle').addEventListener('change', function () {
    document.body.classList.toggle('dark-mode');
});
