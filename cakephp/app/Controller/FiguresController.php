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
      if(!$this->Auth->loggedIn()){
          throw new NotFoundException;
      }
      $user = $this->Auth->user();
      $this->set('user', $user);
      App::uses('Folder', 'Utility');
      $dir = new Folder(ROOT."/app/tmp/figures/".$user['id'], true, 0766);
      //$hogehoge = is_writable(ROOT."/app/tmp/figures/");
      //var_dump($hogehoge);
      $this->render('upload');
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
      $this->set('figures', $figures);
    }//fuction index終わり

    public function upload() {
      //ログイン情報
      if(!$this->Auth->loggedIn()){
        throw new NotFoundException;
      }
      $user = $this->Auth->user();
      $this->set('user', $user);
      $fileid_list = $this->Figure->Find('all', array('fields' => array('Figure.file_id')));
      //post
    if ($this->request->is('post')) {
      //pr($this->request->data);
          //フォルダ作成。なければ
          App::uses('Folder', 'Utility');
          $dir = new Folder(ROOT."/app/tmp/figures/".$user['id'], true, 0766);
          //
          $datasource = $this->Figure->getDataSource();
          try {
              $this->request->data['Figure']['image']['user'] = $this->Auth->user();
              $this->Figure->set($this->request->data);
              pr($this->request->data);
              //バリデーションチェック
          //    if(!($this->Figure->validates())){
          //        $error = array_column($this->Figure->validationErrors, 0);
          //        pr($this->Figure->validationErrors);
          //        pr($error);
          //        $this->set('error', $error);
          //        throw new Exception("バリデーションに失敗しました。再度アップロードしてください！！");
          //    }//if validate終わり
              //一時アップロードファイルの移動
              $datasource->begin();
              if(!(move_uploaded_file($this->request->data['Figure']['image']['tmp_name'], ROOT."/app/tmp/figures/".$user['id']."/".$this->request->data['Figure']['image']['name']))){
                  $error = array(0 => "バリデーションはOK。アップロード後のファイル移動に失敗。アップロードからやり直してください。");
                  $this->set('error', $error);
                  throw new Exception("ファイル移動処理失敗やりなおしてください！！");
              }//if move_upload_file終わり
              //DB保存処理
              $this->request->data['Figure'] = array('user_id' => $user['id'], 'filename' => $this->request->data['Figure']['image']['name'], 'file_id' => $this->genRandStr(6),  'created' => null);
              unset($this->request->data['Figure']['image']);
              //pr($this->request->data);
              $this->Figure->create();
              $this->Figure->set($this->request->data);
              if(!($this->Figure->save())){
                $error = array(0 => "バリデーションはOK。アップロード後のファイル情報のDB保存に失敗。アップロードからやり直してください");
                $this->set('error', $error);
                throw new Exception("ファイル移動処理失敗やりなおしてください！！");
              }
              $datasource->commit();
          } catch (\Exception $e) {
            $datasource->rollback();
            //$error = array_column($error_msg, 0);
            pr($error);
            //$this->set('error', $error);
          }//try&catch終わり
      }//if post end
    }//fuction upload終わり

    public function result($id,$file_id) {
        if(!$this->Auth->loggedIn()){
            throw new NotFoundException;
        }
        $user = $this->Auth->user();
        $find = $this->Figure->find('first', array('conditions' => array('Figure.id' => $id, 'Figure.file_id' => $file_id)));
        $filename = $find['Figure']['filename'];
        //pr($filename);
        $user_id = $find['Figure']['user_id'];
          if($user_id != $user['id']){
              throw new NotFoundException;
          }
        $filePath = "../tmp/figures/".$user_id."/";
        $imgFile = $filePath.$filename;
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($imgFile);
        //image/jpeg
        //header('Content-type: ' . $mimeType);
        header('Content-type: ' . $mimeType . '; charset=UTF-8');
        readfile($imgFile);
    }//fuction result終わり

    public function result2() {
        $filename = 'hayakawa_top2.jpeg';
        $filePath = '../tmp/figures/';
        $imgFile = $filePath.$filename;
        //$finfo = new finfo(FILEINFO_MIME_TYPE);
        //$mimeType = $finfo->file($imgFile);
        //image/jpeg
        //header('Content-type: ' . $mimeType);
        //header('Content-type: image/jpeg; charset=UTF-8');
        header('Content-type: image/jpeg; charset=UTF-8');
        //header('Content-type: ' . $mimeType . '; charset=UTF-8');
        readfile($imgFile);
    }//fuction result終わり

}


