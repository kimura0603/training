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
  <b><font size="5">郵便番号システム</font></b></br>
  </div>

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

<div>
    <div>
        <b><font size="5">アカウント設定</font></b></br>
    </div>
    <div style="padding-left:20px;">
        <?php
        echo $this->Html->link('トップページヘ', array(
                  'controller' => 'users',
                  'action' => 'top'));
        echo "</br>";
        echo $this->Html->link('パスワード変更', array(
                  'controller' => 'users',
                  'action' => 'editpass'));
        echo "</br>";
        echo $this->Html->link('ユーザー新規登録', array(
                  'controller' => 'users',
                  'action' => 'register'));
        echo "</br>";
        echo $this->Html->link('ログアウト', array(
                  'controller' => 'users',
                  'action' => 'logout'));
        ?>
    </div>
</div>
</body>
</html>

