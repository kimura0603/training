<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>登録画像表示</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
?>
</head>
<body>
<div>
  <b>登録画像表示</b>
</div>
<div>
</div>
<div>
  <div>
  <?php echo $this->Html->link('画像アップロード', array('action' => 'upload'))?>
  </br>
  <?php echo $this->Html->link('一覧に戻る', array('action' => 'index'))?>
  </div>
  <?php echo $this->Html->link('ログアウト', array('controller' => 'users','action' => 'logout'))?>
  </div>
</div>

</body>
</html>