
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Menu Principal</div>
                               
                
                <?php
                            if ($_SESSION['user_type'] === 'professor') {
                                echo '<a class="nav-link" href="teacher-home.php"><div class="sb-nav-link-icon"><i class="fa fa-bars"></i></div>Home</a>';
                            } elseif ($_SESSION['user_type'] === 'administrador') {
                                echo '<a class="nav-link" href="administrator-home.php"><div class="sb-nav-link-icon"><i class="fa fa-bars"></i></div>Home</a>';
                            } else {
                                echo '<a href="../index.php"><div class="sb-nav-link-icon"><i class="fa fa-bars"></i></div>Home</a>';
                            }
                            ?>
                <?php

                // Definindo as opções do menu e seus respectivos links
                $menuOptions = array(
                    array('Professores', 'fa-user-circle', 'teacher-list.php', 'teacher-register.php'),
                    array('Acadêmicos', 'fa-graduation-cap', 'academic-list.php', 'academic-register.php'),
                    array('Cursos', 'fa-university', 'course-list.php', 'course-register.php'),
                    array('Trabalhos', 'fa-book', 'work-list.php', 'work-register.php')
                );
            
                // Iterando sobre as opções do menu
                foreach ($menuOptions as $option) {
                    $optionName = $option[0];
                    $optionIcon = $option[1];
                    $optionListLink = $option[2];
                    $optionNewLink = $option[3];
                
                    // Se o usuário for administrador, o link "Novo" será sempre visível
                    $showNewLink = ($_SESSION['user_type'] === 'administrador') ? '' : 'style="display:none;"';

                    // Se a opção for "Trabalhos" e o usuário for professor, o link "Novo" será visível
                    if (($_SESSION['user_type'] === 'professor' || $_SESSION['user_type'] === 'administrador') && ($optionName === 'Trabalhos' || $optionName === 'Acadêmicos')) {
                        $showNewLink = '';
                    }

                    // Imprimindo a opção do menu
                    echo <<<HTML
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{$optionName}" aria-expanded="false" aria-controls="collapse{$optionName}">
                            <div class="sb-nav-link-icon"><i class="fa {$optionIcon}" aria-hidden="true"></i></div>
                            {$optionName}
                            <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapse{$optionName}" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{$optionListLink}">Lista</a>
                                <a class="nav-link" href="{$optionNewLink}" {$showNewLink}>Novo</a>
                            </nav>
                        </div>
                    HTML;

                }
                ?>

            </div>
        </div>
    </nav>
</div>
