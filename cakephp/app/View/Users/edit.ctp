<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>郵便番号検索システム　パスワード変更ページ</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
?>
</head>
<body>
<div>
  <b>パスワード変更のため、まずID/PASSWORD認証をしてください。</b>
</div>
<div>
  <?php echo $this->Form->create('User', array('url' => array('action'=>'edit'), 'novalidate' => true)); ?>
  <div class="err" id="err"><?php if($error){foreach($error as $key => $value){echo $value."</br>";}}?></div>
  <div>
  <label for="username">ID</label></br>
  <?php echo $this->Form->text('User.username', array('id' => 'username','value' => ''))?>
  </div>
  <div>
  <label for="password">PASSWORD</label></br>
  <?php echo $this->Form->text('User.password', array('value' => ''));?>
  </div>
  <?php echo $this->Form->submit('確認', array('id' => 'submit')); ?>
</div>

<div>
  <div>
  <?php echo $this->Html->link('ログインはこちらから', array('action' => 'index'))?>
  </br>
  <?php echo $this->Html->link('登録はこちらから', array('action' => 'register'))?>

  </div>
</div>

</body>
</html>