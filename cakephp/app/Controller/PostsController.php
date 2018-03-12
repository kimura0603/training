<?php
#error_reporting(0);

/*
 PostsController ブログ機能の実装
  funciton
    index:ログイン機能
    regsiter:ID/Pass登録
    edit:ID/Pass編集
*/

class PostsController extends AppController {

    public $helpers = array('Html','Form');
    public $components = array('RequestHandler');

    public $paginate = array(
        'limit' => 4,
        'order' => array(
            'Post.id' => 'DESC'
        ),
    );

    public function beforeFilter() {
        parent::beforeFilter();
        //Security::setHash('sha512');
        // 非ログイン時にも実行可能とする
        $this->Auth->allow('index','view','add','contact','test');
        //トークン設定
        //http://rihi.cocolog-nifty.com/blog/2010/07/cakephpsecurity.html
        //$this->Security->validatePost = false;
        //https://www.orenante.com/cakephp2-securitycomponent-%E3%81%A7-%E3%83%81%E3%82%A7%E3%83%83%E3%82%AF%E3%82%92%E5%A4%96%E3%81%97%E3%81%9F%E3%81%84action%E3%81%AE%E6%8C%87%E5%AE%9A/
        $this->Security->unlockedActions = array('index','view','add','contact','test');
    }

    public function test() {
        App::uses('PostAccess','Model');
        $this->PostAccess = new PostAccess;
        $this->render('index');

    }//end function test


    public function logsave() {
        App::uses('PostAccess','Model');
        $this->PostAccess = new PostAccess;
    //ログのセーブ処理
    // $line =  $this->PostAccess->find('first', array('fields' => array('max(PostAccess.id) as max_id')));
    // $line = $line[0]['max_id'];
    // pr($line);
    //
    // $text = file_get_contents('../tmp/logs/access.log');
    // $array = explode(PHP_EOL, trim($text));
    //
    // $start = microtime(true);
    // for($j=0;$j<$line;++$j){
    //     unset($array[$j]);
    //     if (microtime(true) - $start > 5) { break;}
    // }
    //
    // pr($array);
    // $save = array();
    // $i = 0;
    //
    //
    // foreach($array as $value){
    //     $array[$i] = explode('_',substr($value, 28));
    //     $save[$i]['PostAccess']['url'] = $array[$i][0];
    //     $save[$i]['PostAccess']['address'] = $array[$i][1];
    //     $save[$i]['PostAccess']['refer'] = $array[$i][2];
    //     $i += 1;
    // }
    // pr($save);
    // // pr($array);
    // if(!empty($save)){
    //     $this->PostAccess->saveAll($save);
    // }else{
    //     echo 'none log to save';
    // }

    $this->render('index');

}//end function logsave


    public function index() {
        $topPosts = $this->Post->topPost(4);
        $this->set('topPosts', $topPosts);
        // $SALT = 'test';
        // $ip = date("Ymd_") . md5($this::SALT . $_SERVER['REMOTE_ADDR']);
        // $ip = date("Ymd_") . $_SERVER['REMOTE_ADDR'];
        $url = parse_url(Router::reverse($this->request, true))['path'];
            if(!isset($_SERVER['HTTP_REFERER'])){
                $_SERVER['HTTP_REFERER'] = 'unknown';
            }
        // $access = $url . '_' . $_SERVER['REMOTE_ADDR'];
        // $access = $url . '_' . $_SERVER['REMOTE_ADDR'] . '_' . $_SERVER['REMOTE_ADDR'];
        // $access = $url . '_' . $_SERVER['REMOTE_ADDR'] . '_' . $_SERVER['HTTP_REFERER'] . '_' . $date("Ymd_");
        // $access = date("Ymd") . '_' . $url . '_' . $_SERVER['REMOTE_ADDR'] . '_' . $_SERVER['HTTP_REFERER'];
        $access = $url . '_' . $_SERVER['REMOTE_ADDR'] . '_' . $_SERVER['HTTP_REFERER'];
        // pr($access);
        $this->log($access, 'access');

        // pr($_SESSION);
        // pr($date);
        // $logPath = "../tmp/logs/";
        // $file =  $logPath . '_' . $id . '.log';
        //
        // $data = array();
        // $flag = true;
        //
        // $fp = fopen($file, 'a+b');
        // flock($fp, LOCK_EX);
        // for($i=0;$i<100;$i++){
        //     if(feof($fp)) break;
        //     //fgets 行数取得
        //     $line = fgets($fp);
        //     //rtrim 右側削除
        //     if($ip === rtrim($line)){
        //         $flag = false;
        //         break;
        //     } else {
        //         $data[] = $line;
        //     }
        // }
        //
        // if($flag){
        //     //第二引数を最初に加える。
        //     array_unshift($data, $ip . "\n");
        //     ftruncate ($fp, 0);
        //     rewind($fp);
        //     foreach($data as $value){
        //         fwrite($fp, $value);
        //     }
        //
        // $this->adBanner();
        $posts = $this->paginate('Post', array(
               'Post.del_flag' => 0
         ));

        // pr($posts);
        // exit();
        $this->set('posts', $posts);
        if($this->request->is('post')){
            if(isset($this->request->data['contact'])){
                // $this->request->data['PostContact']['name'] = '<a>test';
                App::uses('PostContact','Model');
                $this->PostContact = new PostContact;
                $this->PostContact->create();
                $this->PostContact->set($this->request->data);
                if($this->PostContact->validates()){
                    if($this->PostContact->save()){
                        $saveId = $this->PostContact->getLastInsertID();
                        exec("nohup /usr/bin/php /var/www/html/training/cakephp/lib/Cake/Console/cake.php postcontact $saveId > /dev/null &");
                        $msg = array('result'=>'0','msg'=>array('0'=> '問い合わせ完了しました<br>ありがとうございました'));
                    }else{
                        $msg = array('result'=>'1','msg'=>array('0'=> 'エラー発生しました<br>再度送信してください'));
                    }//end save
                }else{
                    $msg = array('result'=>'1','msg'=>array_column($this->PostContact->validationErrors, 0));
                }//end validation
                $this->set('msg',$msg);
            }//end isset data['contact']
        }//end if post

        $this->layout = '';
    }//end action index

