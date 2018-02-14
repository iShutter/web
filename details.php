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
		$res=mysqli_query($db_link,"SELECT * from Nodes where n_id = " . $_GET['n_id']);
		$node=mysqli_fetch_array($res);
														
													
?>
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
      <ul class="navbar-nav ml-auto">
       
        
       
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
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
        <li class="breadcrumb-item active">Slots</li>
      </ol>
      <!-- Example DataTables Card-->
      <table class="table-bordered">
	  
	  <?php 
	  $output = file_get_contents('https://api.darksky.net/forecast/894616269d1eaaf88259ebe7519687e5/48.211871,16.31293,1513715619?units=ca&lang=de');
	  $dec = json_decode($output);
	  ?>
	<th colspan="2"><h3>Node Informationen</h3></th><th colspan="2"><center><h3>Wetterinformationen</h3></center></th>
	 <tr><td><center>Name: </center></td><td><center><?php echo $node['name']; ?></center></td><td><center>Aktuelles Wetter: </center></td><td><center><?php echo $dec->currently->summary; ?></td></tr>
	 <tr><td><center>Standort: </center></td><td><center><?php echo $node['Location']; ?></td><td><center>Aktuelle Windgeschwindigkeit: </center></td><td><center><?php echo $dec->currently->windSpeed . "km/h"; ?></tr>
	 <tr><td><center>IP: </center></td><td><center><?php echo $node['ip_address']; ?></td><td><center>Aktueller Niederschlag: </center></td><td><center><?php echo $dec->currently->precipIntensity . "mm/h"; ?></tr>
	 <tr><td><center>Aktueller Status: </td><td><center><?php 
	 $res=mysqli_query($db_link,"SELECT * FROM Action WHERE n_id = 5 order by a_id desc limit 1");
   $row=mysqli_fetch_array($res);
   if($row['direction'] == "down"){
	   echo "unten";
   }else{
   echo "oben";}
	 
	 ?></center></td><td><center>Aktuelle Temperatur: </center></td><td><center><?php echo $dec->currently->apparentTemperature . "°C"; ?></center></td></tr>
	 <tr><td><center><a href ="index_mqtt.php?up=1&control=1<?php echo "&n_id=" . $_GET['n_id']; ?>"" class="fa fa-arrow-up fa-4"/ disabled></center></td><td><center><a href="index_mqtt.php?down=1&control=1<?php echo "&n_id=" . $_GET['n_id']; ?>" class="fa fa-arrow-down fa-4"/></center></td><td><center>Vorgeschlagene Jalousienstellung: </center></td><td><center><?php 
	 if($dec->currently->windSpeed > 10 || $dec->currently->precipIntensity > 6 || ($dec->currently->nearestStormDistance > 0 && $dec->currently->nearestStormDistance < 3)){
		 
		 echo "oben";
	 }else{
	 echo "unten</center>";}
	 ?></center></td></tr>
	 
	 </table><br><br>
	  <div class="card mb-3">
        
		<div class="card-header">
		
          <i class="fa fa-table"></i> <?php 
		 
					echo "Aktionen der Node  - ";
					$res=mysqli_query($db_link,"SELECT count(*) as cnt from Action where Action.n_id = " . $_GET['n_id']);
				

													$row=mysqli_fetch_array($res);
													echo $row['cnt']; ?>
													</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Action ID</th>
                  <th>Richtung</th>
                  <th>Zeit</th>
				  <th>Benutzer</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Action ID</th>
                  <th>Richtung</th>
                  <th>Zeit</th>
				  <th>Benutzer</th>
                </tr>
              </tfoot>
              <tbody>
                <?php 
				 $sql = "SELECT * from Action join Nodes on Nodes.n_id = Action.n_id where Action.n_id = " . $_GET['n_id'] . " order by date_time desc";
				
            $results = mysqli_query($db_link,$sql);
			
            while($rowitem = mysqli_fetch_array($results)) {
            echo "<tr>";
                echo "<td>" . $rowitem['a_id'] . "</td>";
                echo "<td>" . $rowitem['direction'] . "</td>";
                echo "<td>" . $rowitem['date_time'] . "</td>";
				echo "<td>" . $rowitem['n_id'] . "</td>";
				
            echo "</tr>";
            }
            ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
    </div>
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
