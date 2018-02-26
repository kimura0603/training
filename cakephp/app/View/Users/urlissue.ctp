<!DOCTYPE HTML>

<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>登録ページ</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
?>
</head>
<body>
<div>
  <?php echo $this->Form->create('User', array('url' => '/users/urlissue', 'novalidate' => true)); ?>
  <div class="err" id="err"><?php if($error){foreach($error as $key => $value){echo $value."</br>";}}?></div>
  <div><b>URLToken発行ページ</b></div>
  <div>
  <label for="username">選択</label></br>
  <?php
  echo $this->Form->input('model', array(
      'type' => 'select',
      'options' => $selectModel,
      'label'=>false
  ));
  ?>
  </div>

  <?php echo $this->Form->submit('発行', array('id' => 'submit')); ?>

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