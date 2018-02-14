<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>iShutter</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.php">iShutter</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Übersicht</span>
          </a>
        </li>
        
        
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Übersicht</a>
        </li>
        <li class="breadcrumb-item active">iShutter</li>
      </ol>
      
          <!-- /Card Columns-->

        <?php

        error_reporting(E_ALL);

        // Zum Aufbau der Verbindung zur Datenbank
        define ( 'MYSQL_HOST',      'localhost' );
        define ( 'MYSQL_BENUTZER',  'db' );
        define ( 'MYSQL_KENNWORT',  'linkstart1' );
        define ( 'MYSQL_DATENBANK', 'ishutter' );

        $db_link = mysqli_connect (MYSQL_HOST,
            MYSQL_BENUTZER,
            MYSQL_KENNWORT,
            MYSQL_DATENBANK);

        if ( $db_link )
        {
        }
        else
        {
            // hier sollte dann später dem Programmierer eine
            // E-Mail mit dem Problem zukommen gelassen werden
            die('keine Verbindung möglich: ' . mysqli_error());
        }

        $sql = "SELECT count(*) as anz from Nodes";

        $db_erg = mysqli_query( $db_link, $sql );
        if ( ! $db_erg ) {
            die('Ungültige Abfrage: ' . mysqli_error());
        }

        foreach ($db_link->query($sql) as $row) {
            $Anzahl = $row['anz'];
        }


        $sql1 = "SELECT *from Nodes";
        $db_erg = mysqli_query( $db_link, $sql1 );
        if ( ! $db_erg ) {
            die('Ungültige Abfrage: ' . mysqli_error());
        }

        $Nodes_Name = Array();
        $Nodes_IP_Address = Array();
		$Nodes_ID = Array();
        $count = 0;

        foreach ($db_link->query($sql1) as $row) {
            $Nodes_Name[$count] = $row['name'];
            $Nodes_IP_Address[$count] = $row['ip_address'];
			$Nodes_ID[$count] = $row['n_id'];
            $count++;
			echo $Nodes_ID[$i];
        }


        echo "<table><tr>";
        for ($i = 0; $i < $Anzahl; $i++)
        {
            echo "<td>";
            echo "<img class=\"card-img-top img-fluid w-100\" src=\"https://unsplash.it/700/450?image=610\" alt=\"\">";
            echo $Nodes_Name[$i];
            echo "<br>";
            echo $Nodes_IP_Address[$i];
            echo "<br>";
            echo "<a href=\"http://stundner.tech/details.php?n_id=" . $Nodes_ID[$i] . "\"  class=\"btn btn-info\">Details</a>";
            echo "</td>";
            if(($i+1) % 4 == 0)
            {
                echo '</tr>';
                echo '<tr>';
            }
        }
        echo "</tr></table>";

        ?>


    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © iShutter 2017</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <a class="btn btn-primary" href="login.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
