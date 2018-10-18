<?php
session_start();
include('functions.php');
//1. POSTデータ取得
$name  = $_SESSION['name'];
$need_id  = $_POST['need_id'];
$detail = $_POST['detail'];

// アップロード関連を追加

//Fileアップロードチェック
if (isset($_FILES['upfile'] ) && $_FILES['upfile']['error'] ==0 ) {
    // ファイルをアップロードしたときの処理
    //アップロードしたファイルの情報取得
    $file_name = $_FILES['upfile']['name'];     //アップロードしたファイルのファイル名
    $tmp_path  = $_FILES['upfile']['tmp_name']; //アップロード先のTempフォルダ
    $file_dir_path = 'upload/';                 //画像ファイル保管先のディレクトリ名，自分で設定する
    
    //File名の変更
    $extension = pathinfo($file_name, PATHINFO_EXTENSION);              //拡張子取得
    $uniq_name = date('YmdHis').md5(session_id()) . "." . $extension;   //ユニークファイル名作成
    $file_name = $file_dir_path.$uniq_name;                             //ファイル名とパス

    // FileUpload [--Start--]
    $img='';
    if ( is_uploaded_file( $tmp_path ) ) {
        if ( move_uploaded_file( $tmp_path, $file_name ) ) {
            chmod( $file_name, 0644 );
            // <img>を使って画像を出力しよう
            $img = '<img src="'.$file_name.'">';
            $view="<tr><td>投稿者：</td><td>".$_SESSION['name']."</td></tr><tr><td>画像</td><td>".$img."</td></tr><tr><td>詳細：</td><td>".$detail."</td></tr>";
        } else {
            exit('Error:アップロードできませんでした．');
        }
    }
    // FileUpload [--End--]
}else{
    // ファイルをアップしていないときの処理
    $view = '画像が送信されていません'; //Error文字
}



//2. DB接続します(エラー処理追加)
$pdo = db_conn();

//３．データ登録SQL作成
// SQLにimageカラムを追記
$stmt = $pdo->prepare('INSERT INTO '. $design_table .'(id, lid, image, detail,
date, need_id)VALUES(NULL, :a1, :a2, :a3, sysdate(),:a4)');
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);
$stmt->bindValue(':a2', $file_name, PDO::PARAM_STR);
$stmt->bindValue(':a3', $detail, PDO::PARAM_STR);
$stmt->bindValue(':a4', $need_id, PDO::PARAM_STR);
$status = $stmt->execute();

//４．データ登録処理後

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
      <a class="navbar-brand" href="select_myneed.php">自分の募集</a>
      <?php
      if($_SESSION['kanri_flg']==0){
        echo "<a class='navbar-brand' href='select.php'>募集一覧</a>";
      }else{
        echo "<a class='navbar-brand' href='select_kanri.php'>募集一覧</a>";
      }
      ?>
      
      <a class="navbar-brand pull-right" href="logout.php">ログアウト</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <h2>以下の内容で投稿しました。</h2>
    <table class="table">
        <?=$view?>
    </table>
</div>
<!-- Main[End] -->

</body>
</html>
