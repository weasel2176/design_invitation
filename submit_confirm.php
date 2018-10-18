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
$stmt = $pdo->prepare("SELECT * FROM design_table");
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
    $view .= "<tr class='bg-danger'><td>投稿者：</td><td>".$result["lid"]."</td></tr>
            <tr><td>デザイン：</td><td><a href=".$result["title"].">".$result["title"]."</a></td></tr>
            <tr><td class='col-xs-3'>登録日時：</td><td class='col-xs-9'>".$result["date"]."</td></tr>
            <tr><td>詳細：</td><td>".$result["detail"]."</td></tr>
            <tr><td><a class='btn-lg btn btn-success' href='submit.php?id=".$result['id']."'>この募集に投稿する</a></td></tr>
            <tr><td><a href='delete.php?id=".$result["id"]."'>削除</a><td></tr>";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>投稿完了</title>
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
      <a class="navbar-brand pull-right" href="logout.php">ログアウト</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <h1>以下の内容で投稿しました</h1>
    <table class="table">
        <?=$view?>
    </table>
</div>
<!-- Main[End] -->

</body>
</html>

