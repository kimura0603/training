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

    public function beforeFilter() {
        parent::beforeFilter();
        //Security::setHash('sha512');
        // 非ログイン時にも実行可能とする
        $this->Auth->allow('index','view','add');
        //トークン設定
        //http://rihi.cocolog-nifty.com/blog/2010/07/cakephpsecurity.html
        //$this->Security->validatePost = false;
        //https://www.orenante.com/cakephp2-securitycomponent-%E3%81%A7-%E3%83%81%E3%82%A7%E3%83%83%E3%82%AF%E3%82%92%E5%A4%96%E3%81%97%E3%81%9F%E3%81%84action%E3%81%AE%E6%8C%87%E5%AE%9A/
        $this->Security->unlockedActions = array('index','view','add');
    }

    public function index() {
        $this->set('posts', $this->Post->find('all', array(
            'conditions' => array('Post.del_flag' => '0')
        )));
        $this->layout = '';
    }//end action index

    public function view($id = null){
        if(!$id){
            throw new NotFoundException(__('Invalid post'));
        }
        $post = $this->Post->findById($id);
        if(!$post){
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
    }//end function end

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
              //pr($this->request->data);
              //exit();
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

}//end PostsController



