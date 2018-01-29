<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>郵便番号検索システム</title>
    <style>
        .err {color: red;}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" charset="utf-8"></script>
    <script type ="text/javascript">
$(function(){
        $('#submit').click(function(){
        var postData = {};
        postData["post"] = $('[name=data['Postnumber']['num7']').val();
    //エラー赤文章リセット。蓄積防止
    $('#post_err').text('');

    //非同期通信時の処理（コールバック関数を定義） -->
    $.ajax({
        url: "/Postnumber/ajax",//サーバー処理の箇所
        type: "POST",
        dataType: "json",//JavaScript Object Notation 下の書き方の定義
            //dataでのプロパティ[postData]がPHPが受け取る配列のキーとなるわけです。data:{foo:'引数'}なら、PHP側は$_POST[‘foo’]で’引数’を受け取ることになります。
        data: postData,
            //下記のようにphpの$_Postはこんな感じに
            //			["test"]=>	string(17) "index_ajax0121php"}
        timeout: 30000,
        //送信前の処理：ボタンを非活性化して二重送信防止
        beforeSend: function(xhr, settings){
            $('.submit').attr('disabled', true);
            //$('#send_situ').text('ボタンブロック');
        },//beforesend　終わり
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("エラーです！");
                console.log("ajax通信に失敗しました");
                console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                console.log("XMLHttpRequest : " + XMLHttpRequest.responseText);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
            },
            //ajax通信成功の処理
            //success: 第一引数にphpの出力情報が返ってくる
            success: function(error, textStatus, xhr){
                //PHP側で、エラーであれば0、成功であれば1を返すようにしてあると仮定										//console.log(result);
                if(error.length == 0){
                      //alert("送信します");
                      $('#send_situ').text('郵便番号をご確認ください');
                      //$('#contact_form')[0].reset();
                }else{
                    console.log(error);
                    if(error["post"]){
                          $('#post_err').text(error["post"]);
                    }                  //var errorLength = error.length;
                    //$('#submit').attr('disabled', false);
                    //$('#send_situ').text('入力をやり直してください。');
                    //$('#send_situ').text('ボタンブロック解除');
                    //alert('text_status='+ textStatus +
                    //		' xhr.status='+ xhr.status +
                    //		' xhr.statusText='+ xhr.statusText);
                    //$('#send_err').text('送信完了しました');
                }//if error = 0終わり
            },//success　終わり
            complete: function(xhr, settings){ //AJAX通信完了時に呼ばれる関数です。successやerrorが呼ばれた後に呼び出されるAjax Eventです。
                $('.submit').attr('disabled', false);
            }//complete　終わり
        });//ajax　終わり
});//#submit click終わり
});//先頭文かっこ
    </script>
</head>
<body>
  <?php var_dump($addresses);?>
  <?php echo $this->Form->create('Postnumber', array('type' => 'post','url' => array('action' => 'ajax'))); ?>
  <?php echo $this->Form->textarea('Postnumber.num7')?>
  <div class="err" id="post_err"></div>
  <?php if(!$addnum){echo $this->Form->textarea('Postnumbr.address');
        }elseif($addnum == 1){
            echo $this->Form->textarea('Postnumber.address', array('value'=> $addresses['Postnumber'][1]));
        }else{
            echo $this->Form->select('Postnumber.address', $addresses['Postnumber']);
        }?>
  <?php echo $this->Form->submit('検索'); ?>
</body>
</html>

