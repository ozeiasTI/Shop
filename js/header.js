function modalPerfil() {
    const modal = document.querySelector('.modalPerfil');
    if (modal.style.display === 'block') {
        modal.style.display = 'none';
        return;
    }
    modal.style.display = 'block';
}

function abrirNotificacoes(){
    const modal = document.querySelector('.modalNotificacao');
    if (modal.style.display === 'block') {
        modal.style.display = 'none';
        return;
    }
    modal.style.display = 'block';
}