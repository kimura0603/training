$(function(){
    //$('#postnumber').keyup(function(){
    $('#postnumber').change(function(){
    //$('#submit').click(function(){
        var postData = {};
        postData["Postnumber"] = $('#postnumber').val();
        //エラー赤文章リセット。蓄積防
        $('#post_err').text('');
        $('#PostnumberAddress').show();
        $('#PostnumberAddress').val('');
        if($(".address").length){
        $(".address").remove();
        }
$.ajax({
    url: '<?php echo $this->Html->Url(array('action'=>'index'));?>',//サーバー処理の箇所
    type: "POST",
    //cache: false,
    dataType: "json",//JavaScript Object Notation 下の書き方の定義
        //dataでのプロパティ[postData]がPHPが受け取る配列のキーとなるわけです。data:{foo:'引数'}なら、PHP側は$_POST[‘foo’]で’引数’を受け取ることになります。
    data: postData,
        //下記のようにphpの$_Postはこんな感じに
        //			["test"]=>	string(17) "index_ajax0121php"}
    timeout: 30000,
    //送信前の処理：ボタンを非活性化して二重送信防止
    beforeSend: function(xhr, settings){
        $('#submit').attr('disabled', true);
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
        success: function(output, textStatus, xhr){
            console.log("jsをwebroot/js/　に移動後、jsの内容変更がブラウザで即時反映されるかどうかを確認してください。");
            console.log(output);
            //console.log(Object.keys(output["Postnumber"]).length);
            console.log(Object.keys(output["error"]).length);
            //console.log(Object.values(output["Postnumber"]));
            //PHP側で、エラーであれば0、成功であれば1を返すようにしてあると仮定										//console.log(result);
            if(!Object.keys(output["error"]).length){
                if(Object.keys(output["Postnumber"]).length == 1){
                //テキストボックスに情報記載
                      $('#PostnumberAddress').val(output["Postnumber"][1]);
                }else{
                //テキストボックスをセレクトボックスに変えて
                  //（１）テキストボックスを消して
                  $('#PostnumberAddress').hide();
                  //（２）セレクトボックスを表示する
                  $("#PostnumberAddress").after('<select class="address"></select>');
                  for (var i=1; i <= Object.keys(output["Postnumber"]).length; i++) {
                                         // コンソールに0〜3の連番を表示
                  //foreach(return["Postnumber"] as $key => $value)
                      $(".address").append('<option value="'+ i + '">' + output["Postnumber"][i] + '</option>');
                  }//for文終わり
                //情報を記載
                }//output["Postnumber"].length終わり
            }else{
                //if(output["error"]["post"]){
                      $('#post_err').text(output["error"]["post"]);
                //}                  //var errorLength = error.length;
            }//if error = 0終わり
        },//success　終わり
        complete: function(xhr, settings){ //AJAX通信完了時に呼ばれる関数です。successやerrorが呼ばれた後に呼び出されるAjax Eventです。
            $('#submit').attr('disabled', false);
        }//complete　終わり
    });//ajax　終わり
});//#submit click終わり
});//先頭文かっこ

