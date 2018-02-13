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
        $this->Auth->allow('edit','logout','test','register');
        //トークン設定
        //http://rihi.cocolog-nifty.com/blog/2010/07/cakephpsecurity.html
        //$this->Security->validatePost = false;
        //https://www.orenante.com/cakephp2-securitycomponent-%E3%81%A7-%E3%83%81%E3%82%A7%E3%83%83%E3%82%AF%E3%82%92%E5%A4%96%E3%81%97%E3%81%9F%E3%81%84action%E3%81%AE%E6%8C%87%E5%AE%9A/
        $this->Security->unlockedActions = array('register','login');
    }


    public function top() {
    }//top終わり

    public function login() {

        $user = $this->Auth->user();
        // ビューに渡す
        if($user){
        $this->set('user', $user);
        }
        // 中に入っている配列を確認（必要なければ消してください。）
        var_dump($user);
        //pr($this->Session);
      if(!isset($user)){
      if ($this->request->is('post')) {
          // Important: Use login() without arguments! See warning below.
          $this->request->data['User']['username'] = htmlentities($this->request->data['User']['username'], ENT_QUOTES);
          $this->request->data['User']['password'] = htmlentities($this->request->data['User']['password'], ENT_QUOTES);
          //if($this->request->data['User']['username'] && $this->request->data['User']['password']){
          //$this->request->data['User']['auth'] = $this->request->data['User']['username'].",".Security::hash($this->request->data['User']['password'], 'sha512', true);
          //}
          $this->User->set($this->request->data);
          unset($this->User->validate['username']['rule-2']);
          unset($this->User->validate['auth']['rule-2']);
          if($this->User->validates()){
              //echo "ログイン成功しました！";
            if ($this->Auth->login()) {
                  $this->redirect($this->Auth->redirectUrl());
            }else{
                var_dump("ログイン処理失敗");
              //pr($this->Auth);
            }
          }else{
              $error = array_column($this->User->validationErrors, 0);
              $this->set(error, $error);
              var_dump("バリデーション失敗");
          }//if validate
      }//if post
    }else{
      $this->redirect($this->Auth->redirectUrl());
    }//if isset($user);
  }//end login controller

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    //ログイン処理
    public function index() {
      //pr($this->Session);
      if ($this->request->is('post')) {
          $this->request->data['User']['username'] = htmlentities($this->request->data['User']['username'], ENT_QUOTES);
          $this->request->data['User']['password'] = htmlentities($this->request->data['User']['password'], ENT_QUOTES);
          if($this->request->data['User']['username'] && $this->request->data['User']['password']){
          $this->request->data['User']['auth'] = $this->request->data['User']['username'].",".Security::hash($this->request->data['User']['password'], 'sha512', true);
          }
          //pr(Security::hash($this->request->data['User']['password'], 'sha512', true));
          //pr('568df90f47811a502ab8f2a1bf92c215b16b707761878e6f3c02b7ec99239416c34f421c9d122a14d257010c39f5cba76e605ede1b9d5e682e7225a69f2ee08d');
          //pr($this->request->data);
          $this->User->set($this->request->data);
          unset($this->User->validate['username']['rule-2']);
          //pr($this->User->validate);
          if($this->User->validates()){
              echo "ログイン成功しました！";
              //$this->render('postnumbers/index');
          }else{
              //pr($this->User->validationErrors);
              $error = array_column($this->User->validationErrors, 0);
              $this->set(error, $error);
          }//if validation終わり
      }//postif終わり
    }//index終わり

    //登録処理
    public function register() {
        if ($this->request->is('post')) {
            if($this->request->data['User']['password'] && $this->request->data['User']['password2']){
                $this->request->data['User']['match'] = $this->request->data['User']['password'].",".$this->request->data['User']['password2'];
            }
            $this->User->set($this->request->data);
            //var_dump($this->request->data);
            //pr($this->request->data);
            if($this->User->validates()){
                if($this->User->saveTransaction($this->request->data)){
                    $this->render('index');
                    echo "登録完了しました。ログインページへ遷移しました";

                }else{
                    echo "登録に失敗しました。再度やり直してください";
                }// if save終わり
            }else{
                $error = array_column($this->User->validationErrors, 0);
                $this->set(error, $error);
            }//if validate終わり
        }//postif終わり
    }//register終わり

    //パスワード変更処理　認証
    public function edit() {
        if ($this->request->is('post')) {
            if($this->request->data['User']['username'] && $this->request->data['User']['password']){
            $this->request->data['User']['auth'] = $this->request->data['User']['username'].",".Security::hash($this->request->data['User']['password'], 'sha512', true);
            }
            $this->User->set($this->request->data);
            unset($this->User->validate['username']['rule-2']);
            pr($this->User->validate);
            if($this->User->validates()){
                //echo "ログイン成功しました！";
                $id = $this->User->findId($this->request->data);
                $userInfo = array('username' => $this->request->data['User']['username'], 'password' => $this->request->data['User']['password'], 'id' => $id);
                $this->Session->write('userInfo', $userInfo);
                pr($this->request->data);
                var_dump($userInfo);
                $this->redirect('editpass');
            }else{
                //pr($this->User->validationErrors);
                $error = array_column($this->User->validationErrors, 0);
                $this->set(error, $error);
            }//if validation終わり
        }//postif終わり
    }//edit終わり

    //パスワード変更処理　変更登録
    public function editpass() {

          $user = $this->Auth->user();
          //pr($user['username']);
          // ビューに渡す
          $this->set('user', $user);
          //$userInfo = $this->Session->read('userInfo');
          //var_dump($userInfo);
        if ($this->request->is('post')) {
            $this->request->data['User']['auth'] = $user['username'].",".Security::hash($this->request->data['User']['password'], 'sha512', true);
            if($this->request->data['User']['newpassword1'] && $this->request->data['User']['newpassword2']){
                  $this->request->data['User']['match'] = $this->request->data['User']['newpassword1'].",".$this->request->data['User']['newpassword2'];
            $this->request->data['User']['samepass'] = $this->request->data['User']['password'].",".$this->request->data['User']['newpassword1'];
            }
            $this->User->set($this->request->data);
            unset($this->User->validate['auth']['rule-1']);
            if($this->User->validates()){
                //echo "ログイン成功しました！";
                $renew_data = array(
                    'User' => array(
                            'id' => $user['id'],
                            'password' => Security::hash($this->request->data['User']['newpassword1'], 'sha512', true),
                            'modified' => null
                        )
                );
                $this->User->set($renew_data);
                if($this->User->save()){
                    //echo "登録完了しました。ログインページへ遷移します";
                    //echo "パスワード変更完了しました。ログインページへ遷移します";
                    $this->Session->setFlash('パスワード変更完了しました。ログインページへ遷移しました');
                    $this->redirect('index');
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

