<?php
//データベースに接続
$dsn = 'mysql:dbname="データベース名";host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS images"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(250),"
    . "category char(32),"
    . "recommend char(255),"
    . "image_name char(255),"
    . "image_type char(30),"
    . "upload_image MEDIUMBLOB,"
    . "image_size int(11),"
    . "created_at datetime"
    .");";
    $stmt = $pdo->query($sql);
    
    
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 画像を取得
    $sql = 'SELECT * FROM images ORDER BY created_at DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $images = $stmt->fetchAll();
        }elseif(!empty($_POST["name"]) && !empty($_POST["category"]) && !empty($_POST["recommend"])){
        $img_name = $_FILES['upload_image']['name'];
        $img_type = $_FILES['upload_image']['type'];
        $img_size = $_FILES['upload_image']['size'];
    //画像を保存
     $fp = fopen($_FILES['upload_image']['tmp_name'], "rb");
    $img = fread($fp, filesize($_FILES['upload_image']['tmp_name']));
    fclose($fp);

    $sql = $pdo -> prepare("INSERT INTO images (name, category,recommend,image_name,image_type, upload_image, image_size, created_at ) 
    VALUES (:name, :category, :recommend, :image_name, :image_type, :upload_image, :image_size, now())");
    $sql -> bindValue(':name', $_POST["name"]);
    $sql -> bindValue(':category', $_POST["category"]); 
    $sql -> bindValue(':recommend', $_POST["recommend"]); 
    $sql -> bindValue(':image_name', $img_name);
    $sql -> bindValue(':image_type', $img_type);
    $sql -> bindValue(':upload_image', $img);
    $sql -> bindValue(':image_size', $img_size);
    $sql -> execute(); //データベースに保存完了！！！
    
    header('Location:home.php');
   
}

if(!empty($_POST["mypage"])){
     header('location:https://tech-base.net/tb-240431/mission6/mypage.php');
        exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./sanitize.css">
    <link rel="stylesheet" href="./style.css">
    <style>
body {
	background-image: url(harper-sunday-Zl_I43sJHh4-unsplash.jpg);
	background-size: cover;
	padding: 5%;
	
	}
</style>
</head>
    <body>
    <h2>あなたの使っている香水を教えてください！！</h2>
    <form action="" method="post" enctype="multipart/form-data">
    香水名  <input type="text" name="name" placeholder="香水名を入れてください！" ><br>
        <p>香水のカテゴリーを選んでください！
        <input type="radio" id="category1"name="category" value="wood">
    <label for="category1">ウッド</label>
   <input type="radio" id="category2"name="category" value="citras">
    <label for="category2">シトラス</label>
    <input type="radio" id="category3"name="category" value="vanilla">
    <label for="category3">バニラ</label></p>
    おすすめしたいポイント  <input type="text" name="recommend" placeholder="どこがおすすめですか？"><br><br>
   <input type="file" name="upload_image" accept="image/*">     
    <button class="submit" type="submit" name="upload">送信</button><br><br>
   </form>
   
   
   <div class="container mt-5">
       <h3>投稿された香水！！！</h3>
    
            <div class="list-unstyled">
                <?php for($i = 0; $i < count($images); $i++): ?>
                    <div class="media mt-5">
                        <a href="#lightbox" data-toggle="modal" data-slide-to="<?= $i; ?>">

                            <img src="image.php?id=<?= $images[$i]['id']; ?>" width="200" height="auto" class="mr-3">
                        </a><br>
                        
                        <div class="media-body">
                            <h5><?= $images[$i]['name']." ( ".$images[$i]['category']." )"."<br>".$images[$i]['recommend']."<br><br>".$images[$i]['created_at']; ?> </h5>
                          
                             <a href="javascript:void(0);" onclick="var ok = confirm('削除しますか？');
                            if (ok) {location.href='delete.php?id=<?= $images[$i]['id']; ?>';}"
                                 <i class="far fa-trash-alt"></i> 削除</a><br>
                               
                        </div>
                    </div>
                <?php endfor; ?>
          
            </div>
    </div>
       

       
    </body>
   </html>
    