<?php

  /*
    ProvisionShell php
    目的：
      Userのsignup（新規ユーザー登録）処理の仮登録・メール送付処理
    格納場所：
      /var/www/html/training/cakephp/app/Console/Command/ProvisionShell.php
  */

App::uses('App','/Console/Command');

class ProvisionShell extends AppShell {
    public $uses = array ('Provision');

    //ロジックの構想
    //1.アドレスを受けたらトークンを作成
        //シェルって
    //2.tableにそのアドレス・トークンを記入
    //3.メール送信

    //まとめ
    //exec(第一引数はメールアドレス)

    //残タスク
    //TODO:大：
    //TODO:小：メール改行処理

    public function main(){
        $mailToken = $this->Provision->genRandStr(64);
      /*
      public function genRandStr($length, $charSet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'){
          $retStr = '';
          $randMax =  strlen($charSet) - 1;
          for ($i = 0; $i < $length; ++$i) {
              $retStr .= $charSet[rand(0, $randMax)];
          }
          return $retStr;
      }
        */
        //1.Signup入力後仮登録情報テーブル
        $usernameEmail  = $this->args[0];
        $data = array('Provision' => array(
            'username'=> $usernameEmail,
            'token'=> $mailToken
        ));
        $this->Provision->set($data);
        $this->Provision->save($data);

        //2.メール送付
        //(1)メール送付用URL作成
        $url = "http://test.test/register/".$mailToken;
        //(2)メール送付処理
        App::uses('CakeEmail', 'Network/Email');
        $registEmail = new CakeEmail('gmail2');
        $registEmail->from(array('funteam.kimuratest@gmail.com' => 'KIMURA DEV'));
        $registEmail->to($usernameEmail);
        $registEmail->subject('テストメールタイトルfromGmail');
        $registEmail->send($usernameEmail."様\n\n以下のURLをクリックすることで、登録確認が完了します。\n".$url);
        //if(!($registEmail->send($usernameEmail."様\n\n以下のURLをクリックすることで、登録確認が完了します。\n".$url))){
        //  CakeLog::write('activity', 'エラーログ');
          //$this->log($usernameEmail."様宛メール送信エラー。トークンIDは".$mailToken);//app/tmp/logs/error.logへ
        //}
    }//end funciton main

}//end ProvisionShell

