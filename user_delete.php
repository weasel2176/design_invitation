<?php
//1. GETデータ取得
$id   = $_GET['id'];

//2. DB接続します(エラー処理追加)
try {
  $pdo = new PDO('mysql:dbname=gs_f01_db28;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('dbError:'.$e->getMessage());
}


//3．データ登録SQL作成
$stmt = $pdo->prepare('DELETE FROM gs_user_table WHERE id=:id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ登録処理後
if($status==false){
  errorMsg($stmt);
}else{
  
  header('Location: user_select.php');
  exit;
}
?>
