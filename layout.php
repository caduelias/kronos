<?php 
    
    if ( !isset ($pagina ) ) {
        header("location: index.php");
    }

    $perfil = $_SESSION["user"]["perfil"];

?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="listar/alunos" class="nav-link">Alunos</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="cadastros/gerenciaraluno" class="nav-link">Gerenciar alunos</a>
      </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link active text-uppercase" data-toggle="dropdown" href="#">
       <i class="fas fa-user-shield"></i>     
        </a>
        <div class="dropdown-menu dropdown-menu dropdown-menu-right">
          <a href="pages/alterar-senha" class="dropdown-item text-center"><i class="fas fa-user-lock mr-1"></i> Alterar Senha</a>
          <div class="dropdown-divider"></div>
          <a href="pages/minha-conta" class="dropdown-item text-center"><i class="fas fa-id-card-alt mr-1"></i> Minha Conta</a>
          <div class="dropdown-divider"></div>
          <div class="dropdown-item text-center">
          <a href="logout.php" class="btn btn-block btn-outline-danger"><i class="fas fa-sign-out-alt"></i> Sair</a>  
          </div>
        </li>
     
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/kronoss.png" alt="Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-dark">Kronos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      
          <a class="nav-link ml-1" href="pages/minha-conta"><i class="fas fa-user-shield"> </i> </a>
    
        <div class="info">
          <a href="pages/minha-conta" class="d-block text-uppercase mt-1"> <?=$_SESSION["user"]["nome"];  ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">Gerenciar</li>
          <li class="nav-item has-treeview">
            <a class="nav-link">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Novo
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="cadastros/horario" class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                  <p>Horário</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cadastros/modalidade" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                  <p>Modalidade</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cadastros/treino" class="nav-link">
                <i class="nav-icon fas fa-dumbbell"></i>
                  <p>Treino</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cadastros/exercicio" class="nav-link">
                <i class="nav-icon fas fa-running"></i>
                  <p>Exercício</p>
                </a>
              </li>


                <?php 

                if ($perfil === "1" || $perfil === "2")

                {

                ?>

              <li class="nav-item">
                <a href="cadastros/plano" class="nav-link">
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                  <p>Plano</p>
                </a>
              </li>

              <?php

                }
              ?>

              <li class="nav-item">
                <a href="cadastros/aluno" class="nav-link">
                <i class="nav-icon fas fa-male"></i>
                  <p>Aluno</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="listar/aluno" class="nav-link">
                <i class="nav-icon fas fa-clipboard"></i>
                  <p>Avaliação Física</p>
                </a>
              </li>

            </ul>

          <li class="nav-item has-treeview">
            <a class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Listar
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="listar/modalidade" class="nav-link">
                  <i class="fas fa-table nav-icon"></i>
                  <p>Modalidade</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="listar/treino" class="nav-link">
                  <i class="fas fa-dumbbell nav-icon"></i>
                  <p>Treino</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="listar/exercicio" class="nav-link">  
                  <i class="fas fa-running nav-icon"></i>
                  <p>Exercício</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="listar/plano" class="nav-link">
                  <i class="fas fa-file-invoice-dollar nav-icon"></i>
                  <p>Planos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="listar/horario" class="nav-link">
                  <i class="fas fa-clock nav-icon"></i>
                  <p>Horários</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="listar/aluno" class="nav-link">
                  <i class="fas fa-male nav-icon"></i>
                  <p>Alunos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="listar/avaliacoes" class="nav-link">
                  <i class="fas fa-clipboard nav-icon"></i>
                  <p>Avaliações</p>
                </a>
              </li>

            </ul>
          </li>

          </li>
          <li class="nav-header">Informações</li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Relatórios
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="relatorio/aluno" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Alunos</p>
                </a>
              </li>
             
              <li class="nav-item">
                <a href="relatorio/situacao_aluno" class="nav-link">
                  <i class="fas fa-heartbeat nav-icon"></i>
                  <p>Situação Aluno</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="relatorio/modalidade" class="nav-link">
                  <i class="fas fa-stream nav-icon"></i>
                  <p>Modalidades</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item</p>
                </a>
              </li>
            </ul>
          </li>
        
         

          <?php 

          if ($perfil === "1" || $perfil === "2")

          {

          ?>

          <li class="nav-header">Sistema</li>
          <li class="nav-item has-treeview">
            <a class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Acesso
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="cadastros/usuario" class="nav-link">
                <i class="nav-icon fas fa-user-plus"></i>
                  <p>Novo</p>
                </a>
              </li>

              <li class="nav-item">
              <a href="listar/usuario" class="nav-link">
                  <i class="fas fa-user-friends nav-icon"></i>
                  <p>Usuários</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="listar/inativo" class="nav-link">
                  <i class="fas fa-user-times nav-icon"></i>
                  <p>Inativos</p>
                </a>
              </li>
            </ul>
          </li>

          <?php

          }
          ?>
         
            </ul>
          </li>
          
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<main>
    <div>
        <?php
            if (file_exists ( $pagina ))
                include $pagina;
            else 
                include "pages/404.php";
        ?>
    </div>
</main>
   
<footer class="main-footer bg-light">
<a class="text-dark" href="index.php"><strong class="text-dark">Kronos</strong></a> &copy; 2020 -
    Todos os direitos reservados.
    <div class="float-right d-none d-sm-inline-block">
      
      <b><a class="text-dark" href="https://github.com/caduelias?tab=repositories">Version</a></b> 1.0.0 
      
    </div>
  </footer>