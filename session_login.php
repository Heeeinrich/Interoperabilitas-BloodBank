<?php
session_start();

if (isset($_POST['token'])) {
    $_SESSION['token'] = $_POST['token'];

    // Optional: decode token (misalnya dari JWT payload) untuk ambil user_id
    // Tapi jika belum decoding, kita buat saja flag login
    $_SESSION['login_id'] = true;

    echo 'ok';
} else {
    echo 'token not received';
}
