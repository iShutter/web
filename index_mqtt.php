<?php

 // this will avoid mysql_connect() deprecation error.
 error_reporting( ~E_DEPRECATED & ~E_NOTICE );
 // but I strongly suggest you to use PDO or MySQLi.
 
 define('DBHOST', 'localhost');
 define('DBUSER', 'db');
 define('DBPASS', 'linkstart1');
 define('DBNAME', 'ishutter');
 
  
 $conn = mysqli_connect(DBHOST,DBUSER,DBPASS);
 $dbcon = mysqli_select_db($conn, DBNAME);
 
 if ( !$conn ) {
  die("Connection failed : " . mysqli_error());
 }
 
 if ( !$dbcon ) {
  die("Database Connection failed : " . mysqli_error());
 }
 //Open if time has passed
 if(!isset($_GET['control'])){
	 
 if (date('H') == 17) {
	 
   $res=mysqli_query($conn,"SELECT * FROM Action WHERE n_id = 5 order by a_id desc limit 1");
   $row=mysqli_fetch_array($res);
   $count = mysqli_num_rows($res); 
  if($row['direction'] != "up"){
	    $query = "INSERT INTO Action(direction,u_id,n_id) VALUES('up',1,5)";
    $res = mysqli_query($conn, $query);
    var_dump($res);
    
	$file = file_get_contents("http://10.77.97.14/index_mqtt.php?up=1");
	  var_dump($file);
  }else{
  echo "Already opened";
  }
}else{ echo "Zeit nicht erreicht"; }
 
 }
	  
 
 
    if (isset($_GET['up']))
    {
		$res=mysqli_query($conn,"SELECT * FROM Action WHERE n_id = " . $_GET['n_id'] . " order by a_id desc limit 1");
   $row=mysqli_fetch_array($res);
   $count = mysqli_num_rows($res); 
  if($row['direction'] != "up"){
	  //open jalousie only if it has not been opened before
	    $query = "INSERT INTO Action(direction,u_id,n_id) VALUES('up',1," . $_GET['n_id'] . ")";
    $res = mysqli_query($conn, $query);
    var_dump($res);
  shell_exec('mosquitto_pub -h 10.77.97.14 -t node -m "[' . $_GET['n_id'] . '][1]"');
  }else{
  echo "Already opened";
  }
	header('Location: details.php?n_id=' . $_GET['n_id']);
	exit;
    }elseif (isset($_GET['down']))
    {$res=mysqli_query($conn,"SELECT * FROM Action WHERE n_id = " . $_GET['n_id'] . " order by a_id desc limit 1");
   $row=mysqli_fetch_array($res);
   $count = mysqli_num_rows($res); 
  if($row['direction'] != "down"){
	  //open jalousie only if it has not been opened before
	    $query = "INSERT INTO Action(direction,u_id,n_id) VALUES('down',1," . $_GET['n_id'] . ")";
    $res = mysqli_query($conn, $query);
    var_dump($res);
     shell_exec('mosquitto_pub -h 10.77.97.14 -t node -m "[' . $_GET['n_id'] . '][0]"');
  }else{
  echo "Already closed";
  }
	header('Location: details.php?n_id=' . $_GET['n_id']);
	exit;
	}

?>




