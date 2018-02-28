<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>ブログ閲覧</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
echo $this->Html->script('postnumbers_ajax');
?>
</head>
<body>
<h1>記事登録</h1>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->end('Save Post');
?>
<div>
  <div>
  <?php echo $this->Html->link('管理トップへ戻る', array('controller' => 'users', 'action' => 'top'))?>
  </br>
  <div>下記管理者ユーザーなら表示</div>
  <?php echo $this->Html->link('一覧', array('action' => 'index'))?>
  <?php echo $this->Html->link('編集', array('action' => 'edit'))?>
  <?php echo $this->Html->link('削除', array('action' => 'delete'))?>
  <?php echo $this->Html->link('投稿', array('action' => 'add'))?>
  </br>
  </div>
</div>

</body>
</html>
