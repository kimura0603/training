<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>郵便番号検索システム　登録ページ</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
?>
</head>
<body>
<div>
  <?php echo $this->Form->create('User', array('url' => array('action'=>'register'), 'novalidate' => true)); ?>
  <div class="err" id="err"><?php if($error){foreach($error as $key => $value){echo $value."</br>";}}?></div>
  <div>
  <label for="username">ID</label></br>
  <?php echo $this->Form->text('User.username', array('id' => 'username'))?>
  </div>
  <div>
  <label for="password">PASSWORD</label></br>
  <?php echo $this->Form->text('User.password');?>
  </div>
  <?php echo $this->Form->submit('登録', array('id' => 'submit')); ?>
</div>

<div>
  <div>
  <?php echo $this->Html->link('ログインはこちらから', array('action' => 'register'))?>
  </br>
  <?php echo $this->Html->link('編集はこちらから', array('action' => 'edit'))?>
  </div>


</body>
</html>