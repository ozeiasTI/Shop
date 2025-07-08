<link rel="stylesheet" href="/Shop/css/header.css">
<script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>

<div class="header">
    <div class="esquerda">
        <i class="fa-solid fa-bars" id="btnMenuToggle"></i>
        <h1><?php echo $_SESSION['empresa']['nome']; ?></h1>
    </div>

    <div class="direita">
        <div class="user-info" onclick="modalPerfil()">
            <span><?php echo $_SESSION['login']['nome']; ?></span>
            <i class="fa-solid fa-user-circle"></i>
        </div>
        <a href="/Shop/logout.php" class="logout" title="Sair">
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </div>
</div>
