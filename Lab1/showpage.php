<?php
function PokazPodstrone($id)
{
    $id_clear = htmlspecialchars($id);

    global $link;

    $query = "SELECT page_content FROM page_list WHERE id='$id_clear' LIMIT 1";
    $result = mysqli_query($link, $query);

    // Sprawdzanie wyniku
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['page_content'];
    }

    return '[nie znaleziono strony]';
}
?>
