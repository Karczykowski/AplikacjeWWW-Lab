<?php

function PokazKontakt()
{
    echo '<form method="post" action="contact.php?action=send">
            <label for="name">Imię:</label><br>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">E-mail:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="message">Wiadomość:</label><br>
            <textarea id="message" name="message" required></textarea><br><br>

            <input type="submit" value="Wyślij">
          </form>';
}

function WyslijMailKontakt($odbiorca = 'mkarczykowski@gmail.com')
{
    if (empty($_POST['name']) || empty($_POST['message']) || empty($_POST['email'])) {
        echo 'Nie wypełniono wszystkich pól.';
        PokazKontakt();
    } else {
        $mail['subject']   = $_POST['name'];
        $mail['body']      = $_POST['message'];
        $mail['sender']    = $_POST['email'];
        $mail['recipient'] = $odbiorca;

        $header  = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-Type: text/plain; charset=UTF-8\n";
        $header .= "X-Sender: " . $mail['sender'] . "\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: " . $mail['sender'] . "\n";

        if (mail($mail['recipient'], $mail['subject'], $mail['body'], $header)) {
            echo 'wiadomosc_wyslana';
        } else {
            echo 'Wystąpił błąd podczas wysyłania wiadomości.';
        }
    }
}

function PrzypomnijHaslo()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];

        $to = $email;
        $subject = 'Przypomnienie hasła';
        $message = "Twoje hasło to: 123";
        $headers = "Od: 123@123.pl\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo '<p>Hasło zostało wysłane na podany adres e-mail!</p>';
        } else {
            echo '<p>Wystąpił błąd podczas wysyłania wiadomości.</p>';
        }
    } else {
        echo '<form method="post" action="contact.php?action=remind">
                <label for="email">Podaj swój e-mail:</label><br>
                <input type="email" id="email" name="email" required><br><br>

                <input type="submit" value="Przypomnij hasło">
              </form>';
    }
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'send':
            WyslijMailKontakt();
            break;
        case 'remind':
            PrzypomnijHaslo();
            break;
        default:
            PokazKontakt();
    }
} else {
    PokazKontakt();
}

?>
