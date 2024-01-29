
<nav class="sb-topnav navbar navbar-expand if-div-menu">
    <div class="d-flex align-items-center if-div-menu">
        <a class="mr-3 if-a-logo"><img src="img/icone.png" alt="Logo IFAcad"></a>
        <a class="mr-3 if-a-menu" href="../index.php">Início</a>
        <a class="mr-3 if-a-menu" href="about.php">Sobre</a>        
    </div>
    <div class="text-center flex-grow-1 if-div-menu">IFAcad</div>
    <div class="d-flex align-items-center ml-auto if-div-menu">
    
    <?php
    //Verificações para saber se o perfil logado é um administrador ou um professor, para exibir o bloco de código correspondente
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'professor') {
            echo '<span class="if-a-enter">Bem-vindo, Professor <a href="../Controller/logout.php" class="ml-2"><i class="fas fa-sign-out-alt"></i></a></span>';
            
        } elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'administrador') {
            echo '<span class="if-a-enter">Bem-vindo, Administrador <a href="../Controller/logout.php" class="ml-2"><i class="fas fa-sign-out-alt"></i></a></span>';
        } else {
            echo '<a class="ml-3 if-a-enter" href="login.php">Entrar</a>';
        }
        ?>
    </div>
</nav>