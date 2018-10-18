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

$stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE id=:id');
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
  <title>更新ページ</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" href="user_select.php">データ一覧</a>
    <a class="navbar-brand text-right" href="logout.php">ログアウト</a>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>更新ページ</legend>
     <label>名前：<input type="text" name="name" value="<?=$rs['name']?>"></label><br>
     <label>ID：<input type="text" name="lid" value="<?=$rs['lid']?>"></label><br>
     <label>パスワード：<input type="text" name="lpw" value="<?=$rs['lpw']?>"></label><br>
     <label>ユーザー区分：<input type="radio" name="kanri_flg" value=0>通常ユーザー　<input type="radio" name="kanri_flg" value=1>管理ユーザー</label><br>
     <label>利用状況：<input type="radio" name="life_flg" value=0>使用中　<input type="radio" name="life_flg" value=1>退会</label><br>
     <input type="submit" value="送信">
     <!-- idは変えたくない = ユーザーから見えないようにする-->
     <input type="hidden" name="id" value="<?=$rs['id']?>">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>