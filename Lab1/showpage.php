<?php
function PokazPodstrone ($id)
{
$id_clear = htmlspecialchars($id);

$query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
//wywolywanie strony z bazy
if (empty($row['id']))
{
    $web = '[nie znaleziono strony]';
}
else
{
    $web = $row['page_content'];
}

return $web;
}
?>