<link rel="stylesheet" href="/Shop/css/menu.css">
<script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>

<nav class="menu" id="menu">
        <?php
            if (!empty($_SESSION['empresa']['logo'])) {
                echo "<img style='height:100px;border-radius:50%;' src='/Shop/admin/empresa/imagens/" . $_SESSION['empresa']['logo'] . "' alt='Foto de perfil'>";
            } else {
                echo "<img style='height:100px;border-radius:50%;' src='/Shop/img/login.svg' alt='Foto de perfil'>";
            }
            ?>
    
    <div class="menu-bloco">
        <ul>
            <li>
                <a href="/Shop/pages/inicio.php">
                    <i class="fa-solid fa-signal"></i>
                    Dashboard
                </a>
            </li>
        </ul>
        <?php
            if($_SESSION['login']['funcao'] === 'Administrador'){
                echo "<ul>
                        <li>
                            <a href='/Shop/admin/index.php'>
                                <i class='fas fa-user-shield'></i>
                                Administrador
                            </a>
                        </li>
                    </ul>";
            }
        ?>
        <ul>
            <li>
                <a href="/Shop/pages/usuarios/usuarios.php">
                    <i class="fa-solid fa-users"></i>
                    Usuários
                </a>
            </li>
        </ul>

        <ul>
            <li class="submenu-toggle">
                <a href="#">
                    <i class="fa-solid fa-dolly"></i>
                     Produtos
                    <i class="fa-solid fa-angle-down seta"></i>
                </a>
            </li>
            <li class="submenu-item"><a href="/Shop/pages/fornecedor/index.php"><i class="fa-solid fa-truck-moving"></i>Fornecedor</a></li>
            <li class="submenu-item"><a href="/Shop/pages/categoria/index.php"><i class="fa-solid fa-table-list"></i>Categoria</a></li>
            <li class="submenu-item"><a href="/Shop/pages/produtos/index.php"><i class="fa-solid fa-cart-plus"></i>Produtos</a></li>
        </ul>

        <ul>
            <li>
                <a href="/Shop/pages/clientes/index.php">
                    <i class="fa-solid fa-people-group"></i>
                    Clientes
                </a>
            </li>
        </ul>

        <ul>
            <li>
                <a href="/Shop/pages/caixa/index.php">
                    <i class="fa-solid fa-cash-register"></i>
                    Caixa
                </a>
            </li>
        </ul>

        <ul>
            <li>
                <a href="/Shop/pages/contas/index.php">
                    <i class="fa-solid fa-sack-dollar"></i>
                    Contas
                </a>
            </li>
        </ul>

        <ul>
            <li>
                <a href="/Shop/pages/anotacoes/index.php">
                    <i class="fa-solid fa-clipboard"></i>
                    Anotações
                </a>
            </li>
        </ul>
    </div>

    <div class="menu-footer">
    <p style="color: white;">© Todos os Direitos Reservados</p>
</div>


</nav>


<script src="/Shop/js/menu.js"></script>