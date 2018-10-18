<?php
//最初にSESSIONを開始！！
session_start();

//0.外部ファイル読み込み
include('functions.php');

//1.  DB接続します
$pdo = db_conn();
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

//2. データ登録SQL作成
// 入力したユーザー名とパスワードで一致するデータを探す
$stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE lid=:lid AND lpw=:lpw AND life_flg=0');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$res = $stmt->execute();

//3. SQL実行時にエラーがある場合
if($res==false){
  queryError($stmt);
}

//4. 抽出データ数を取得
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
$val = $stmt->fetch(); //1レコードだけ取得する方法

//5. 該当レコードがあればSESSIONに値を代入
if( $val['id'] != "" ){
  $_SESSION['chk_ssid']  = session_id();
  $_SESSION['id'] = $val['id'];
  $_SESSION['kanri_flg'] = $val['kanri_flg'];
  $_SESSION['name']      = $val['name'];
  if($val['kanri_flg']==0) header('Location: select.php');
  if($val['kanri_flg']==1) header('Location: select_kanri.php');
}else{
  // ログイン画面へ戻る
  header('Location: login.php');
}

exit();
?>

