<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>登録画像結果一覧</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
?>
</head>
<body>
<div>
  <b>登録画像結果一覧</b>
  <?php
pr($user);
?>
</div>
<div>
    <table>
        <tr>
            <th><?php echo $this->Paginator->sort('created','アップロード日時');?></th>
            <th><?php echo $this->Paginator->sort('file_id','ファイル名');?></th>
        </tr>
        <?php foreach($figures as $figure){?>
        <tr>
            <th><?php echo $figure['Figure']['created'];?></th>
            <th><a href='/private/<?php echo $figure["Figure"]["id"];?>/<?php echo $figure["Figure"]["file_id"];?>' target='_blank'><img src='/private/thumb/<?php echo $figure["Figure"]["id"];?>/<?php echo $figure["Figure"]["file_id"];?>'></a></th>
        </tr>
        <?php } ?>
  </table>
</div>
<div>
    <?php echo $this->Paginator->counter();?>
    <?php echo $this->Paginator->prev('前ページ');?>
    <?php echo $this->Paginator->numbers();?>
    <?php echo $this->Paginator->next('次ページ');?>
</div>
  <div>
  <?php echo $this->Html->link('画像アップロード', array('action' => 'upload'))?>
  </br>
  <?php echo $this->Html->link('トップへ戻る', array('controller' => 'users','action' => 'top'))?>
  </br>
  <?php echo $this->Html->link('ログアウト', array('controller' => 'users','action' => 'logout'))?>
  </div>
</div>

</body>
</html>