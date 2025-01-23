<?php

$db_config = require_once('../config/mysql.php');
$pdo = new PDO("mysql:host={$db_config['db_host']};dbname={$db_config['db_name']};charser={$db_config['db_charset']}", $db_config['db_user'], $db_config['db_pass']);
