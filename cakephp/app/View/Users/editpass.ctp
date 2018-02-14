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
  <b>パスワード変更ページ</b>
</div>
<div><?php if(isset($user)){pr($user);}?></div>
<div>
  <?php echo $this->Form->create('User', array('url' => array('action'=>'editpass'), 'novalidate' => true)); ?>
  <div class="err" id="err"><?php if($error){foreach($error as $key => $value){echo $value."</br>";}}?></div>
  <div>
      <label for="password">現在のPASSWORD</label></br>
      <?php echo $this->Form->text('User.password', array('value' => '','autocomplete' => 'off'));?>
  </div>
  <div>
      <label for="password">新しいPASSWORD</label></br>
      <?php echo $this->Form->text('User.newpassword1', array('id' => 'password','value' => '','autocomplete' => 'off'))?>
  </div>
  <div>
      <label for="password">新しいPASSWORD（確認）</label></br>
      <?php echo $this->Form->text('User.newpassword2', array('value' => '','autocomplete' => 'off'));?>
  </div>
  <?php echo $this->Form->submit('変更', array('id' => 'submit')); ?>
</div>

<div>
  <div>
  <?php echo $this->Html->link('ログインはこちらから', array('action' => 'index'))?>
  </br>
  <?php echo $this->Html->link('登録はこちらから', array('action' => 'register'))?>
  </br>
  <?php echo $this->Html->link('ログアウト', array('action' => 'logout'))?>
  </div>
</div>

</body>
</html>