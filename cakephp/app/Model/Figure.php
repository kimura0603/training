<?php

App::uses('AppModel', 'Model');

class Figure extends AppModel {
  public $name = 'Figure';

   public $validate = array(
       'image' => array(
           // ルール：uploadError => errorを検証 (2.2 以降)
           //errorの返り値詳細http://php.net/manual/ja/features.file-upload.errors.php
           'upload-file' => array(
               'rule' => array( 'uploadError'),
               'message' => array( 'ファイルアップロードで障害が起こりました。再度やり直してください。')
           ),

           // ルール：extension => pathinfoを使用して拡張子を検証
           'extension' => array(
               'rule' => array( 'extension', array(
                   'jpg', 'jpeg', 'png', 'gif')  // 拡張子を配列で定義
               ),
               'message' => array( '有効な画像ファイルを指定してくださいね。')
           ),

           // ルール：mimeType =>
           // finfo_file(もしくは、mime_content_type)でファイルのmimeを検証 (2.2 以降)
           // 2.5 以降 - MIMEタイプを正規表現(文字列)で設定可能に
           'mimetype' => array(
               'rule' => array( 'mimeType', array(
                   'image/jpeg', 'image/png', 'image/gif')  // MIMEタイプを配列で定義
               ),
               'message' => array( 'MIME type error')
           ),

           // ルール：fileSize => filesizeでファイルサイズを検証(2GBまで)  (2.3 以降)
           'size' => array(
               'maxFileSize' => array(
                   'rule' => array( 'fileSize', '<=', '1MB'),  // 10M以下
                   'message' => array( '画像サイズが大きすぎます。1MB 未満でなければなりません')
               ),
               'minFileSize' => array(
                   'rule' => array( 'fileSize', '>',  0),    // 0バイトより大
                   'message' => array( '画像サイズエラー。小さすぎます。画像ファイルですか？')
               )
            ),
            'samefilename' => array(
                       'rule' => array('sameFilename'),  // 10M以下
                       'message' => array('同じファイル名の画像はアップロードできません。やり直してください。')
            )
        )
    );//validate end

    public function sameFilename($data){
       //idで登録したpasswordといれて、それがないかどうか。
       $conditions = array('user_id'=>$data['image']['user']['id'], 'filename'=>$data['image']['name']);
       if($this->hasAny($conditions)){
         //trueなら同じファイル名が存在するということなのでなのでfalseを返す。
         return FALSE;
       }
    }//sameFilename end
}
