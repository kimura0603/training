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
    public $uses = array('Figure','User');

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

    public function test2() {
    //phpinfo();
    $value = array(
        'Figure' => array(
                       'id' => '46',
                       'user_id' => '23',
                       'filename' => 'スクリーンショット2018-02-0818.59.10.png'
                       //'filename' => 'スクリーンショット 2018-02-08 18.59.10.png'
                        //46 スクリーンショット 2018-02-08 18.59.10.png
                   ));

        //スクリーンショット2018-02-0818.59.10.png
        //スクリーンショット\ 2018-02-08\ 18.59.10.png スクリーンショット2018-02-0818.59.10.png


        //var_dump('"'.ROOT."/app/tmp/figures/23/スクリーンショット 2018-02-08 18.59.10.png".'"');
        $data = array('Figure' => array());
        $j = 0;
        //$fileOriginal = new File(ROOT."/app/tmp/figures/".$value['Figure']['user_id']."/".$value['Figure']['filename']);
        //$fileThumb = new File(ROOT."/app/tmp/figures/".$value['Figure']['user_id']."/thumbnails/".$value['Figure']['filename']);
        $fileOriginal = file_exists(ROOT."/app/tmp/figures/".$value['Figure']['user_id']."/".$value['Figure']['filename']);
        $fileThumb = file_exists(ROOT."/app/tmp/figures/".$value['Figure']['user_id']."/thumbnails/".$value['Figure']['filename']);
        //$fileThumb = new File(ROOT."/app/tmp/figures/".$value['Figure']['user_id']."/thumbnails/".$value['Figure']['filename']);
        //$fileTest = new File('"'.ROOT."/app/tmp/figures/23/スクリーンショット 2018-02-08 18.59.10.png".'"');
        //file_exists(ROOT."/app/tmp/figures/23/スクリーンショット 2018-02-08 18.59.10.png"));
        //$fileTest2 = new File(ROOT."/app/tmp/figures/23/punon pen.jpg");
        var_dump($fileOriginal);
        var_dump($fileThumb);
        var_dump(!($fileOriginal && $fileThumb));
        //var_dump($fileOriginal->exists());
        //var_dump($fileThumb->exists());
        //var_dump($fileTest->exists());
        //var_dump($fileTest2->exists());
        //if(!($fileOriginal->exists())){
        //      if(!($fileThumb->exists())){
             //dlt_flg変更
        //            $data['Figure'][$j] = array('id' => $value['Figure']['id'], 'del_flg' => 1);
        //            $j += 1;
        //  }
        //}
        //pr($data);

      //update figures set del_flg = 1 where id in (4, 6);
        $this->render('upload');

    }

    public function test() {
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
              //if(!($fileOriginal->exists() )){
              //      if(!($fileThumb->exists())){
                        //dlt_flg変更
                        $arrayId[] = $value['Figure']['id'];
                        //$data['Figure'][$j] = array('id' => $value['Figure']['id'], 'del_flg' => 1);
                        //$j += 1;
                //}
            }
        }//foreach終わり
        pr($arrayId);
        if($this->Figure->updateAll(
            array('Figure.del_flg' => "1"),
            array('Figure.id' => $arrayId))){
            echo "success!";
        }else{
            echo "failed!";
        }//if updateAll終わり
        //こういうの再現したい。
        //update figures set del_flg = 1 where id in (4, 6);
        //update figures set del_flg = 1 where id in (4, 6);
          $this->render('upload');
    }//fuction test終わり


    public function index() {
      $user = $this->Auth->user();
      $this->set('user', $user);
      $userId = $this->User->find('first', array(
          'conditions' => array('User.username' => $user['username']),
          'fields' => array('User.id'),
      ));
      //var_dump($userId);
      $figures = $this->paginate('Figure', array(
            'Figure.user_id' => $userId['User']['id'],
            'Figure.del_flg' => 0
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
        $userId = $this->User->find('first', array(
            'conditions' => array('User.username' => $user['username']),
            'fields' => array('User.id')
        ));
        $find = $this->Figure->find('first', array('conditions' => array('Figure.id' => $id, 'Figure.file_id' => $file_id)));
        if(empty($find)){
            throw new NotFoundException;
        }
        $filename = $find['Figure']['filename'];
        //サムネイル画像を展開@indexファイル
        if($status == 'thumb'){
            $filePath = "../tmp/figures/".$userId['User']['id']."/thumbnails/";
        }
        //元画像を展開
        if($status == 'original'){
            $filePath = "../tmp/figures/".$userId['User']['id']."/";
        }
        $imgFile = $filePath.$filename;
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($imgFile);
        header('Content-type:'.$mimeType.'; charset=UTF-8');
        readfile($imgFile);
    }//fuction result終わり
}


