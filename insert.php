<?php
session_start();
//0.外部ファイル読み込み
include('functions.php');
chk_ssid();
if(
  !isset($_POST["title"]) || $_POST["title"]=="" 
  
){
  exit('ParamError');
}

//1. POSTデータ取得
//$name = filter_input( INPUT_GET, "name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$name = $_SESSION["name"];
$title = $_POST["title"];
$detail = $_POST["detail"];
$lid = $_SESSION["id"];

//2. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_f01_db28;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('dbError:'.$e->getMessage());
}

//３．データ登録SQL作成
$sql ="INSERT INTO need_table(id,name,title,detail,date,lid)
VALUES(NULL,:a1,:a2,:a3,sysdate(),:a4)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $title, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $detail, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a4', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);
}else{
  //５．select.phpへリダイレクト
  if($_SESSION['kanri_flg']==0){
    header("location: select.php");
  }else{
    header("location: select_kanri.php");
  }
  

}
?>
