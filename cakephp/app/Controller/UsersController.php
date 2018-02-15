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
        $this->Auth->allow('edit','logout','test','register','login','signup');
        //トークン設定
        //http://rihi.cocolog-nifty.com/blog/2010/07/cakephpsecurity.html
        //$this->Security->validatePost = false;
        //https://www.orenante.com/cakephp2-securitycomponent-%E3%81%A7-%E3%83%81%E3%82%A7%E3%83%83%E3%82%AF%E3%82%92%E5%A4%96%E3%81%97%E3%81%9F%E3%81%84action%E3%81%AE%E6%8C%87%E5%AE%9A/
        $this->Security->unlockedActions = array('register','login','top', 'editpass', 'mail','signup');
    }

    public function signup() {
        if ($this->request->is('post')) {
            $this->request->data['User']['username'] = htmlentities($this->request->data['User']['username'], ENT_QUOTES);
            $this->User->set($this->request->data);
            var_dump($this->request->data);
            if($this->User->validates()){
                  if($this->User->save()){
                    $lastid = $this->User->getLastInsertID();
                    $passwordHasher = new BlowfishPasswordHasher();
                    $created = $this->User->find('first',
                        array('conditions' => array('User.id' => $lastid),
                              'fields' => 'User.created'
                    ))['User']['created'];
                    /*
                    $username = $this->User->find('first',
                        array('conditions' => array('User.id' => $lastid),
                              'fields' => 'User.username'
                    )['User']['username'];
                    */
                    App::uses('CakeEmail', 'Network/Email');
                    //大きな流れ
                        //1.Singupページから。アドレス登録。
                        //2.Userコントローラーにuseridを新規割当、アドレスをusernameに、登録時刻のcreateをハッシュに。このURLを送付
                        //3.メール受信者はクリックすると、registerページへ。コントローラーでは、idとハッシュタグからアクセスが妥当かチェック。その後登録処理。
                        //4.登録の処理を終えると、本登録完了メールを送付。
                    //CLEAR:TODO:email.phpの設定。cakephp gmailでぐぐって設定すること。
                        ///var/www/html/training/cakephp/app/Config/email.php
                    //TODO:urlの一部をハッシュ化。そのURLを入手した人のみ登録利用できるように。http://kwski.net/cakephp-2-x/1100/
                      //public function register($id)の第二引数にcreateのキャッシュ値を比較。合致しなければ、404エラーを返す。
                    //TODO:時間制限を設けて、URL漏洩時のリスク低減。時間がすぎれば、del_flgを1にして再登録必要にするとか？
                    //$url = DS.strtolower($this->name).DS.'register'.DS.'50'.DS.$this->User->getActivationHash();// ハッシュ値
                    //$url = "/".strtolower($this->name)."/register/"."50"."/".$this->User->getActivationHash();// ハッシュ値
                    //簡易テスト
                    $url = "/".strtolower($this->name)."/register/".$lastid."/".$passwordHasher->hash($created);
                    $url = Router::url($url, true);  // ドメイン(+サブディレクトリ)を付与
                      //  メール送信
                      //  return
                    //phpのメール関数の起動確認
                    //mail('funteam.kimuratest@gmail.com', 'test mail subject', 'test mail body');
                    $email = new CakeEmail('gmail');

                    //Smtpにすると、SmtpTransport.phpの設定が必要な様子。
                    //./cakephp/lib/Cake/Network/Email/SmtpTransport.php
                    //TODO:この場合届かないよので設定要変更
                    //$email->from('funteam.kimuratest@gmail.com');
                    //$email->to('k_kimura@funteam.co.jp');
                    $email->from(array('funteam.kimuratest@gmail.com' => 'KIMURA DEV'));
                    $email->to($this->request->data['User']['username']);
                    $email->subject('テストメールタイトルfromGmail');
                    //メール送信する
                    //TODO:メール文改行
                    //TODO:このメールのURLに登録アドレス情報を含んでいないといけない。
                    pr($email->send('Kimuraです。以下のURLをクリックすることで、登録確認が完了します。'.$url));
                      echo "入力されたメールアドレスへ本登録の案内メールをお送りしました。30分以内に本登録を完了してください。";
                  }else{
                      echo "エラーが生じました。アドレス入力からやり直してください。";
                  }
            }else{
                $error = array_column($this->User->validationErrors, 0);
                $this->set(error, $error);
            }//if validate
        }//if post
    }// end function signup

    public function mail() {

        App::uses('CakeEmail', 'Network/Email');
        //大きな流れ
            //1.Singupページから。アドレス登録。
            //2.Userコントローラーにuseridを新規割当、アドレスをusernameに、登録時刻のcreateをハッシュに。このURLを送付
            //3.メール受信者はクリックすると、registerページへ。コントローラーでは、idとハッシュタグからアクセスが妥当かチェック。その後登録処理。
            //4.登録の処理を終えると、本登録完了メールを送付。
        //CLEAR:TODO:email.phpの設定。cakephp gmailでぐぐって設定すること。
            ///var/www/html/training/cakephp/app/Config/email.php
        //TODO:urlの一部をハッシュ化。そのURLを入手した人のみ登録利用できるように。http://kwski.net/cakephp-2-x/1100/
          //public function register($id)の第二引数にcreateのキャッシュ値を比較。合致しなければ、404エラーを返す。
        //TODO:時間制限を設けて、URL漏洩時のリスク低減。時間がすぎれば、del_flgを1にして再登録必要にするとか？
        //$url = DS.strtolower($this->name).DS.'register'.DS.'50'.DS.$this->User->getActivationHash();// ハッシュ値
        //$url = "/".strtolower($this->name)."/register/"."50"."/".$this->User->getActivationHash();// ハッシュ値
        //簡易テスト
        $url = "/".strtolower($this->name)."/register/"."52"."/"."19880603";
        $url = Router::url($url, true);  // ドメイン(+サブディレクトリ)を付与
          //  メール送信
          //  return
        //phpのメール関数の起動確認
        //mail('funteam.kimuratest@gmail.com', 'test mail subject', 'test mail body');
        $email = new CakeEmail('gmail');

        //Smtpにすると、SmtpTransport.phpの設定が必要な様子。
        //./cakephp/lib/Cake/Network/Email/SmtpTransport.php
        //TODO:この場合届かないよので設定要変更
        //$email->from('funteam.kimuratest@gmail.com');
        //$email->to('k_kimura@funteam.co.jp');
        $email->from(array('funteam.kimuratest@gmail.com' => 'KIMURA DEV'));
        $email->to('k_kimura@funteam.co.jp');
        $email->subject('テストメールタイトルfromGmail');

        //メール送信する
        //TODO:メール文改行
        //TODO:このメールのURLに登録アドレス情報を含んでいないといけない。
        pr($email->send('Kimuraです。以下のURLをクリックすることで、登録確認が完了します。'.$url));

        $this->render('top');
    }//end function mail

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
    public function register($id,$created) {

        if(isset($id, $created)){
            $identify = $this->User->find('first',
            array('conditions' => array('User.id' => $id),
                'fields' => array('User.username','User.created')
            ));
            $passwordHasher = new BlowfishPasswordHasher();
            if($passwordHasher->check($identify['User']['created'], $created)){
                $this->set('username', $identify['User']['username']);
            }else{
                throw new NotFoundException;
            }
        }
        if ($this->request->is('post')) {
            $uid = $this->User->find('first',
            array('conditions' => array('User.username' => $this->request->data['User']['username']),
                'fields' => array('User.id')
            ));
            $this->request->data['User']['id'] = $uid['User']['id'];
            pr($this->request->data);
            $this->User->set($this->request->data);
            unset($this->User->validate['password']['authEdit']);
            unset($this->User->validate['password']['authLogin']);
            unset($this->User->validate['username']['conflictUsername']);
            if($this->User->validates()){
                if($this->User->updateTransaction($this->request->data)){
                    $this->Session->setFlash('登録完了しました。ログインページへ遷移しました、ログインしてください。');
                    $this->redirect('login');
                    echo "登録完了";
              }else{
                  echo "登録に失敗しました。再度やり直してください";
              }// if save終わり
          }else{
              $error = array_column($this->User->validationErrors, 0);
              $this->set(error, $error);
          }//if validate終わり


            /* フォームから新規登録時の処理　
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
            */
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

