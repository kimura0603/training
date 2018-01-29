<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>郵便番号検索システム</title>
</head>
<body>
<div>
  <?php echo $this->Form->create('Postnumber', array('type' => 'post')); ?>
  <div>
  <label for="postnumber">郵便番号を入力してください。</label></br>
  <?php echo $this->Form->text('Postnumber.num7')?>
  <div class="err" id="post_err"></div>
  </div>
  <div>
  <?php if(!$addnum){echo $this->Form->text('Postnumbr.address');
          if($return){echo $return["error"]["post"];}
        }elseif($addnum == 1){
            echo $this->Form->text('Postnumber.address', array('value'=> $addresses['Postnumber'][1]));
        }else{
            echo $this->Form->select('Postnumber.address', $addresses['Postnumber']);
        }?>
  </div>
  <?php echo $this->Form->submit('検索', array('id' => 'submit')); ?>
</div>
</body>
</html>

