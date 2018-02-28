<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>郵便番号検索システム　ログインページ</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
echo $this->Html->script('postnumbers_ajax');
?>
</head>
<body>
<div><?php echo $this->Session->flash();?></div>
<div><?php if(isset($user)){pr($user);}?></div>
<div class="bg-success">
  <?php echo $this->Form->create('User', array('url' => array('controller'=>'users','action'=>'login'), 'novalidate' => true)); ?>
  <div class="err" id="err"><?php if($error){foreach($error as $key => $value){echo $value."</br>";}}?></div>
  <div>
  <label for="username">ID</label></br>
  <?php echo $this->Form->text('User.username', array('id' => 'username','value' => ''))?>
  </div>
  <div>
  <label for="password">PASSWORD</label></br>
  <?php echo $this->Form->text('User.password', array('value' => ''));?>
  </div>
  <div>
  <span class="text-danger">自動ログインする</span>
  <?php
    //echo $this->Form->checkbox('User.auto_login', array('value' => 1, 'options' => array('checked' => 'true')));
    echo $this->Form->checkbox('User.auto_login', array('value' => 1, 'checked' => 'true'));
    ?>
  </div>
  <?php echo $this->Form->submit('ログイン', array('id' => 'submit')); ?>
</div>

<div>
  <div>
    <?php echo $this->Html->link('登録はこちらから', array('action' => 'register'))?>
  </br>
    <?php echo $this->Html->link('編集はこちらから', array('action' => 'edit'))?>
  </br>
    <?php echo $this->Html->link('パスワード忘れの場合はこちらから', array('action' => 'passreissue'))?>
  </br>
    <?php echo $this->Html->link('ログアウト', array('action' => 'logout'))?>
  </div>
</div>

</body>
</html>
