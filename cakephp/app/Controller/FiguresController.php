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

    public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Figure.id' => 'DESC'
        ),
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('result');
    }

    public function test() {
    }//fuction test終わり

    public function index() {
      $user = $this->Auth->user();
      $this->set('user', $user);
      $figures = $this->paginate('Figure', array(
            'Figure.user_id' => $user['id']
      ));
      //$figures = $this->Figure->find('all', array('conditions' => array('user_id' => $user['id'])));
      $this->set('figures', $figures);
    }//fuction index終わり

    public function upload() {
        //ログイン情報
        if(!$this->Auth->loggedIn()){
            throw new NotFoundException;
        }
        $user = $this->Auth->user();
        $this->set('user', $user);
        //$fileid_list = $this->Figure->Find('all', array('fields' => array('Figure.file_id')));
        //post
        if ($this->request->is('post')) {
            //フォルダ作成。なければ
            App::uses('Folder', 'Utility');
            $dir = new Folder(ROOT."/app/tmp/figures/".$user['id'], true, 0766);
            $dir1 = new Folder(ROOT."/app/tmp/figures/".$user['id']."/thumbnails", true, 0766);
            $this->request->data['Figure']['image']['user_id'] = $this->Auth->user()['id'];
            $this->Figure->set($this->request->data);
            pr($this->request->data);
              //[Figure][image][error]でtmpへのアップロード可否がわかる。
            if(!($this->Figure->validates())){
                $error = array_column($this->Figure->validationErrors, 0);
                $this->set('error', $error);
            //validationで問題なければ、画像の移動とDBへの保存
            }else{
                $fileupload = $this->Figure->fileUpload($this->request->data, $user);
                if($fileupload['success']){
                    $this->Session->setFlash('ファイルアップロード成功しました。一覧ページに移動しました。');
                    $this->redirect('index');
                }else{
                    $this->set('error', $fileupload['error']);
                }//if fileupload終わり
            }//if validate 終わり
        }//if post end
    }//fuction upload終わり

    public function result($id,$file_id, $status='original') {
        if(!$this->Auth->loggedIn()){
            throw new NotFoundException;
        }
        $user = $this->Auth->user();
        $find = $this->Figure->find('first', array('conditions' => array('Figure.id' => $id, 'Figure.file_id' => $file_id)));
        if(empty($find)){
            throw new NotFoundException;
        }
        $filename = $find['Figure']['filename'];

        //サムネイル画像を展開@indexファイル
        if($status == 'thumb'){
            $filePath = "../tmp/figures/".$user['id']."/thumbnails/";
        }
        //元画像を展開
        if($status == 'original'){
            $filePath = "../tmp/figures/".$user['id']."/";
        }
        $imgFile = $filePath.$filename;
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($imgFile);
        header('Content-type: ' . $mimeType . '; charset=UTF-8');
        readfile($imgFile);
    }//fuction result終わり
}


