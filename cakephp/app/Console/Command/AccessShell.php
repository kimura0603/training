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
    public $uses = array ('PostAccess');

    public function main(){


        //行数読み込み
          $line =  $this->find('first', array('fields' => array('max(PostComment.layer_1) as max_layer1'), 'condition' => array('PostComment.post_id' => $data['PostComment']['post_id'])));
        //行数探索
        //配列に落とし込み
        //save

        //}
    }//end funciton main

}//end ProvisionShell

