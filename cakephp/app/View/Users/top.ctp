<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Training トップページ</title>
    <style>
        .err {color: red;}
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
echo $this->Html->script('postnumbers_ajax');
?>
</head>
<body>
<div><?php if(isset($user)){pr($user);}?></div>
<div>
  <b><font size="5">トップページ機能一覧</font></b></br>
    <div style="padding-left:20px;">
        <ol>
            <li><?php echo $this->Html->link('郵便番号検索', array('controller' =>'postnumbers', 'action' => 'index'))?></li>
            <li><?php echo $this->Html->link('Photos', array('controller' =>'figures', 'action' => 'index'))?></li>
        </ol>
    </div>
</div>

<div>
    <div>
        <b><font size="5">アカウント設定</font></b></br>
    </div>
    <div style="padding-left:20px;">
        <?php
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
