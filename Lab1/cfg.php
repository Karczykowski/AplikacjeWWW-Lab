<?php
$host = 'localhost';
$dbname = 'moja_strona';
$username = 'root';
$password = '';

$link = mysqli_connect($host, $username, $password, $dbname);

if (!$link) {
    echo '<b>Przerwano połączenie</b>';
}
?>