<!DOCTYPE HTML>

<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>パスワード再登録ページ</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
?>
</head>
<body>
<div>
  <?php echo $this->Form->create('User', array('url' => '/users/forgetpasswordregister?token='.$token, 'novalidate' => true)); ?>
  <div class="err" id="err"><?php if($error){foreach($error as $key => $value){echo $value."</br>";}}?></div>
  <div><b>パスワード再登録ページ。再登録するパスワードを入力してください。</b></div>
  <div>
  <label for="password">PASSWORD</label></br>
  <?php echo $this->Form->text('User.password', array('autocomplete' => 'off', 'type' => 'password'));?>
  <label for="password">PASSWORD（確認）</label></br>
  <?php echo $this->Form->text('User.password2', array('autocomplete' => 'off'));?>
  </div>

  <?php echo $this->Form->submit('登録', array('id' => 'submit')); ?>

  <?php $this->Form->end(); ?>
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