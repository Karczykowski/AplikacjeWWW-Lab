<?php
session_start();

require_once '../cfg.php';

function FormularzLogowania()
{
    $wynik = "
    <div class='logowanie'>
        <h1 class='heading'>Panel CMS:</h1>
        <div class='logowanie'>
            <form method='post' name='LoginForm' enctype='multipart/form-data' action='" . $_SERVER['REQUEST_URI'] . "'>
                <table class='logowanie'>
                    <tr>
                        <td class='log4_t'>[email]</td>
                        <td><input type='text' name='login_email' class='logowanie' /></td>
                    </tr>
                    <tr>
                        <td class='log4_t'>[hasło]</td>
                        <td><input type='password' name='login_pass' class='logowanie' /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type='submit' name='x1_submit' class='logowanie' value='zaloguj' /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    ";
    return $wynik;
}

function ListaPodstron()
{
    global $link;

    $query = "SELECT id, page_title FROM page_list LIMIT 100";
    $result = mysqli_query($link, $query);

    echo '<table border="1">
            <tr>
                <th>id</th>
                <th>Tytuł strony</th>
                <th>Czynności</th>
            </tr>';

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['page_title'] . '</td>';
        echo '<td>
                <form method="get" action="' . $_SERVER['PHP_SELF'] . '">
                    <input type="hidden" name="edit_id" value="' . $row['id'] . '">
                    <button type="submit">Edytuj</button>
                </form>
                <form method="post">
                    <input type="hidden" name="delete_id" value="' . $row['id'] . '">
                    <button type="submit" name="delete">Usuń</button>
                </form>
              </td>';
        echo '</tr>';
    }

    echo '</table>';
}

function EdytujPodstrone($id)
{
    global $link;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tytul'])) {
        // Pobranie danych z formularza
        $tytul = mysqli_real_escape_string($link, $_POST['tytul']);
        $tresc = mysqli_real_escape_string($link, $_POST['tresc']);
        $status = isset($_POST['aktywny']) ? 1 : 0;

        // Przygotowanie zapytania do aktualizacji podstrony
        $query = "UPDATE page_list SET page_title = '$tytul', page_content = '$tresc', status = $status WHERE id = $id LIMIT 1";
        if (mysqli_query($link, $query)) {
            echo '<p>Podstrona została zaktualizowana!</p>';
        } else {
            echo '<p>Wystąpił błąd podczas aktualizacji: ' . mysqli_error($link) . '</p>';
        }
    } else {
        // Pobranie danych istniejącej podstrony z bazy danych
        $query = "SELECT page_title, page_content, status FROM page_list WHERE id = $id LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);

        // Formularz edycji
        echo '<form method="post">
                <label for="tytul">Tytuł:</label><br>
                <input type="text" id="tytul" name="tytul" value="' . htmlspecialchars($row['page_title']) . '" required><br><br>

                <label for="tresc">Treść:</label><br>
                <textarea id="tresc" name="tresc" required>' . htmlspecialchars($row['page_content']) . '</textarea><br><br>

                <label for="aktywny">Aktywny:</label>
                <input type="checkbox" id="aktywny" name="aktywny" ' . ($row['status'] ? 'checked' : '') . '><br><br>

                <input type="submit" value="Zapisz">
              </form>';
    }
}

function DodajNowaPodstrone()
{
    global $link;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tytul'])) {
        // Pobranie danych z formularza
        $tytul = mysqli_real_escape_string($link, $_POST['tytul']);
        $tresc = mysqli_real_escape_string($link, $_POST['tresc']);
        $status = isset($_POST['aktywny']) ? 1 : 0;

        // Przygotowanie zapytania do dodania nowej podstrony
        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$tytul', '$tresc', $status)";
        if (mysqli_query($link, $query)) {
            echo '<p>Nowa podstrona została dodana!</p>';
        } else {
            echo '<p>Wystąpił błąd podczas dodawania: ' . mysqli_error($link) . '</p>';
        }
    } else {
        // Formularz dodawania nowej podstrony
        echo '<form method="post">
                <label for="tytul">Tytuł:</label><br>
                <input type="text" id="tytul" name="tytul" required><br><br>

                <label for="tresc">Treść:</label><br>
                <textarea id="tresc" name="tresc" required></textarea><br><br>

                <label for="aktywny">Aktywny:</label>
                <input type="checkbox" id="aktywny" name="aktywny"><br><br>

                <input type="submit" value="Dodaj">
              </form>';
    }
}

function UsunPodstrone()
{
    global $link;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        $id = (int)$_POST['delete_id'];

        // Przygotowanie zapytania do usunięcia podstrony
        $query = "DELETE FROM page_list WHERE id = $id LIMIT 1";
        if (mysqli_query($link, $query)) {
            echo '<p>Podstrona została usunięta!</p>';
        } else {
            echo '<p>Wystąpił błąd podczas usuwania: ' . mysqli_error($link) . '</p>';
        }
    }
}

if (isset($_POST['x1_submit'])) {
    $userLogin = $_POST['login_email'];
    $userPass = $_POST['login_pass'];

    if ($userLogin == $login && $userPass == $pass) {
        $_SESSION['logged'] = true;
        echo "<p>Zalogowano</p>";
    } else {
        echo FormularzLogowania();
        echo "<p>Bledne dane logowania, spróbuj ponownie</p>";
        exit;
    }
}

if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
    echo FormularzLogowania();
    echo "<p>Zaloguj się</p>";
    exit;
}

if (isset($_GET['edit_id'])) {
    EdytujPodstrone((int)$_GET['edit_id']);
} elseif (isset($_GET['add_page'])) {
    DodajNowaPodstrone();
} else {
    echo "<p>Witaj w panelu administracyjnym!</p>";
    ListaPodstron();
    UsunPodstrone();
    echo '<br><a href="?add_page=1">Dodaj nową podstronę</a>';
}
?>
