<?php
session_start();

require_once(__DIR__."/../dao/class-datasource.php");
require_once(__DIR__."/../dao/class-userpunctuategameDao.php");
require_once(__DIR__."/../model/class-userpunctuategame.php");

require_once (__DIR__ . "/../dao/class-gameDAO.php");
require_once (__DIR__ ."/../model/class-game.php");

require_once(__DIR__ . "/../dao/class-userDAO.php");
require_once(__DIR__ . "/../model/class-user.php");

/*Delete a punctuation*/
$punctuationDAO = new punctuationDAO();
$punctuation = new punctuation();

if(isset($_POST['delete_punctuation']) == 'eliminar'){
  $score_id = $punctuation->get_id($_POST['delete_punctuation']);
  $punctuationDAO->delete_punctuation($score_id);
  echo 'OK';
 }

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin Punctuations Page</title>

  <!-- Custom fonts for this template-->
  <link href="../views/templates/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../views/templates/admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../views/templates/admin/css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="admin_index.php">Administrador</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Buscar..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Ajustes</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-users"></i>
                <span>Usuarios</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar usuarios:</h6>
                <a class="dropdown-item" href="../userManagement.php">Crear usuario</a>
                <a class="dropdown-item" href="usersManagement.html">Modificaciones/Bajas</a>
                <a class="dropdown-item" href="userProfile.php">Listado de usuarios</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">Feedback:</h6>
                <a class="dropdown-item" href="punctuations.php">Valoraciones</a>
                <a class="dropdown-item" href="comments.php">Comentarios</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-puzzle-piece"></i>
                <span>Juegos</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar juegos:</h6>
                <a class="dropdown-item" href="searchGame.html">Buscar</a>
                <a class="dropdown-item" href="newGame.html">Añadir</a>
                <a class="dropdown-item" href="manageGame.html">Actualizar/Eliminar</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-ellipsis-h"></i>
                <span>Categorías</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Gestionar categorías:</h6>
                <a class="dropdown-item" href="newCategory.html">Añadir/Eliminar</a>
            </div>
        </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="admin_index.php">Admin</a>
          </li>
          <li class="breadcrumb-item active">Valoraciones</li>
        </ol>

        <!-- Page Content-->
        <h1>Listado de valoraciones</h1>
        <hr>

        <!-- DataTables -->
        <!-- The list returns all the DB games -->
        <div class="card mb-5">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Listar valoraciones</div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nivel de usuario</th>
                        <th>Juego</th>
                        <th>Puntuación</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      $punctuation = new punctuation();
                      $punctuationDAO = new punctuationDAO();

                      $punctuations = $punctuationDAO->list_punctuations();

                      foreach ($punctuations as $punctuation) {
                          ?>
                      <tr>
                          <th><?= $punctuation->get_id(); ?></th>
                          
                          <?php  
                          $user_dao = new userDAO();
                          $user = $user_dao->get_user_by_id($punctuation->get_user_id());
                          ?>
                          <td><?= $user->get_email() ?></td>
                          <td><?= $punctuation->get_user_level_id(); ?></td>

                          <?php  
                          $game_dao = new gameDAO();
                          $game = $game_dao->get_game_by_id($punctuation->get_game_id());
                          ?>

                          <td><?= $game->get_name() ?></td>
                          <td><?= $punctuation->get_punctuation(); ?></td>
                          <td><?= $punctuation->get_date(); ?></td>
                          <td>
                            <form name="delete-form" method="post" action="punctuations.php">
                                <button class="btn btn-danger" type="submit" name="delete_punctuation" value="<?=  $punctuation->get_id(); ?>" >Eliminar</button>
                            </form>
                          </td>
                      </tr>
                          <?php
                      }
                      ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nivel de usuario</th>
                        <th>Juego</th>
                        <th>Puntuación</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                    </tfoot>
                </table>
                </div>
            </div>
            <div class="card-footer small text-muted">
            <?php echo "Última modificación: " . date ("d F Y H:i", getlastmod()); ?>
            </div>
        </div>

    </div>

      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Rotten Board Games 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.php">Logout <?php session_destroy() ?></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../views/templates/admin/vendor/jquery/jquery.min.js"></script>
  <script src="../views/templates/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../views/templates/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../views/templates/admin/vendor/chart.js/Chart.min.js"></script>
  <script src="../views/templates/admin/vendor/datatables/jquery.dataTables.js"></script>
  <script src="../views/templates/admin/vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../views/templates/admin/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../views/templates/admin/js/demo/datatables-demo.js"></script>
  <script src="../views/templates/admin/js/demo/chart-area-demo.js"></script>

</body>

</html>