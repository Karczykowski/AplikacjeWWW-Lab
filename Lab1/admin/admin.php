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
                <button type="submit" name="edit">Edytuj</button>
                <button type="submit" name="delete">Usun</button>
              </td>';
        echo '</tr>';
    }

    echo '</table>';
}

function EdytujPodstrone($id)
{
    global $link;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pobranie danych z formularza
        $tytul = $_POST['tytul'];
        $tresc = $_POST['tresc'];
        $aktywny = isset($_POST['aktywny']) ? 1 : 0;

        // Przygotowanie zapytania do aktualizacji podstrony
        $stmt = $link->prepare("UPDATE page_list SET tytul = ?, tresc = ?, aktywny = ? WHERE id = ? LIMIT 1");
        $stmt->bind_param('ssii', $tytul, $tresc, $aktywny, $id);
        $stmt->execute();

        // Potwierdzenie
        echo '<p>Podstrona została zaktualizowana!</p>';
    } else {
        // Pobranie danych istniejącej podstrony z bazy danych
        $stmt = $link->prepare("SELECT tytul, tresc, aktywny FROM page_list WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        // Formularz edycji
        echo '<form method="post">
                <label for="tytul">Tytuł:</label><br>
                <input type="text" id="tytul" name="tytul" value="' . htmlspecialchars($result['tytul']) . '" required><br><br>

                <label for="tresc">Treść:</label><br>
                <textarea id="tresc" name="tresc" required>' . htmlspecialchars($result['tresc']) . '</textarea><br><br>

                <label for="aktywny">Aktywny:</label>
                <input type="checkbox" id="aktywny" name="aktywny" ' . ($result['aktywny'] ? 'checked' : '') . '><br><br>

                <input type="submit" value="Zapisz">
              </form>';
    }
}


if (isset($_POST['x1_submit'])) {
    $userLogin = htmlspecialchars($_POST['login_email']);
    $userPass = htmlspecialchars($_POST['login_pass']);

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

echo "<p>Witaj w panelu administracyjnym!</p>";
ListaPodstron();
?>