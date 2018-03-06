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
    <h1><?php echo h($post['Post']['title']);?></h1>
    <p><small>Created: <?php echo $post['Post']['created'];?></small></p>
    <div>
    <p><?php echo h($post['Post']['body']); ?></p>
    </div>
    <div>
    <?php echo $this->Html->link('記事一覧へ戻る', array('controller' => 'posts', 'action' => 'index'))?>
    </div>
    <div>
      <div>
        </br>
        <div>下記管理者ユーザーなら表示</div>
        <?php echo $this->Html->link('管理トップへ戻る', array('controller' => 'user', 'action' => 'register'))?>
        <?php echo $this->Html->link('この記事の編集', array('action' => 'edit', $post['Post']['id']))?>
        <?php echo $this->Html->link('この記事の削除', array('action' => 'delete', $post['Post']['id']))?>
        <?php echo $this->Html->link('投稿', array('action' => 'add'))?>
        </br>
      </div>
    </div>
</body>
</html>
