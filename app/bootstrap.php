<?php
session_start();

try {
    $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
} catch (\Random\RandomException $e) {
    echo $e->getMessage();
    exit;
}
$csrfToken = $_SESSION['csrf-token'];