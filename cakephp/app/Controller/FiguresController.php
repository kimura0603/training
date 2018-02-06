<?php

/*
 FigureController 画像アップロード機能の実装
  funciton
    index:画像アップロード結果一覧
    upload:画像アップロード
    result:選択画像の表示
*/


class FiguresController extends AppController {    //AppControllerを継承して使う

    public $components = array('RequestHandler');
    public $uses = array('Figure');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('result');
    }

    public function test() {
    }//fuction test終わり

    public function index() {
      $user = $this->Auth->user();
      $this->set('user', $user);
      $figures = $this->Figure->find('all', array('conditions' => array('user_id' => $user['id'])));
      //$i = 0;
      $figuresAdd = array();
      //pr($figures);
      //foreach($figures as $figure){
          //if($figure['Figure']['user_id'] == $user['id']){
          //    $accessible = "可";
          //}else{
          //    $accessible = "不可";
          //}
          //$figures += $figure;
          //$figures[$i]['Figure']['accessible'] = '';
          //$figures[$i]['Figure']['accessible'] = $accessible;
          //$i += 1;
      //}
      pr($figures);
      $this->set('figures', $figures);

        if ($this->request->is('get')) {
            pr($this->request->data);
        }//if リンククリック字

    }//fuction index終わり

    public function upload() {
    //post
      //ログイン情報
      $user = $this->Auth->user();
      $this->set('user', $user);
      $fileid_list = $this->Figure->Find('all', array('fields' => array('Figure.file_id')));

    if ($this->request->is('post')) {
      //pr($this->request->data);
      if($this->request->data['Figure']['image']['size'] > 1000000){
          echo '画像サイズが大き過ぎます';
      }else{
          if(move_uploaded_file($this->request->data['Figure']['image']['tmp_name'], ROOT."/app/tmp/figures/".$this->request->data['Figure']['image']['name'])){
            echo "アップロード処理は実行中。適切な場所に保存できたか要チェック";
          }else{
            echo "ファイルアップロードに失敗。やり直してください。";
          }
          $this->request->data['Figure'] = array('user_id' => $user['id'], 'filename' => $this->request->data['Figure']['image']['name'], 'file_id' => $this->genRandStr(6),  'created' => null);
          unset($this->request->data['Figure']['image']);
          //pr($this->request->data);
          $this->Figure->create();
          $this->Figure->set($this->request->data);
          if($this->Figure->save()){
              echo "DBにデータ反映完了";
          }else{
              echo "DBへの反映は失敗。";
          }
      }//if request data終わり
          //$this->redirect('index');
      }//if post
    }//fuction upload終わり

  public function result($id,$file_id) {
        if(!$this->Auth->loggedIn()){
            throw new NotFoundException;
        }
        $user = $this->Auth->user();
        $find = $this->Figure->find('first', array('conditions' => array('Figure.id' => $id, 'Figure.file_id' => $file_id)));
        $filename = $find['Figure']['filename'];
        $user_id = $find['Figure']['user_id'];
          if($user_id != $user['id']){
              throw new NotFoundException;
          }
          $mime_type = "image/jpeg";
          $file_path = "../tmp/figures/";
          //var_dump(file_exists($file_path.$filename));
          //var_dump($file_path.$filename);
          header("Content-Type: image/jpeg");
          readfile($file_path.$filename);
    }//fuction result終わり

}


