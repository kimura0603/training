<?php

App::uses('App','/Console/Command');

class FigureShell extends AppShell {
    public $uses = array ('Figure');

    public function main(){
      $findAll = $this->Figure->find('all', array(
          'conditions' => array('del_flg' => 0),
          'fields' => array('Figure.id','Figure.user_id','Figure.filename'),
          'order' => array('Figure.id')
      ));
      //$j = 0;
      //$count = count($findAll);
      //$data = array('Figure' => array());
      $arrayId = array();
      foreach($findAll as $value){
            $fileOriginal = file_exists(ROOT."/app/tmp/figures/".$value['Figure']['user_id']."/".$value['Figure']['filename']);
            $fileThumb = file_exists(ROOT."/app/tmp/figures/".$value['Figure']['user_id']."/thumbnails/".$value['Figure']['filename']);
            if(!($fileOriginal && $fileThumb)){
                      $arrayId[] = $value['Figure']['id'];
          }
      }//foreach終わり
      //pr($arrayId);
      if(!($this->Figure->updateAll(
          array('Figure.del_flg' => "1"),
          array('Figure.id' => $arrayId)))){
          return FALSE;
      }//if updateAll終わり
    }//end monitorFileexist

    //コマンド
    //TODO:appの中とlibraryの中との違いは？
    //書き方候補1:http://www.php-mysql-linux.com/cake-php/cron-setting/
      ///usr/bin/php /var/www/html/training/cakephp/lib/Cake/Console/cake.php Figure monitorFileexist
    //候補2:https://nodoame.net/archives/5311
      //後半部の-appは利用するアプリケーションを切り替え時に利用。https://book.cakephp.org/2.0/ja/console-and-shells.html
      ///usr/bin/php /var/www/html/training/cakephp/app/Console/cake.php Figure monitorFileexist -app /var/www/html/training/cakephp/app

}//end Figureshell
