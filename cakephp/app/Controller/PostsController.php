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
        'limit' => 10,
        'order' => array(
            'Post.id' => 'DESC'
        ),
    );

    public function beforeFilter() {
        parent::beforeFilter();
        //Security::setHash('sha512');
        // 非ログイン時にも実行可能とする
        $this->Auth->allow('index','view','add','contact','test','logsave');
        //トークン設定
        //http://rihi.cocolog-nifty.com/blog/2010/07/cakephpsecurity.html
        //$this->Security->validatePost = false;
        //https://www.orenante.com/cakephp2-securitycomponent-%E3%81%A7-%E3%83%81%E3%82%A7%E3%83%83%E3%82%AF%E3%82%92%E5%A4%96%E3%81%97%E3%81%9F%E3%81%84action%E3%81%AE%E6%8C%87%E5%AE%9A/
        $this->Security->unlockedActions = array('index','view','add','contact','test','logsave');
        $topPosts = $this->Post->topPost(4);
        $this->set('topPosts', $topPosts);

        //アクセスログ情報Save
        $this->Post->accesslogSave($this->request->query['search']);
    }

    public function test() {
        $this->render('index');
    }//end function test



    public function index() {
        $posts = $this->paginate('Post', array(
              'Post.del_flag' => 0
        ));
        $this->set('posts', $posts);
        //記事検索
        if(isset($this->request->query['search'])){
            $searchPosts = $this->Post->find('all', array('conditions' => array('Post.del_flag' => 0, 'or' => array('Post.title LIKE' => '%'. h($this->request->query['search']) . '%', 'Post.body LIKE' => '%'. h($this->request->query['search']) . '%'))));
            $this->set('searchPosts', $searchPosts);
            $this->set('posts', '');
        }

        //問い合わせフォーム投稿
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

    public function search() {
        $conditions = $this->Post->stringtoConditions($this->request->query['search']);
        $searchPosts = $this->paginate('Post', $conditions);
        pr($searchPosts);
        $this->set('searchPosts', $searchPosts);
        $this->layout = '';
    }//end action search

    public function view($id = null){

        //recommend機能
        //★ユーザーベース機能

        // //★タグベース機能
        // //(1)特定の記事のレコメンドタグリストアップ
        //   // $id = 1;
        //   $postCategory = $this->Post->find('first', array('conditions' => array('id' => $id), 'fields' => array('category1','category2','category3')));
        //   $postCategory = array_filter(array_values($postCategory['Post']), 'strlen');
        //   // pr($postCategory);
        //   foreach($postCategory as $v){
        //         $sameCategoryposts = $this->Post->find('all', array('conditions' => array('del_flag' => 0, 'id !=' => $id,'or' => array('category1' => $v,'category2' => $v,'category3' => $v)), 'fields' => array('id','title','category1','category2','category3')));
        //         // $sameCategoryposts[] = $this->Post->find('all', array('conditions' => array('id !=' => $id,'or' => array('category1' => $v,'category2' => $v,'category3' => $v)), 'fields' => array('id','title','category1','category2','category3')));
        //         foreach($sameCategoryposts as $v2){
        //                 $array[] = $v2['Post']['id'];
        //         }
        //   }
        //   // pr($array);
        //   $array2 = array_count_values($array);
        //   // pr($array2);
        //   arsort($array2);
        //   // pr($array2);
        //   $arrayKeys = array_keys($array2);
        //   // pr($arrayKeys);
        //   $recommendNum = 3;
        //   for($i=0;$i<$recommendNum;++$i){
        //         $arrayKeys2[$i] = $arrayKeys[$i];
        //   }
        //   // pr($arrayKeys2);
        //   $recommendPosts = $this->Post->find('all', array('conditions' => array('id' => $arrayKeys2, 'del_flag' => 0), 'fields' => array('id','title'),'order' => "FIELD(id, ". implode(',',$arrayKeys2).")"));
        //   // pr($recommendPosts);
          $recommendNum = 3;
          $recommendPosts = $this->Post->recommendPost($id,$recommendNum);
          $this->set('recommendPosts', $recommendPosts);


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
        $filePath = "../tmp/ad/funteam.png";
        $imgFile = $filePath;
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($imgFile);
        header('Content-type:'.$mimeType.'; charset=UTF-8');
        readfile($imgFile);
    }//end function adbanner


    public function getJoins($words) {
        return [
                'fields' => 'id',
                'joins' => [
                    [
                        'type' => 'inner',
                        'table' => 'post_tags',
                        'conditions' => 'Post.id = post_tags.post_id'
                    ],
                    [
                        'type' => 'inner',
                        'table' => 'mst_posttags',
                        'conditions' => 'post_tags.tagname_id = mst_posttags.id'
                    ],
                ],
                'conditions' => ['mst_posttags.tagname LIKE' => '%'. $words . '%']
            ];
    }//end getJoins


    public function tagSearch($test){
          return $test .'added';
    }

}//end PostsController



