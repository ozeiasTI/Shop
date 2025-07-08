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

<div class="modalPerfil">
    <div class="modalconteudo">
        <div class="foto">
            <img src="/Shop/img/user.png" style="width: 100%;" alt="Foto de perfil">
        </div>
        <div class="dados">
            <form action="" method="post">
                <div class="blocoform">
                    <label>Nome</label>
                    <input type="text" name="nome" value="<?php echo $_SESSION['login']['nome']; ?>" required>
                </div>
                <div class="blocoform">
                    <label>CPF</label>
                    <input type="text" name="cpf" value="<?php echo $_SESSION['login']['cpf']; ?>" required>
                </div>
                <div class="blocoform">
                    <label>Email</label>
                    <input type="text" name="email" value="<?php echo $_SESSION['login']['email']; ?>" required>
                </div>
                <div class="blocoform">
                    <label>Função</label>
                    <select name="funcao">
                        <option value="Administrador" <?php echo ($_SESSION['login']['funcao'] === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                        <option value="Gerente" <?php echo ($_SESSION['login']['funcao'] === 'Gerente') ? 'selected' : ''; ?>>Gerente</option>
                        <option value="Vendedor" <?php echo ($_SESSION['login']['funcao'] === 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                        <option value="Estoquista" <?php echo ($_SESSION['login']['funcao'] === 'Estoquista') ? 'selected' : ''; ?>>Estoquista</option>
                    </select>
                </div>
                <div class="blocoform">
                    <label>Senha</label>
                    <input type="text" name="senha" value="<?php echo $_SESSION['login']['senha']; ?>" required>
                </div>
                <div class="blocoform">
                    <label>Telefone</label>
                    <input type="text" name="telefone" value="<?php echo $_SESSION['login']['telefone']; ?>" required>
                </div>
                
            </form>
        </div>
    </div>
</div>

<script src="/Shop/js/header.js"></script>