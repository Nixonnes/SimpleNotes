<?php
require APP . '/bootstrap.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo $csrfToken; ?>">
    <title>ЗаметОчки</title>
    <base href="<?= PATH ?>/">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/app.js" defer></script>
</head>
<body>
    <header>
        <div class="logo">
            <h1><a href="/">ЗаметОчки</a></h1>
        </div>
        <div class="flash-container"></div>
    </header>
    <?php
    if (!empty($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']); // Удаляем сообщение после отображения
        echo "<div class='flash-container'>";
    echo "<div class='flash-message {$flash['type']}'>
    <p>{$flash['message']}</p>
    </div>";
        echo "</div>";
    }
