<link rel="stylesheet" href="/Shop/css/header.css">

<div class="header">
    <div class="esquerda">
        <?php echo $_SESSION['empresa']['nome']; ?>
        <i class="fa-solid fa-bars" onclick="menu()"></i>
    </div>
    <div class="direita">
        <i class="fa-solid fa-user"></i>
    </div>
</div>

<script src="/Shop/js/funcoes.js"></script>