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
      phpinfo();
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
            //フォルダ作成。なければ
            App::uses('Folder', 'Utility');
            $dir = new Folder(ROOT."/app/tmp/figures/".$user['id'], true, 0766);
            $this->request->data['Figure']['image']['user_id'] = $this->Auth->user()['id'];
            $this->Figure->set($this->request->data);
            if(!($this->Figure->validates())){
                $error = array_column($this->Figure->validationErrors, 0);
                $this->set('error', $error);
            //validationで問題なければ、画像の移動とDBへの保存をtry&catchとtransactionで開始
            }else{
                $datasource = $this->Figure->getDataSource();
                try {
                    $datasource->begin();
                    //ファイルが画像かどうかジャッジ
                    $image = new Imagick($this->request->data['Figure']['image']['tmp_name']);
                    if($image->coalesceImages()){
                        $image = $image->coalesceImages();
                        $image->writeImages(ROOT."/app/tmp/figures/".$user['id']."/".$this->request->data['Figure']['image']['name'], true);
                    }else{
                        throw new Exception("ファイル複製失敗。画像ファイルでない可能性あり。");
                    }
                    //DB保存処理
                    $this->request->data['Figure']['image']['filename'] = $this->request->data['Figure']['image']['name'];
                    $this->request->data['Figure']['image']['file_id'] = $this->genRandStr(6);
                    $this->request->data['Figure']['image']['created'] = null;
                    $this->request->data['Figure'] = $this->request->data['Figure']['image'];
                    $this->Figure->create();
                    if(!($this->Figure->save($this->request->data,false))){
                        throw new Exception("DB保存エラー");
                    }
                    $datasource->commit();
                $this->Session->setFlash('ファイルアップロード成功しました。一覧ページに移動しました。');
                $this->redirect('index');
                }catch(Exception $e){
                    $datasource->rollback();
                    echo $e->getMessage();
                    $error = array(0 => "ファイルアップロードに失敗しました。やり直してください。");
                    $this->set('error', $error);
                }//try&catch終わり
            }//if validate 終わり
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
        $filename1 = 'punonpen.jpg';
        $filename2 = 'hayakawa_top2.jpeg';
        $filePath = '../tmp/figures/';
        $imgFile1 = $filePath.$filename1;
        $imgFile2 = $filePath.$filename2;
        $background = new Imagick($imgFile1); //背景
        $watermark = new Imagick($imgFile2); //透かし
        $wm_sx = 250; //透かし画像の幅
        $wm_sy = 250; //透かし画像の高さ
        $watermark->sampleImage($wm_sx, $wm_sy);
        $background->compositeImage($watermark, Imagick::COMPOSITE_SOFTLIGHT,
            ($background->getImageWidth() - $wm_sx) / 2, ($background->getImageHeight() - $wm_sy) / 2);
        //$finfo = new finfo(FILEINFO_MIME_TYPE);
        //$mimeType = $finfo->file($imgFile);
        //image/jpeg
        //header('Content-type: ' . $mimeType);
        //header('Content-type: image/jpeg; charset=UTF-8');
        header('Content-type: image/jpeg; charset=UTF-8');
        //header('Content-type: ' . $mimeType . '; charset=UTF-8');
        echo($background);
    }//fuction result終わり

}


