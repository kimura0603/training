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
  <?php echo $this->Form->create('Figure', array('type' => 'file', 'enctype' => 'multipart/form-data', 'url'=>'upload','novalidate' => true)); ?>
  <div class="err" id="err"><?php if($error){foreach($error as $key => $value){echo $value."</br>";}}?></div>
  <div>
      <label for="image">画像アップロード</label></br>
      <?php echo $this->Form->Input('image', array('type' => 'file'));?>
  </div>
  <?php echo $this->Form->submit('アップロード', array('id' => 'submit')); ?>
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