
<table>
    <tr>
        <td class="menu" rowspan="2">
        <h2 class="main_menu" >Menu</h2>
        <ul class="main_menu_points">
            <li><a href="index.php?idp=html/pierwszylot.html">Pierwszy Lot</li>
            <li><a href="index.php?idp=html/apollo11.html">Apollo 11</li>
            <li><a href="index.php?idp=html/terazniejszosc.html">Teraźniejszosć</li>
            <li><a href="index.php?idp=html/onas.html">O nas</li>
            <li><a href="index.php?idp=html/contact.php">Kontakt</li>
            <li><a href="index.php?idp=html/lab2.html">Lab 2</li>
            <li><a href="index.php?idp=html/filmy.html">Filmy</a></li>
            <li><a href="index.php?idp=php/shopping_cart.php">Koszyk</a></li>
            <li><a href="index.php?idp=admin/admin.php">Panel Administracyjny</a></li>
        </ul>
        </td>
    <td class="title">
        <h1><a href="index.php">Historia Lotów Kosmicznych<img src="img/rocket.png" width="5%" height="auto"></h1>
    </td>
</tr>
<tr>
    <td class="content">
    <?php

        session_start();

        if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
            echo "<p>Zaloguj się, aby uzyskać dostęp do tej strony.</p>";
            exit;
        }

        function DodajKategorie($nazwa, $matka = 0) {
            global $link;
            $query = "INSERT INTO categories (matka, nazwa) VALUES ('$matka', '$nazwa')";
            if (mysqli_query($link, $query)) {
            } else {
                echo "Błąd: " . mysqli_error($link) . "<br>";
            }
        }

        function UsunKategorie($id) {
            global $link;

            $query = "DELETE FROM categories WHERE id = $id OR matka = $id";
            if (mysqli_query($link, $query)) {
            } else {
                echo "Błąd: " . mysqli_error($link) . "<br>";
            }
        }

        function EdytujKategorie($id, $nazwa, $matka = 0) {
            global $link;
            $query = "UPDATE categories SET nazwa = '$nazwa', matka = $matka WHERE id = $id";
            if (mysqli_query($link, $query)) {
            } else {
                echo "Błąd: " . mysqli_error($link) . "<br>";
            }
        }

        function PokazKategorie($matka = 0) {
            global $link;
            $query = "SELECT id, nazwa FROM categories WHERE matka = $matka";
            $result = mysqli_query($link, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "id:" . $row['id'] . ", " . htmlspecialchars($row['nazwa']) . "<a href='index.php?idp=admin/categories.php&usun=" . $row['id'] . "'>Usuń</a>  <a href='index.php?idp=admin/categories.php&edytuj=" . $row['id'] . "'>Edytuj</a><br>";

                $subquery = "SELECT id, nazwa FROM categories WHERE matka = " . $row['id'];
                $subresult = mysqli_query($link, $subquery);

                if (mysqli_num_rows($subresult) > 0) {
                    echo "<ul>";
                    while ($subrow = mysqli_fetch_assoc($subresult)) {
                        echo "<li>id: " . $subrow['id'] . ", " . htmlspecialchars($subrow['nazwa']) . " <a href='index.php?idp=admin/categories.php&usun=" . $subrow['id'] . "'>Usuń</a>  <a href='index.php?idp=admin/categories.php&edytuj=" . $subrow['id'] . "'>Edytuj</a></li>";
                    }
                    echo "</ul>";
                }
            }
        }


        if (isset($_POST['dodaj'])) {
            DodajKategorie($_POST['nazwa'], $_POST['matka']);
        } elseif (isset($_GET['usun'])) {
            UsunKategorie($_GET['usun']);
        } elseif (isset($_POST['edytuj'])) {
            EdytujKategorie($_POST['id'], $_POST['nazwa'], $_POST['matka']);
        }

        echo "<h3>Dodaj kategorię:</h3>";
        echo "<form method='POST'>";
        echo "Nazwa: <input type='text' name='nazwa' required><br>";
        echo "Nadkategoria: <input type='number' name='matka' value='0'><br>";
        echo "<input type='submit' name='dodaj' value='Dodaj kategorię'>";
        echo "</form>";

        if (isset($_GET['edytuj'])) {
            $id = (int)$_GET['edytuj'];
            $query = "SELECT nazwa, matka FROM categories WHERE id = $id";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_assoc($result);

            echo "<h3>Edytuj kategorię:</h3>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='id' value='" . $id . "'>";
            echo "Nazwa: <input type='text' name='nazwa' value='" . htmlspecialchars($row['nazwa']) . "' required><br>";
            echo "Matka: <input type='number' name='matka' value='" . $row['matka'] . "'><br>";
            echo "<input type='submit' name='edytuj' value='Edytuj kategorię'>";
            echo "</form>";
        }

        echo "<h3>Lista Kategorii:</h3>";
        PokazKategorie();
        echo "<br><a href='index.php?idp=admin/admin.php'>Zarządzaj stronami</a>";
        echo "<br><a href='index.php?idp=admin/products.php'>Zarządzaj produktami</a>";
        ?>

    </td>
</tr>
<tr>
    <td class="footer" colspan="2">
        <p>Strona wykonana przez: Mariusz Karczykowski</p>
    </td>
    </tr>
</table>