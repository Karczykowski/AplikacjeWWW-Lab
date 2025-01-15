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
        include_once('products_f.php');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imageData = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $imageData = mysqli_real_escape_string($link, file_get_contents($_FILES['image']['tmp_name']));
            }

            if (isset($_POST['add'])) {
                $available = isset($_POST['available']) ? 1 : 0;
                DodajProdukt($_POST['title'], $_POST['description'], $_POST['creation_date'], $_POST['expiration_date'], $_POST['net_price'], $_POST['vat'], $_POST['quantity'], $available, $_POST['category'], $_POST['size'], $imageData);
            } elseif (isset($_POST['update'])) {
                EdytujProdukt($_POST['id'], $_POST['title'], $_POST['description'], $_POST['modification_date'], $_POST['net_price'], $_POST['vat'], $_POST['quantity'], $_POST['available'], $_POST['category'], $_POST['size'], $imageData);
            }
        }
        if (isset($_GET['delete'])) {
            UsunProdukt($_GET['delete']);
        }

        echo "<h2>Dodaj Produkt</h2>
        <form method='POST' enctype='multipart/form-data'>
            Tytuł: <input type='text' name='title'><br>
            Opis: <textarea name='description'></textarea><br>
            Data Utworzenia: <input type='date' name='creation_date'><br>
            Data Wygaśnięcia: <input type='date' name='expiration_date'><br>
            Cena Netto: <input type='number' step='0.01' name='net_price'><br>
            VAT: <input type='number' step='0.01' name='vat'><br>
            Ilość: <input type='number' name='quantity'><br>
            Dostępność: <input type='checkbox' name='available' value='1'><br>
            Kategoria: <input type='number' name='category'><br>
            Rozmiar: <input type='number' step='0.01' name='size'><br>
            Obraz: <input type='file' name='image'><br>
            <input type='submit' name='add' value='Dodaj Produkt'>
        </form>";

        PokazProdukty();

        if (isset($_GET['edit'])) {
            $id = intval($_GET['edit']);
            $query = "SELECT * FROM products WHERE id = $id";
            $result = mysqli_query($link, $query);
            $product = mysqli_fetch_assoc($result);

            if ($product) {
                echo "<h2>Edytuj Produkt</h2>
                <form method='POST' enctype='multipart/form-data'>
                    <input type='hidden' name='id' value='{$product['id']}'>
                    Tytuł: <input type='text' name='title' value='{$product['title']}'><br>
                    Opis: <textarea name='description'>{$product['description']}</textarea><br>
                    Data Modyfikacji: <input type='date' name='modification_date' value='" . date('Y-m-d') . "'><br>
                    Cena Netto: <input type='number' step='0.01' name='net_price' value='{$product['net_price']}'><br>
                    VAT: <input type='number' step='0.01' name='vat' value='{$product['vat']}'><br>
                    Ilość: <input type='number' name='quantity' value='{$product['quantity']}'><br>
                    Dostępność: <input type='checkbox' name='available' value='1' " . ($product['available'] ? 'checked' : '') . "><br>
                    Kategoria: <input type='number' name='category' value='{$product['category']}'><br>
                    Rozmiar: <input type='number' step='0.01' name='size' value='{$product['size']}'><br>
                    Obraz: <input type='file' name='image'><br>
                    <input type='submit' name='update' value='Zaktualizuj Produkt'>
                </form>";
            } else {
                echo "Nie znaleziono produktu o ID: $id";
            }
        }
        echo "<br><a href='index.php?idp=admin/admin.php'>Zarządzaj stronami</a>";
        echo "<br><a href='index.php?idp=admin/categories.php'>Zarządzaj kategoriami</a>";
        ?>

    </td>
</tr>
<tr>
    <td class="footer" colspan="2">
        <p>Strona wykonana przez: Mariusz Karczykowski</p>
    </td>
    </tr>
</table>