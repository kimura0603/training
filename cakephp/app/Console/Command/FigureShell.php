<?php

App::uses('App','/Console/Command');

class FigureShell extends AppShell {
    public $uses = array ('Figure');

    public function main(){
      $findAll = $this->Figure->find('all', array(
          'conditions' => array('del_flag' => 0),
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
          array('Figure.del_flag' => "1"),
          array('Figure.id' => $arrayId)))){
          return FALSE;
      }//if updateAll終わり
    }//end monitorFileexist

}//end Figureshell
