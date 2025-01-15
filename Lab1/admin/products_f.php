<?php
function DodajProdukt($title, $description, $creation_date, $expiration_date, $net_price, $vat, $quantity, $available, $category, $size, $image)
        {
            global $link;

            if (empty($title) || empty($description) || empty($creation_date) || empty($expiration_date) || empty($net_price) || empty($vat) || empty($quantity) || empty($category) || empty($size)) {
                echo "Nie wypełniono wszystkich pól";
                return;
            }

            $title = mysqli_real_escape_string($link, $title);
            $description = mysqli_real_escape_string($link, $description);

            $query = "INSERT INTO products (title, description, creation_date, expiration_date, net_price, vat, quantity, available, category, size, image) 
                    VALUES ('$title', '$description', '$creation_date', '$expiration_date', $net_price, $vat, $quantity, $available, $category, $size, '$image')";

            if (mysqli_query($link, $query)) {
                echo "Produkt dodany";
            } else {
                echo "Błąd: " . mysqli_error($link);
            }
        }

        function UsunProdukt($id)
        {
            global $link;
            $query = "DELETE FROM products WHERE id = $id";

            if (mysqli_query($link, $query)) {
                echo "Produkt usunięty";
            } else {
                echo "Błąd: " . mysqli_error($link);
            }
        }

        function EdytujProdukt($id, $title, $description, $modification_date, $net_price, $vat, $quantity, $available, $category, $size, $image)
        {
            global $link;

            if (empty($title) || empty($description) || empty($net_price) || empty($vat) || empty($quantity) || empty($category) || empty($size)) {
                echo "Nie wypełniono wszystkich pól";
                return;
            }

            $title = mysqli_real_escape_string($link, $title);
            $description = mysqli_real_escape_string($link, $description);

            $imagePart = $image ? ", image = '$image'" : "";
            $query = "UPDATE products SET title = '$title', description = '$description', modification_date = '$modification_date', 
                    net_price = $net_price, vat = $vat, quantity = $quantity, available = $available, category = $category, size = $size $imagePart
                    WHERE id = $id";

            if (mysqli_query($link, $query)) {
                echo "Produkt zaktualizowany";
            } else {
                echo "Błąd: " . mysqli_error($link);
            }
        }

        function PokazProdukty()
        {
            global $link;
            $query = "SELECT * FROM products";
            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "<table border='1'>
                        <tr>
                            <th>ID</th>
                            <th>Tytuł</th>
                            <th>Opis</th>
                            <th>Data Utworzenia</th>
                            <th>Data Wygaśnięcia</th>
                            <th>Cena Netto</th>
                            <th>VAT</th>
                            <th>Ilość</th>
                            <th>Dostępność</th>
                            <th>Kategoria</th>
                            <th>Rozmiar</th>
                            <th>Obraz</th>
                            <th>Akcje</th>
                        </tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['creation_date']}</td>
                            <td>{$row['expiration_date']}</td>
                            <td>{$row['net_price']}</td>
                            <td>{$row['vat']}</td>
                            <td>{$row['quantity']}</td>
                            <td>" . ($row['available'] ? 'Tak' : 'Nie') . "</td>
                            <td>{$row['category']}</td>
                            <td>{$row['size']}</td>
                            <td><img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' width='50' height='50'></td>
                            <td>
                                <a href='index.php?idp=admin/products.php&delete={$row['id']}'>Usuń</a>
                                <a href='index.php?idp=admin/products.php&edit={$row['id']}'>Edytuj</a>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "Brak produktów do wyświetlenia.";
            }
        }

        function PokazProduktyCutted()
        {
            global $link;
            $query = "SELECT * FROM products";
            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "<table border='1'>
                        <tr>
                            <th>ID</th>
                            <th>Tytuł</th>
                            <th>Opis</th>
                            <th>Data Utworzenia</th>
                            <th>Data Wygaśnięcia</th>
                            <th>Cena Netto</th>
                            <th>VAT</th>
                            <th>Ilość</th>
                            <th>Dostępność</th>
                            <th>Kategoria</th>
                            <th>Rozmiar</th>
                            <th>Obraz</th>
                        </tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['creation_date']}</td>
                            <td>{$row['expiration_date']}</td>
                            <td>{$row['net_price']}</td>
                            <td>{$row['vat']}</td>
                            <td>{$row['quantity']}</td>
                            <td>" . ($row['available'] ? 'Tak' : 'Nie') . "</td>
                            <td>{$row['category']}</td>
                            <td>{$row['size']}</td>
                            <td><img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' width='50' height='50'></td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "Brak produktów do wyświetlenia.";
            }
        }
?>