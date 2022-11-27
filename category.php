<?php
$dsn = 'mysql:dbname="データベース名";host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
$sql = $pdo -> prepare("INSERT INTO category_1 (name) VALUES (:name)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $name = 'マリン';
    $sql -> execute();?>