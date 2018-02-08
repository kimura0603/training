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
  <?php echo $this->Form->text('User.password', array('autocomplete' => 'off'));?>
  <label for="password">PASSWORD（確認）</label></br>
  <?php echo $this->Form->text('User.password2', array('autocomplete' => 'off'));?>
  </div>
  <div>
  <label for="birthday">生年月日</label></br>
  <?php echo $this->Form->input('User.birth', array(
      'type' => 'date',
      'dateFormat' => 'YMD',
      'monthNames' => false,
      'maxYear' => date('Y'),
      'minYear' => date('Y') - 100,
      'empty' => array('year' => '年（西暦）', 'month' => '月', 'day' => '日'),
  ));?>
  </div>
  <div>
  <label for="age">年齢</label></br>
  <?php echo $this->Form->text('User.age', array('id' => 'age'))?>
  </div>

  <?php echo $this->Form->submit('登録', array('id' => 'submit')); ?>
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