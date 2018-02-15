<?php
#error_reporting(0);

/*
 LoginsController ログイン機能の実装
  funciton
    index:ログイン機能
    regsiter:ID/Pass登録
    edit:ID/Pass編集

    pr($this->request->data);
    Array
    (
        [User] => Array
            (
                [username] => 12345
                [password] => test
            )

    )
*/


class UsersController extends AppController {    //AppControllerを継承して使う

    public $components = array('RequestHandler');
    public $uses = array('User');

    public function beforeFilter() {
        parent::beforeFilter();
        //Security::setHash('sha512');
        // 非ログイン時にも実行可能とする
        $this->Auth->allow('edit','logout','test','register','login');
        //トークン設定
        //http://rihi.cocolog-nifty.com/blog/2010/07/cakephpsecurity.html
        //$this->Security->validatePost = false;
        //https://www.orenante.com/cakephp2-securitycomponent-%E3%81%A7-%E3%83%81%E3%82%A7%E3%83%83%E3%82%AF%E3%82%92%E5%A4%96%E3%81%97%E3%81%9F%E3%81%84action%E3%81%AE%E6%8C%87%E5%AE%9A/
        $this->Security->unlockedActions = array('register','login','top', 'editpass');
    }

    public function top() {
      if(!$this->Auth->loggedIn()){
          throw new NotFoundException;
      }
      $user = $this->Auth->user();
      $this->set('user', $user);
    }//top終わり

    public function login() {

        $user = $this->Auth->user();
        // ビューに渡す
        if($user){
            var_dump('ログインユーザー名:'.$user);
        $this->set('user', $user);
        }else{
            echo('ログインしていません');
        }
        // 中に入っている配列を確認（必要なければ消してください。）
        //pr($this->Session);
      if(!isset($user)){
          if ($this->request->is('post')) {
              // Important: Use login() without arguments! See warning below.
              $this->request->data['User']['username'] = htmlentities($this->request->data['User']['username'], ENT_QUOTES);
              $this->request->data['User']['password'] = htmlentities($this->request->data['User']['password'], ENT_QUOTES);
              $this->User->set($this->request->data);
              unset($this->User->validate['username']['conflictUsername']);
              unset($this->User->validate['password']['authEdit']);
              if($this->User->validates()){
                    $this->Auth->login($this->request->data['User']);
                    $this->Session->setFlash('ログイン成功。トップページへ遷移しました');
                    $this->redirect($this->Auth->redirectUrl());
              }else{
                  $error = array_column($this->User->validationErrors, 0);
                  $this->set(error, $error);
              }//if validate
        }//if post
    }else{
            $this->redirect($this->Auth->redirectUrl());
    }//if isset($user);
  }//end login controller

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function index() {
    }//index終わり

    //登録処理
    public function register() {
        if ($this->request->is('post')) {
            $this->User->set($this->request->data);
            unset($this->User->validate['password']['authEdit']);
            unset($this->User->validate['password']['authLogin']);
            if($this->User->validates()){
                if($this->User->saveTransaction($this->request->data)){
                  $this->Session->setFlash('登録完了しました。ログインページへ遷移しました、ログインしてください。');
                  $this->redirect('login');
                }else{
                    echo "登録に失敗しました。再度やり直してください";
                }// if save終わり
            }else{
                $error = array_column($this->User->validationErrors, 0);
                $this->set(error, $error);
            }//if validate終わり
        }//postif終わり
    }//register終わり

    //パスワード変更処理　変更登録
    public function editpass() {
        if(!$this->Auth->loggedIn()){
            throw new NotFoundException;
        }
        $user = $this->Auth->user();
        $this->set('user', $user);
        //var_dump($userInfo);
        if ($this->request->is('post')) {
            $this->request->data['User']['username'] = $user;
            $this->User->set($this->request->data);
            unset($this->User->validate['username']);
            unset($this->User->validate['password']['authLogin']);
            if($this->User->validates()){
                //echo "ログイン成功しました！";
                $renew_data = array(
                    'User' => array(
                            'id' => $this->User->findId($user['username']),
                            'username' => $user['username'],
                            'password' => $this->request->data['User']['newpassword1'],
                            'modified' => null
                    )
                );
                $this->User->set($renew_data);
                if($this->User->save($renew_data['User'], false)){
                    //echo "登録完了しました。ログインページへ遷移します";
                    //echo "パスワード変更完了しました。ログインページへ遷移します";
                    $this->Session->setFlash('パスワード変更完了しました。ログインページへ遷移しました');
                    $this->redirect('login');
                }else{
                    echo "パスワード変更に失敗しました。再度やり直してください";
                }// if save終わり
            }else{
                //pr($this->User->validationErrors);
                $error = array_column($this->User->validationErrors, 0);
                $this->set(error, $error);
            }//if validation終わり
        }//postif終わり
    }//editpass終わり

}

