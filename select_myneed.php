<?php
session_start();
//0.外部ファイル読み込み
include('functions.php');
chk_ssid();

//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_f01_db28;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('dbError:'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM need_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        if($_SESSION['id']==$result["lid"]){
          $view .= "<tr class='bg-danger'><td>投稿者：</td><td>".$result["name"]."</td></tr>
               <tr><td>募集デザイン：</td><td>".$result["title"]."</td></tr>
               <tr><td class='col-xs-3'>詳細：</td><td class='col-xs-9'>".$result["detail"]."</td></tr>
               <tr><td>投稿日時：</td><td>".$result["date"]."</td></tr>";
        
          $view .= "<tr><td><a href='delete.php?id=".$result["id"]."'>この募集を削除</a><td></tr>";
        
    }
    
    
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>募集一覧表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">募集投稿</a>
      <a class="navbar-brand" href="select.php">募集一覧</a>
      <a class="navbar-brand pull-right" href="logout.php">ログアウト</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <p>自分の募集一覧</p>
    <table class="table">
        <?=$view?>
    </table>
</div>
<!-- Main[End] -->

</body>
</html>
