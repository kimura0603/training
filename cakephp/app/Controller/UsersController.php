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

    public $components = array('RequestHandler', 'Session');

    public function test() {
        $data=array(
          'User' => array(
                  'username' => 'kenta',
                  'password' => 'test'
              )
        );
        if($data['User']['username'] && $data['User']['password']){
        //$this->request->data['User']['auth'] = $this->request->data['User']['username'].",".$this->request->data['User']['password'];
        $data['User']['auth'] = $data['User']['username'].",".$data['User']['password'];
        $password = $this->User->find('all',
        array('conditions' => array('User.username' => explode(",", $data['User']['auth'])[0]),
              'fields' => array('User.password'),
            )
        );
        if($password['0']['User']['password'] == explode(",", $data['User']['auth'])[1]){
          echo "match";
        }else{
          echo "mismatch";
        }
        }else{
          echo "どちらかが未入力だよ";
        }
        //$this->set($data);
        pr($data);
        //$this->User->set($data);
        //$this->load->User('user_id');
        //var_dump($this->User->existUsername($data));
        //var_dump($this->User->existUsername($data));
        //var_dump($this->User->validates());
        //$this->setの時点でモデルの名前情報は紐付かれ、Userキーの値の中を読み込む状態になっている。
        //if($this->User->validates()){
        //var_dump("どうなってる？");
        //}else{
        //var_dump($this->User->validationErrors);
        //}
        $this->render('index');
    }//test終わり

    //ログイン処理
    public function index() {
      if ($this->request->is('post')) {
          if($this->request->data['User']['username'] && $this->request->data['User']['password']){
          $this->request->data['User']['auth'] = $this->request->data['User']['username'].",".$this->request->data['User']['password'];
          }
          $this->User->set($this->request->data);
          $this->User->validate = $this->User->validate;
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
            $this->User->set($this->request->data);
            //pr($this->request->data);
            $this->User->validate = $this->User->validate_regist;
            if($this->User->validates()){
                if($this->User->save()){
                    //echo "登録完了しました。ログインページへ遷移します";
                    $this->render('index');
                    echo "登録完了しました。ログインページへ遷移しました";

                }else{
                    echo "登録に失敗しました。再度やり直してください";
                }// if save終わり
            }else{
            //pr($this->User->validationErrors);
                $error = array_column($this->User->validationErrors, 0);
                $this->set(error, $error);
            }//if validate終わり
        }//postif終わり
    }//register終わり

    //パスワード変更処理　認証
    public function edit() {
        if ($this->request->is('post')) {
            if($this->request->data['User']['username'] && $this->request->data['User']['password']){
            $this->request->data['User']['auth'] = $this->request->data['User']['username'].",".$this->request->data['User']['password'];
            }
            $this->User->set($this->request->data);
            $this->User->validate = $this->User->validate;
            if($this->User->validates()){
                //echo "ログイン成功しました！";
                $id = $this->User->findId($this->request->data);
                $userInfo = array('username' => $this->request->data['User']['username'],'id' => $id);
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
          $userInfo = $this->Session->read('userInfo');
          var_dump($userInfo);
        if ($this->request->is('post')) {
            if($this->request->data['User']['password'] && $this->request->data['User']['password2']){
                  $this->request->data['User']['match'] = $this->request->data['User']['password'].",".$this->request->data['User']['password2'];
            }
            $this->User->set($this->request->data);
            $this->User->validate = $this->User->validate_editpass;
            if($this->User->validates()){
                //echo "ログイン成功しました！";
                $renew_data = array(
                    'User' => array(
                            'id' => $userInfo['id'],
                            'password' => $this->request->data['User']['password']
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
