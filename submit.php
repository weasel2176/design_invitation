<?php
session_start();
//0.外部ファイル読み込み
include('functions.php');
chk_ssid();

$id=$_GET['id'];

try {
  $pdo = new PDO('mysql:dbname=gs_f01_db28;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('dbError:'.$e->getMessage());
}

$stmt = $pdo->prepare('SELECT * FROM need_table WHERE id=:id');
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  //エラーのとき
  errorMsg($stmt);
}else{
  // エラーでないとき
  $rs = $stmt->fetch();
  // fetch()で1レコードを取得して$rsに入れる
  // $rsは配列で返ってくる．$rs["id"], $rs["name"]などで値をとれる
  // var_dump()で見てみよう
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>募集一覧</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
    <?php
    if($_SESSION['kanri_flg']==0){
      echo "<a class='navbar-brand' href='select.php'>投稿一覧</a>";
    }else if($_SESSION['kanri_flg']==1){
      echo "<a class='navbar-brand' href='select_kanri.php'>投稿一覧</a>";
    }
    

    ?>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="insert_fileup.php" enctype="multipart/form-data">
  <div class="jumbotron">
   <fieldset>
    <legend>デザイン要件</legend>
    <ul>
     <li>
     <label>投稿者：</label><?=$rs['name']?>
     </li>
     <li>
     <label>募集デザイン：</label><?=$rs['title']?>
     </li>
     <li>
     <label>詳細：</label><?=$rs['detail']?>
     </li>
    </ul>
    <legend>提出内容</legend>
     <label><input type="file" name="upfile" accept="image/*" capture="camera"></label><br>
     <label>コメント：</label><textArea name="detail" rows="4" cols="40"></textArea>
     <input type="submit">
     <!-- idは変えたくない = ユーザーから見えないようにする-->
     <input type="hidden" name="need_id" value="<?=$rs['id']?>">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->
<script src="https://cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>
  <script>
      CKEDITOR.replace('detail');
      // jsではalert(CKEDITOR.instances.detail.getData());で値がとれる
  </script> 


</body>
</html>