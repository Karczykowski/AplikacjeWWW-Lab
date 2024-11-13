<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$basa = 'moja_strona';

$link = mysql_connect($dbhost, $dbuser, $dbpass);
if(!$link) echo '<b>przerwane polaczenie</b>';
if(!mysql_select_db($basa)) echo 'nie wybrano bazy';
echo 'test';
?>