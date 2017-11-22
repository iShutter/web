<?php
    if (isset($_POST['on']))
    {
	$output = shell_exec('mosquitto_pub -h 10.77.96.202 -t test -m "on"');
    }elseif (isset($_POST['off']))
    {
        $output = shell_exec('mosquitto_pub -h 10.77.96.202 -t test -m "off"');
    }

?>
<html>
<body>
    <form method="post">
    <p>
        <button name="on">Turn On</button>
    	<button name="off">Turn Off</button>
	</p>
    </form>
</body>





