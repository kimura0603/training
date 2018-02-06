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
  <?php pr($user);?>
</div>
<div>
  <table>
<?php
  $header_list = array("番号","サムネイル","ファイル日時");
  echo $this->Html->tableHeaders($header_list);
      foreach($figures as $figure){
          echo $this->Html->tableCells(
              array(
                $figure['Figure']['id'],
                //"<a href='/figures/result/".$figure['Figure']['id']."/".$figure['Figure']['file_id']."' target='_blank'><img alt='".$figure['Figure']['file_id']."' src='thumbnail/".$figure['Figure']['id']."/".$figure['Figure']['file_id']."' width='50' height='50'></a>",
                "<a href='/figures/result/".$figure['Figure']['id']."/".$figure['Figure']['file_id']."' target='_blank'><img alt='".$figure['Figure']['file_id']."' src='result/".$figure['Figure']['id']."/".$figure['Figure']['file_id']."' width='50' height='50'></a>",
                $figure['Figure']['created'],
              )
          );
    }?>
  </table>
</div>
<div>
  <div>
  <?php echo $this->Html->link('画像アップロード', array('action' => 'upload'))?>
  </br>
  <?php echo $this->Html->link('ログアウト', array('controller' => 'users','action' => 'logout'))?>
  </div>
</div>

</body>
</html>