<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST['title']) || $_POST['title']=='' ||
  !isset($_POST['url']) || $_POST['url']=='' ||
  !isset($_POST['comment']) || $_POST['comment']==''
){
  exit('ParamError');
}

//1. POSTデータ取得
$id     = $_POST["id"];
$title   = $_POST["title"];
$url  = $_POST["url"];
$comment = $_POST["comment"];

//2. DB接続します(エラー処理追加)
try {
  $pdo = new PDO('mysql:dbname=gs_f01_db28;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('dbError:'.$e->getMessage());
}


//3．データ登録SQL作成
$stmt = $pdo->prepare('UPDATE gs_bm_table SET title=:a1,url=:a2,comment=:a3 WHERE id=:id');
$stmt->bindValue(':a1', $title, PDO::PARAM_STR);
$stmt->bindValue(':a2', $url, PDO::PARAM_STR);
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ登録処理後
if($status==false){
  errorMsg($stmt);
}else{
  header('Location: select.php');
  exit;
}
?>
