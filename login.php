<?php

$err_msg = "";

if(isset($_POST["login"])){
    $user_name = $_POST["user_name"];
    $user_password = $_POST["user_password"];
   //データベースに接続
    try{$dsn = 'mysql:dbname="データベース名";host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = 'SELECT * FROM login_info';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        if($row["name"]==$user_name && $row["password"]==$user_password){
        header('location:https://tech-base.net/tb-240431/mission6/home.php');
        exit;
    }
    else{
        $err_msg = "ユーザー名またはパスワードが誤りです。";
    }
    
    }
    }catch (PDOException $e){
            echo $e->getMessage();
            exit;
    }
}elseif(isset($_POST["see"])){
        header('location:https://tech-base.net/tb-240431/mission6/home.php');
        exit;}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_6-2</title>
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
    <h2>ログイン</h2>
<form action="" method="POST" >
    <?php  if($err_msg !== null && $err_msg !== ""){echo $err_msg."<br>";}?>
      ユーザー名<input type="text" name="user_name" value=""></br><br>
      パスワード<input type="password" name="user_password" value=""></br><br>
      <input type="submit" name="login"value="ログイン"><br><br>
      <input type="submit" name="see" value="閲覧用(パスワードなしで入れます)">
</form>
<br>
<h4>ユーザー登録をしていない方はこちらから</h4>
<div class="center"> <a href="signin.php">新規登録</a></div>
 </body>
</html> 