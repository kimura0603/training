<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>郵便番号検索システム</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
echo $this->Html->script('postnumbers_ajax');
?>
</head>
<body>
<div>


  <?php echo $this->Form->create('Postnumber', array('url' => array('action'=>'index'))); ?>
  <div>
  <label for="postnumber">郵便番号を入力してください。</label></br>
  <?php echo $this->Form->text('Postnumber.num7', array('id' => 'postnumber'))?>
  <div class="err" id="post_err"></div>
  </div>
  <div>
  <label for="postnumber">郵便番号検索結果</label></br>
  <?php echo $this->Form->text('Postnumber.address');?>
  </div>
  <?php echo $this->Form->submit('検索', array('id' => 'submit')); ?>
</div>
</body>
</html>

