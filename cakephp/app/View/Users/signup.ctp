<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>検索システム　登録ページ</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
?>
</head>
<body>
<div><p>登録用メールアドレスを入力してください。</p></div>
<div>
  <?php echo $this->Form->create('User', array('url' => array('action'=>'signup'), 'novalidate' => true)); ?>
  <div class="err" id="err"><?php if($error){foreach($error as $key => $value){echo $value."</br>";}}?></div>
  <div>
  <label for="username">登録用メールアドレス。ログインに利用するIDとなります。</label></br>
  <?php
      echo $this->Form->text('User.username', array('id' => 'username'));
  ?>
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