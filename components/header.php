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
                <div class="blocos-container">
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
                    <div class="blocoform">
                        <label>Ativo</label>
                        <select name="ativo">
                            <option value="SIM" <?php echo ($_SESSION['login']['ativo'] == 'SIM') ? 'selected' : ''; ?>>SIM</option>
                            <option value="NÃO" <?php echo ($_SESSION['login']['ativo'] == 'NÃO') ? 'selected' : ''; ?>>NÃO</option>
                        </select>
                    </div>
                    <div class="blocoform">
                        <label>Data de Nascimento</label>
                        <?php
                        $data_original = $_SESSION['login']['data_nascimento'];
                        $data_formatada = date('Y-m-d', strtotime(str_replace('/', '-', $data_original)));
                        ?>
                        <input type="date" name="data_nascimento" value="<?php echo $data_formatada; ?>" required>

                    </div>
                    <div class="blocoform">
                        <label for="">Data de Cadastro</label>
                        <?php
                        $data_cadastro = $_SESSION['login']['data_cadastro'];
                        $data_formatada_cadastro = date('d/m/Y', strtotime(str_replace('-', '/', $data_cadastro)));
                        ?>
                        <input type="text" name="data_cadastro" value="<?php echo $data_formatada_cadastro; ?>" disabled>
                    </div>
                    <div class="blocoform">
                        <label>Endereço</label>
                        <input type="text" name="endereco" value="<?php echo $_SESSION['login']['endereco']; ?>" required>
                    </div>
                </div>
                <div class="botoes">
                    <button type="submit" name="btnSalvar" class="btnSalvar">Salvar</button>
                    <button type="button" class="btnCancelar" onclick="modalPerfil()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/Shop/js/header.js"></script>