    public function view($id = null){
        $topPosts = $this->Post->topPost(4);
        $this->set('topPosts', $topPosts);
        $url = parse_url(Router::reverse($this->request, true))['path'];
            if(!isset($_SERVER['HTTP_REFERER'])){
                $_SERVER['HTTP_REFERER'] = 'unknown';
            }
        // $access = $url . '_' . $_SERVER['REMOTE_ADDR'];
        // $access = $url . '_' . $_SERVER['REMOTE_ADDR'] . '_' . $_SERVER['REMOTE_ADDR'];
        // $access = $url . '_' . $_SERVER['REMOTE_ADDR'] . '_' . $_SERVER['HTTP_REFERER'] . '_' . $date("Ymd_");
        // $access = date("Ymd") . '_' . $url . '_' . $_SERVER['REMOTE_ADDR'] . '_' . $_SERVER['HTTP_REFERER'];
        $access = $url . '_' . $_SERVER['REMOTE_ADDR'] . '_' . $_SERVER['HTTP_REFERER'];
        // pr($access);
        $this->log($access, 'access');


        if(!$id){
            throw new NotFoundException(__('Invalid post'));
        }
        //記事部分
        $article = $this->Post->findById($id);
        if(!$article){
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('article', $article);
        $this->layout = '';

        //コメント欄表示
        App::uses('PostComment','Model');
        $this->PostComment = new PostComment;
        $commentDisplay = $this->PostComment->commentDisplay($id);
        $this->set('commentDisplay', $commentDisplay);
        // pr($commentDisplay);
        // exit();

        //ブログコメントポスト
        if($this->request->is('post')){
            if(isset($this->request->data['comment'])){
                // $this->request->data['PostContact']['name'] = '<a>test';
                // $this->request->data['params'] = Router::url();
                $this->request->data['params'] = Router::reverse($this->request, true);

                if(!(isset($this->request->data['PostComment']['divname']))){
                    throw new NotFoundException(__('Invalid post'));
                }
                $this->PostComment->set($this->request->data);
                if($this->PostComment->validates()){
                    if($this->PostComment->commentSave($this->request->data)){
                        echo "Save success!";
                        $this->redirect(Router::reverse($this->request,true));
                    }else{
                        echo "Save error!";
                    }//end save
                }else{
                    // $msg = array('result'=>'1','msg'=>array_column($this->PostComment->validationErrors, 0));
                    // $msg = array('result'=>'1','msg'=>array('0'=> 'エラー発生しました<br>再度送信してください'));
                   echo "validation error!";
                }//end validation
                // $this->set('msg',$msg);
            }else{
                  throw new NotFoundException(__('Invalid post'));
            }//end isset data['comment']
        }//end if post
    }//end function view

    public function add(){
        if($this->request->is('post')){
            $this->Post->create();
            if($this->Post->save($this->request->data)){
                $this->Session->setFlash('投稿完了しました。');
                return $this->redirect(array('action'=>'index'));
            }else{
                $this->Session->setFlash('投稿失敗しました。');
            }
        }
    }//end function add

    //記事内からも一覧からも扱えるようにしたい。
    public function edit($id = null){
        if(!$id){
            throw new NotFoundException(__('Invalid post'));
        }
        $post = $this->Post->findById($id);
        if(!$post){
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
        if($this->request->is('post')){
              $this->request->data['Post']['id'] = $id;
              $this->Post->create();
              if($this->Post->save($this->request->data)){
                  $this->Session->setFlash('編集完了しました。');
                  return $this->redirect(array('action'=>'index'));
              }else{
                  $this->Session->setFlash('編集失敗しました。');
            }
        }
    }//end function edit

    public function delete($id = null){
        if(!$id){
            throw new NotFoundException(__('Invalid post'));
        }
        $post = $this->Post->findById($id);
        if(!$post){
            throw new NotFoundException(__('Invalid post'));
        }
        $data = array('Post' => array('id' => $id, 'del_flag' => 1));
              $this->Post->create();
              if($this->Post->save($data, false)){
                  $this->Session->setFlash('削除完了しました。');
                  return $this->redirect(array('action'=>'index'));
              }else{
                  $this->Session->setFlash('削除失敗しました。');
              }
    }//end function delete

    public function adBanner(){
        // public function result($id,$file_id, $status='original') {
        //     $user = $this->Auth->user();
        //     $userId = $this->User->find('first', array(
        //         'conditions' => array('User.username' => $user['username']),
        //         'fields' => array('User.id')
        //     ));
        //     $find = $this->Figure->find('first', array('conditions' => array('Figure.id' => $id, 'Figure.file_id' => $file_id)));
        //     if(empty($find)){
        //         throw new NotFoundException;
        //     }
        //     $filename = $find['Figure']['filename'];
        //     //サムネイル画像を展開@indexファイル
            // if($status == 'thumb'){
                $filePath = "../tmp/ad/funteam.png";
            // }
            // //元画像を展開
            // if($status == 'original'){
            //     $filePath = "../tmp/figures/".$userId['User']['id']."/";
            // }
            // $imgFile = $filePath.$filename;
            $imgFile = $filePath;
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($imgFile);
            header('Content-type:'.$mimeType.'; charset=UTF-8');
            readfile($imgFile);
            // }//fuction result終わり
    }//end function adbanner

}//end PostsController



