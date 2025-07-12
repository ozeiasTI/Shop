<?php

if (isset($_POST['btnSalvar'])) {

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $ativo = $_POST['ativo'];
    $data_nascimento = $_POST['data_nascimento'];
    $endereco = $_POST['endereco'];
    $id_usuario = $_SESSION['login']['id'];

    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];

        $diretorio = $_SERVER['DOCUMENT_ROOT'] .'/Shop/pages/usuarios/imagens/';
        $caminhoCompleto = $diretorio . $foto;

        move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoCompleto);

        if(isset($_SESSION['login']['foto']) && $_SESSION['login']['foto'] != 'user.png') {
            $fotoAntiga = $_SERVER['DOCUMENT_ROOT'] . '/Shop/pages/usuarios/imagens/' . $_SESSION['login']['foto'];
            if (is_file($fotoAntiga) && file_exists($fotoAntiga)) {
                unlink($fotoAntiga);
            }
        }

        $sql = "UPDATE usuarios SET 
            nome = '$nome', 
            cpf = '$cpf', 
            email = '$email', 
            senha = '$senha', 
            telefone = '$telefone', 
            ativo = '$ativo', 
            data_nascimento = '$data_nascimento', 
            endereco = '$endereco',
            foto = '$foto'
            WHERE id = $id_usuario";
    } else {
        $sql = "UPDATE usuarios SET 
            nome = '$nome', 
            cpf = '$cpf', 
            email = '$email', 
            senha = '$senha', 
            telefone = '$telefone', 
            ativo = '$ativo', 
            data_nascimento = '$data_nascimento', 
            endereco = '$endereco'
            WHERE id = $id_usuario";
    }

    if ($conexao->query($sql) === TRUE) {
        $_SESSION['login']['nome'] = $nome;
        $_SESSION['login']['cpf'] = $cpf;
        $_SESSION['login']['email'] = $email;
        $_SESSION['login']['senha'] = $senha;
        $_SESSION['login']['telefone'] = $telefone;
        $_SESSION['login']['ativo'] = $ativo;
        $_SESSION['login']['data_nascimento'] = date('d/m/Y', strtotime($data_nascimento));
        $_SESSION['login']['endereco'] = $endereco;
        if (!empty($_FILES['foto']['name'])) {
            $_SESSION['login']['foto'] = $foto;
        }
        $_SESSION['mensagem'] = "Perfil Editado com sucesso!";
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
        
    }
}

?>

<link rel="stylesheet" href="/Shop/css/header.css">
<script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>

<div class="header">
    <div class="esquerda">
        <i class="fa-solid fa-bars" id="btnMenuToggle"></i>
        <h1><a href="/Shop/pages/inicio.php"><?php echo $_SESSION['empresa']['nome']; ?></a></h1>
    </div>

    <div class="direita">
        <div class="notificacao" onclick="abrirNotificacoes()">
            <i class="fa-solid fa-bell"></i>
            <?php 
                $meuid = $_SESSION['login']['id'];
                $consultaNotificacao = mysqli_query($conexao,"SELECT * FROM notificacoes WHERE usuario_id = $meuid ");
                $contador = mysqli_num_rows($consultaNotificacao);
            ?>
            <p><?php if($contador > 0) {echo $contador;} ?></p>
        </div>
        <div class="user-info" onclick="modalPerfil()">
            <span><?php echo $_SESSION['login']['nome']; ?></span>
            <?php
            if (!empty($_SESSION['login']['foto'])) {
                echo "<img src='/Shop/pages/usuarios/imagens/" . $_SESSION['login']['foto'] . "' alt='Foto de perfil' style='width: 50px; height: 50px; border-radius: 50%;'>";
            } else {
                echo '<img src="/Shop/img/user.png" alt="Foto de perfil" style="width: 50px; height: 50px; border-radius: 50%;">';
            }
            ?>
        </div>
        <a href="/Shop/logout.php" class="logout" title="Sair">
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </div>
</div>

<div class="modalPerfil">
    <div class="modalconteudo">
        <div class="foto">
            <?php
            if (!empty($_SESSION['login']['foto'])) {
                echo "<img src='/Shop/pages/usuarios/imagens/" . $_SESSION['login']['foto'] . "' style='width: 100%;'>";
            } else {
                echo '<img src="/Shop/img/user.png" style="width: 100%;" alt="Foto de perfil">';
            }
            ?>
        </div>
        <div class="dados">
            <form action="" method="post" enctype="multipart/form-data">
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
                    <div class="blocoform">
                        <label>Foto</label>
                        <input type="file" name="foto" accept="image/*" style="padding: 7px;">
                    </div>
                </div>
                <div class="botoes">
                    <button type="submit" name="btnSalvar" class="btnSalvar"><i class="fas fa-save"></i> Salvar</button>
                    <button type="button" class="btnCancelar" onclick="modalPerfil()"><i class="fas fa-times"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modalNotificacao">
    <div class="conteudoNotificacao">
        <div class="cabecalho">
            <h4>Notificações</h4>
            <i onclick="abrirNotificacoes()">X</i>
        </div>
        <hr>
        <?php
            while($notificacoesusuarios = mysqli_fetch_assoc($consultaNotificacao)){

                echo "<div class='notificacao_sino'>";
                echo "<img src='/Shop/img/notificacao.png' style='width: 50px;margin-top:10px;'>";
                echo "</div>";

                echo "<div class='notificacao_corpo'>";
                echo "<span style='color:black;font-weight:bold;'>".$notificacoesusuarios['titulo']."</span><br>";
                echo "<span style='color:gray;font-weight:bold;'>".$notificacoesusuarios['mensagem']."</span><br>";
                echo "<span style='color:red;font-weight:bold;'>". date('d/m/Y', strtotime($notificacoesusuarios['data_conclusao'])) ."</span><br>";
                echo "<span style='color:gray;font-weight:bold;'>"."setor"."</span><br>";
                echo "</div>";
                
            }
        ?>
    </div>
</div>

<script src="/Shop/js/header.js"></script>