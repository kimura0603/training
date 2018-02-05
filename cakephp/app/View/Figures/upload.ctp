<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>画像アップロード画面</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
?>
</head>
<body>
<div>
  <b>画像アップロード</b>
  <?php pr($user);?>
</div>
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
  <?php echo $this->Html->link('画像一覧へ戻る', array('action' => 'index'))?>
  </br>
  <?php echo $this->Html->link('ログアウト', array('controller' => 'users','action' => 'logout'))?>
  </div>
</div>

</body>
</html>