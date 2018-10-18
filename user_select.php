<?php
//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_f01_db28;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('dbError:'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
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
    $view .= "<tr class='bg-danger'><td>氏名：</td><td>".$result["name"]."　　　　"."<a href='user_detail.php?id=".$result['id']."'>編集</a></td></tr>
            <tr><td>ID：</td><td>".$result["lid"]."</td></tr>
            <tr><td class='col-xs-3'>パスワード：</td><td class='col-xs-9'>".$result["lpw"]."</td></tr>";
            if($result["kanri_flg"]==0){
              $view.="<tr><td>ユーザー区分：</td><td>通常ユーザー</td></tr>";
            }else{
              $view.="<tr><td>ユーザー区分：</td><td>管理ユーザー</td></tr>";
            }
            if($result["life_flg"]==0){
              $view.="<tr><td>利用状況：</td><td>使用中</td></tr>";
            }else{
              $view.="<tr><td>利用状況：</td><td>退会</td></tr>";
            }
    
    $view .=  "<tr><td><a href='user_delete.php?id=".$result["id"]."'>削除</a><td></tr>";
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>会員登録</title>
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
      <a class="navbar-brand" href="user_index.php">会員登録</a>
      <a class="navbar-brand" href="select_kanri.php">募集一覧</a>
      <a class="navbar-brand" href="index.php">募集投稿</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <p>会員一覧</p>
    <table class="table">
        <?=$view?>
    </table>
</div>
<!-- Main[End] -->

</body>
</html>
