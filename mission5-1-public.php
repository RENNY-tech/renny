<?php
//データベースに接続
$dsn = 'mysql:dbname="データベース名";host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS mission5"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date TEXT,"
    . "password char(32)"
    .");";
    $stmt = $pdo->query($sql);

    
    if(!empty($_POST["name"]) && !empty($_POST["str"]) && empty($_POST["hidden_num"]) && $_POST["password"]){
        //データが飛んできた時
    $sql = $pdo -> prepare("INSERT INTO mission5 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
    $name = $_POST["name"];
    $comment = $_POST["str"]; 
    $date = date("Y年m月d日h時i分s秒");
    $password = $_POST["password"];
    $sql -> execute();

//データベースを読み込み、表示させる。
    $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";
    }}elseif(!empty($_POST["delete_num"] ) && $_POST["delete_num"] && $_POST["delete_password"]){
        //消去する時
        $id = $_POST["delete_num"] ; // idがこの値のデータだけを抽出したい、とする
        $sql = 'SELECT * FROM mission5 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
    foreach ($results as $row){
    $delete_password=$row["password"];
        if($_POST["delete_password"]==$delete_password){
        $stmt = $pdo->prepare("DELETE FROM mission5 WHERE id = :id");
        $stmt->bindParam( ':id', $id, PDO::PARAM_INT);
        $res = $stmt->execute();
        $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";}
    }}}elseif(!empty($_POST["edit_num"] ) && $_POST["edit_num"] && $_POST["edit_password"]){
        //編集したい行のデータを読み込む
     $id = $_POST["edit_num"] ; // idがこの値のデータだけを抽出したい、とする
$sql = 'SELECT * FROM mission5 WHERE id=:id ';
$stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
$stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
$stmt->execute();                             // ←SQLを実行する。
$results = $stmt->fetchAll(); 
    foreach ($results as $row){
        if($_POST["edit_password"]==$row["password"]){
    $edit_name=$row["name"];
    $edit_str=$row["comment"];
    $edit_num=$id;
        }
    else{
    $edit_name="";
    $edit_str="";
    $edit_num="";
    }
    //入手して、元のフォームに挿入することができた。
    $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";}}
    
    }elseif(!empty($_POST["hidden_num"]) && $_POST["name"] && $_POST["str"]){
     $id = $_POST["hidden_num"]; //変更する投稿番号
    $name = $_POST["name"];
    $comment = $_POST["str"];
    $date = date("Y年m月d日h時i分s秒");
    $password = $_POST["password"];//変更したい名前、変更したいコメントは自分で決めること
    $sql = 'UPDATE mission5 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();    
    $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";}
    }
    
    
    
    
    
    
    
    elseif(empty($_POST["name"]) && empty($_POST["str"])){
        //何もデータがない時→表示させるだけ
    $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";}
    }
?>

    <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
      <form action=""method="post" >
        <input type="text" placeholder="名前"name="name" value=<?php if (!empty($_POST["edit_num"])) {
                                            echo $edit_name;
                                           } ?>>
        <input type="text" placeholder="コメント" name="str"value=<?php if (!empty($_POST["edit_num"])) {
                                            
                                            echo $edit_str;
                                           } ?>>
        <input type="text" placeholder="パスワードを入力" name="password">
        <input type="submit" name="submit"><br>
        <input type="text" name="delete_num" placeholder="削除対象番号">
        <input type="text" placeholder="パスワードを入力" name="delete_password">
        <button name="delete" onclick="deleteBtn(this)">削除</button><br>
        <input type="text" name="edit_num" placeholder="編集対象番号">
        <input type="text" placeholder="パスワードを入力" name="edit_password">
        <button name="edit" onclick="editBtn(this)">編集</button><br>
        <input type="text" name="hidden_num" value=<?php if (!empty($_POST["edit_num"])) {
                                            echo $edit_num;
                                           } ?>>
   </form>
   </body>
   </html>
