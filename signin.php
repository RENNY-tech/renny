<?php
if(isset($_POST["signin"])){
    $user_name = $_POST["user_name"];
    $user_password = $_POST["user_password"];
   //データベースに接続
    try{$dsn = 'mysql:dbname="データベース名";host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS login_info"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "password char(32)"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = $pdo -> prepare("INSERT INTO login_info (name, password) VALUES (:name,:password)");
    $sql -> bindParam(":name", $user_name, PDO::PARAM_STR);
    $sql -> bindParam(":password", $user_password, PDO::PARAM_STR);
    $sql -> execute();
    $stmt = null;
    $pdo = null;
    
    header('location:https://tech-base.net/tb-240431/mission6/login.php');
    } catch (PDOException $e){
            echo $e->getMessage();
            exit;
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-3</title>
     <link rel="stylesheet" href="./sanitize.css">
    <link rel="stylesheet" href="./base.css">
    <style>
body {
	background-image: url(harper-sunday-Zl_I43sJHh4-unsplash.jpg);
	background-size: cover;
	padding: 5%;
	
	}
</style>
</head>
<body>
    
    <h2>新規登録</h2>
<form action="" method="POST" >
      ユーザー名<input type="text" name="user_name" value=""></br><br>
      パスワード<input type="password" name="user_password" value=""></br><br>
      <input type="submit" name="signin"value="登録">
</form>
 </body>
</html> 