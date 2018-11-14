<?php
include('../inc/pdo.php');
include('../inc/fonctions.php');
include('inc/request.php');

  require '../vendor/autoload.php';

  use JasonGrimes\Paginator;

  $nbreItem = compteVaccins();
  $itemPerPage = 15;
  $page = 1;
  $offset = 0;
  $urlPattern = '?page=(:num)';
  $nomTable = 'v5_vaccin';


  if (!empty($_GET['page']) && is_numeric($_GET['page'])) {
      $page = $_GET['page'];
      $offset = $page * $itemPerPage - $itemPerPage;
  }

  $paginator = new Paginator($nbreItem, $itemPerPage, $page, $urlPattern);

  $tableauVaccins =  requeteListe($nomTable,$offset,$itemPerPage);



include('inc/header.php');
include('inc/sidebar.php');
?>
<section class="content-header">
  <h1>
    Liste des vaccins
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i>Home</a></li>
         <li class="active">Liste des vaccins</li>
  </ol>
</section>

<div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Id</th> <!-- titre -->
                  <th>Nom</th>
                  <th>Obligatoire</th>
                  <th>Fréquences d'injection</th>
                  <th>Created_at</th>
                  <th>Uptaded_at</th>
                  <th>Modifier</th>
                  <th>Delete</th>
                </tr>
                <?php foreach ($tableauVaccins as $tableauVaccin) {
                    echo '<tr><td>'.$tableauVaccin['id']
                    .'</td><td>'
                    .$tableauVaccin['nom']
                    .'</td>';
                    if ($tableauVaccin['obligatoire'] == 1){
                       echo '<td><span class="label label-success"</span>Obligatoire</td>';
                    } else {
                      echo '<td><span class="label label-danger">Non obligatoire</span></td>';
                    }
                    echo '</td><td>'
                    .$tableauVaccin['frequences_injections']
                    .'</td><td>';
                    changementDate($tableauVaccin,'created_at');
                    echo '</td><td>';
                    changementDate($tableauVaccin,'updated_at');
                    echo '</td><td><a href="modification_vaccins.php?id='.$tableauVaccin['id'].'" class=".btn.btn-app"><i class="fa fa-edit"></i></a></td>
                    <td>
                      <a href="delete_vaccins.php?id='.$tableauVaccin['id'].'" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer?\')">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td></tr>';
                }


                ?>
              </table>
              <?php echo $paginator ?>
            </div>
            <!-- /.box-body -->
          </div>

          <?php
            include('inc/footer.php');
