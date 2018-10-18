<?php
session_start();
//0.外部ファイル読み込み
include('functions.php');
chk_ssid();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>募集投稿</title>
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
    }else{
      echo "<a class='navbar-brand' href='select_kanri.php'>投稿一覧</a>";
    }
    

    ?>
    </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend class="text-center">募集するデザインの情報</legend>
    <ul>
      <li>
       <label>募集者名：</label><?=$_SESSION['name']?>
      </li>
      <li>
       <label>募集するデザイン：</label><input type="text" name="title">
      </li>
      <li>
       <label>詳細な要件：</label><textArea name="detail" rows="4" cols="40"></textArea>
      </li>
    </ul>
     
     <input class="btn btn-warning btn-lg center-block" type="submit" value="募集開始">
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
