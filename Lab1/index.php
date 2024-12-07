<!DOCTYPE html>
<html lang="pl">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="pl" />
<meta name="Author" content="Mariusz Karczykowski" />
<title>Historia Lotów Kosmicznych</title>
<link rel="stylesheet" href="css/style.css">
<script src="js/timedate.js" type="text/javascript"></script>
<script src="js/kolorujtlo.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="startclock()">
	<?php
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

		include('cfg.php');
		include('showpage.php');

		$podstrona = '';

		if (isset($_GET['idp']))
			$podstrona = $_GET['idp'];
		else
			$podstrona = "glowna.html";

		include('html/'.$podstrona)
?>
</body>
</html>