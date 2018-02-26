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
  <?php echo $this->Form->create('User', array('url' => '/users/passreissue', 'novalidate' => true)); ?>
  <div class="err" id="err"><?php if($error){foreach($error as $key => $value){echo $value."</br>";}}?></div>
  <div><b>パスワード再発行</b></div>
  <div>
  <label for="username">ID入力</label></br>
  <?php echo $this->Form->text('User.username', array('autocomplete' => 'off'));?>
  <div>
  <label for="birthday">生年月日（本人確認のため）</label></br>
  <?php echo $this->Form->input('User.birth', array(
      'type' => 'date',
      'dateFormat' => 'YMD',
      'monthNames' => false,
      'maxYear' => date('Y'),
      'minYear' => date('Y') - 100,
      'empty' => array('year' => '年（西暦）', 'month' => '月', 'day' => '日'),
      'label' => false
  ));?>
  </div>

  <?php echo $this->Form->submit('再発行', array('id' => 'submit')); ?>

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