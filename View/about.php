<?php

// Verificar se uma sessão já está ativa
if (session_status() == PHP_SESSION_NONE) {
    // Se não estiver ativa, iniciar a sessão
    session_start();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Sobre o IFAcad</title>
        <link href="css/styles.css" rel="stylesheet">       
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">          
        <link rel="shortcut icon" href="img/icone.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/d553081878.js" crossorigin="anonymous"></script>
        
    </head> 

    <body> 
        <header>
        <nav class="sb-topnav navbar navbar-expand if-div-menu">
        <div class="d-flex align-items-center if-div-menu">
            <a class="mr-3 if-a-logo"><img src="img/icone.png" alt="Logo"></a>
            <a class="mr-3 if-a-menu" href="../index.php">Início</a>
            <a class="mr-3 if-a-menu" href="about.php">Sobre</a>        
        </div>
        <div class="text-center flex-grow-1 if-div-menu">IFAcad</div>
        <div class="d-flex align-items-center ml-auto if-div-menu">
    <?php
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'professor') {
            echo '<a class="ml-3 if-a-enter" href="teacher-home.php">Área do Professor <a href="Controller/logout.php" class="ml-2"><i class="fas fa-sign-out-alt"></i></a></a>';
        } elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'administrador') {
            echo '<a class="ml-3 if-a-enter" href="administrator-home.php">Área do Administrador <a href="Controller/logout.php" class="ml-2"><i class="fas fa-sign-out-alt"></i></a></a>';
        } else {
            echo '<a class="ml-3 if-a-enter" href="login.php">Entrar</a>';
        }
        ?>
        </header>
            <main>
                <div class="if-align">
                    <p class="if-text">Sobre o IFPR</p>                    
                </div>
                <div class="if-align" style="text-align: justify;">
                    <p>O Instituto Federal do Paraná (IFPR) é uma instituição pública federal de ensino vinculada ao Ministério da Educação (MEC) por meio da Secretaria de Educação Profissional e Tecnológica (Setec). É voltada a educação superior, básica e profissional, especializada na oferta gratuita de educação profissional e tecnológica nas diferentes modalidades e níveis de ensino.</p>
                    <p>A instituição foi criada em dezembro de 2008 através da Lei 11.892, que instituiu a Rede Federal de Educação Profissional e Tecnológica e os 38 institutos federais hoje existentes no país. Com a Lei em vigor, a Escola Técnica da Universidade Federal do Paraná (ET-UFPR) foi transformada no IFPR, que hoje possui autonomia administrativa e pedagógica.</p>
                </div>
                <div class="if-align-about">
                    <p class="if-text">Sobre o IFAcad</p>                    
                </div>
                <div class="if-align" style="margin-bottom: 7%; text-align: justify;">
                    <p>O IFAcad é um projeto  de desenvolvimento de um repositório para armazenar em formato digital trabalhos de conclusão de cursos e relatórios de estágios realizados no Instituto Federal do Paraná (IFPR) - Campus Palmas, como forma de facilitar o acesso a informação para a comunidade em geral.</p>  
                    
                    <p>
                    Espera-se que seja possível aumentar a visibilidade e o reconhecimento da produção científica da instituição, o que, consequentemente, contribuirá para a disseminação do conhecimento gerado internamente. Simultaneamente, a criação deste repositório visa a estimular potenciais pesquisadores que possam surgir futuramente.

                    </p>
                </div>
            </main>
            
            </div>
        </div>
        <?php include_once("baseboard.php");?>
        
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>      
    </body>
</html>