<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>登録画像結果一覧</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
?>
</head>
<body>
<div>
  <b>登録画像結果一覧</b>
  <?php pr($user);?>
</div>
<div>
  <table>
<?php
  $header_list = array("番号","ファイル名","ファイル日時","閲覧可否");
  pr($figures);
  echo $this->Html->tableHeaders($header_list);
      foreach($figure as $figure){
          echo $this->Html->tableCells(
              array(
                $figure['Figure']['num'],
                $figure['Figure']['filename'],
                $figure['Figure']['created'],
                $figure['Figure']['accessible']
              )
          );
    }?>
  </table>
</div>
<div>
  <div>
  <?php echo $this->Html->link('画像アップロード', array('action' => 'upload'))?>
  </br>
  <?php echo $this->Html->link('ログアウト', array('controller' => 'users','action' => 'logout'))?>
  </div>
</div>

</body>
</html>