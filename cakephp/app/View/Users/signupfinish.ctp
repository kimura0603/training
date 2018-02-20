<!DOCTYPE HTML>

<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>送信完了しました。メールBOXをご確認ください。</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
?>
</head>
<body>
<div>
  <p>送信完了しました。メールBOXをご確認ください。</p>
</div>

<div>
  <div>
  <?php echo $this->Html->link('ログインはこちらから', array('action' => 'index'))?>
  </br>
  <?php echo $this->Html->link('編集はこちらから', array('action' => 'edit'))?>
  </br>
  <?php echo $this->Html->link('ログアウト', array('action' => 'logout'))?>
  </div>


</body>
</html>