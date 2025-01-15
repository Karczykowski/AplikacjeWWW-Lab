<table>
    <tr>
        <td class="menu" rowspan="2">
        <h2 class="main_menu" >Menu</h2>
        <ul class="main_menu_points">
            <li><a href="index.php?idp=html/pierwszylot.html">Pierwszy Lot</li>
            <li><a href="index.php?idp=html/apollo11.html">Apollo 11</li>
            <li><a href="index.php?idp=html/terazniejszosc.html">Teraźniejszosć</li>
            <li><a href="index.php?idp=html/onas.html">O nas</li>
            <li><a href="index.php?idp=php/contact.php">Kontakt</li>
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
        require_once 'cfg.php';
        include_once 'C:\xampp\htdocs\projappweb\AplikacjeWWW-Lab\Lab1\admin\products_f.php';

        function AddToCart($productId, $quantity) {
            global $link;

            $query = "SELECT * FROM products WHERE id = $productId";
            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {
                $product = mysqli_fetch_assoc($result);

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = [
                        'title' => $product['title'],
                        'net_price' => $product['net_price'],
                        'vat' => $product['vat'],
                        'quantity' => $quantity
                    ];
                }

                echo "Produkt został dodany do koszyka.";
            } else {
                echo "Produkt o podanym ID nie istnieje.";
            }
        }

        function RemoveFromCart($productId) {
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
                echo "Produkt został usunięty z koszyka.";
            } else {
                echo "Produkt nie znajduje się w koszyku.";
            }
        }

        function ShowCart() {
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $total = 0;
                echo "<table border='1'>
                        <tr>
                            <th>Produkt</th>
                            <th>Ilość</th>
                            <th>Cena Netto</th>
                            <th>VAT</th>
                            <th>Cena Brutto</th>
                        </tr>";

                foreach ($_SESSION['cart'] as $productId => $item) {
                    $netPrice = $item['net_price'];
                    $vat = $item['vat'];
                    $quantity = $item['quantity'];
                    $grossPrice = ($netPrice + ($netPrice * $vat / 100)) * $quantity;

                    $total += $grossPrice;

                    echo "<tr>
                            <td>{$item['title']}</td>
                            <td>{$quantity}</td>
                            <td>{$netPrice}</td>
                            <td>{$vat}%</td>
                            <td>" . number_format($grossPrice, 2) . "</td>
                        </tr>";
                }

                echo "<tr>
                        <td colspan='4'><strong>Łączna wartość:</strong></td>
                        <td><strong>" . number_format($total, 2) . "</strong></td>
                    </tr>
                    </table>";
            } else {
                echo "Koszyk jest pusty.";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add_to_cart'])) {
                $productId = intval($_POST['product_id']);
                $quantity = intval($_POST['quantity']);
                AddToCart($productId, $quantity);
            } elseif (isset($_POST['remove_from_cart'])) {
                $productId = intval($_POST['product_id']);
                RemoveFromCart($productId);
            }
        }

        PokazProduktyCutted();

        echo "<h2>Dodaj produkt do koszyka</h2>
        <form method='POST'>
            ID produktu: <input type='number' name='product_id' required><br>
            Ilość: <input type='number' name='quantity' value='1' min='1' required><br>
            <input type='submit' name='add_to_cart' value='Dodaj do koszyka'>
        </form>";

        echo "<h2>Usuń produkt z koszyka</h2>
        <form method='POST'>
            ID produktu: <input type='number' name='product_id' required><br>
            <input type='submit' name='remove_from_cart' value='Usuń z koszyka'>
        </form>";

        echo "<h2>Zawartość koszyka</h2>";
        ShowCart();
        ?>

    </td>
</tr>
<tr>
    <td class="footer" colspan="2">
        <p>Strona wykonana przez: Mariusz Karczykowski</p>
    </td>
    </tr>
</table>
