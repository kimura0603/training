<?php

  /*
    PostcontactShell php
    目的：
      Postのindex（新規ユーザー登録）の問い合わせパートの問い合わせ完了メール送信処理。
    格納場所：
      /var/www/html/training/cakephp/app/Console/Command/PassreissueShell.php
  */

App::uses('App','/Console/Command');

class PostcontactShell extends AppShell {
    public $uses = array ('PostContact');

    public function main(){
        $saveId = $this->args[0];
        App::uses('PostContact','Model');
        $this->PostContact = new PostContact;
        $postRecord = $this->PostContact->find('first', array(
            'conditions' => array('PostContact.id' => $saveId)
        ));
        //テンプレート送付する変数
        $ary_vars = $postRecord['PostContact'];
        App::uses('CakeEmail', 'Network/Email');
        $postcontactEmail = new CakeEmail('gmail2');
        $postcontactEmail->from(array('funteam.kimuratest@gmail.com' => 'KIMURA DEV'));
        $postcontactEmail->to($postRecord['PostContact']['email']);
        $postcontactEmail->emailFormat('text');
        $postcontactEmail->subject('お問い合わせ完了のお知らせ');
        $postcontactEmail->viewVars($ary_vars);
        // $postcontactEmail->template('postcontact',);
        $postcontactEmail->template('postcontact','my_layout');
        $postcontactEmail->send('hogehoge');
    }//end funciton main

}//end PassreissueShell

