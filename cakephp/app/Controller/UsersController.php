<?php
#error_reporting(0);

/*
 LoginsController ログイン機能の実装
  funciton
    index:ログイン機能
    regsiter:ID/Pass登録
    edit:ID/Pass編集
*/

class UsersController extends AppController {

    public $components = array('RequestHandler');
    public $uses = array('User','Provision','Passreissue','PassreissueUnique');

    public function beforeFilter() {
        parent::beforeFilter();
        //Security::setHash('sha512');
        // 非ログイン時にも実行可能とする
        $this->Auth->allow('edit','logout','test','register','login','signup','signupfinish','unique','unique2nd','urlissue','passreissue','passreissuefinish','forgetpasswordregister','bootstrap','index');
        //トークン設定
        //http://rihi.cocolog-nifty.com/blog/2010/07/cakephpsecurity.html
        //$this->Security->validatePost = false;
        //https://www.orenante.com/cakephp2-securitycomponent-%E3%81%A7-%E3%83%81%E3%82%A7%E3%83%83%E3%82%AF%E3%82%92%E5%A4%96%E3%81%97%E3%81%9F%E3%81%84action%E3%81%AE%E6%8C%87%E5%AE%9A/
        $this->Security->unlockedActions = array('register','login','top', 'editpass', 'mail','signup','test','unique','unique2nd','urlissue','passreissue','passreissuefinish','forgetpasswordregister','bootstrap','index');
    }

    public function index() {
    }//end action index

    public function bootstrap() {
    }//end action bootstrap


    public function urlissue() {

      $selectModel = array(1 => '初回登録用URLToken', 2 => 'パスワード変更用URLToken');
      $this->set('selectModel', $selectModel);

        if ($this->request->is('post')) {
            pr($this->request->data);
            if(($this->request->data['User']['model']) == 1){
                $model = 'Provision';
            }elseif(($this->request->data['User']['model']) == 2){
                $model = 'Passreissue';
            }
            //pr($model);
            $this->User->uniquetokenIssue($model);
        }//end if post
        //$this->render('top');
    }//end urlissue



    public function signup() {
        if ($this->request->is('post')) {
            $this->request->data['User']['username'] = htmlentities($this->request->data['User']['username'], ENT_QUOTES);
            $this->User->set($this->request->data);
            unset($this->User->validate['username']['matchIdandbrith']);
            if($this->User->validates()){
                $userEmail = $this->request->data['User']['username'];
                exec("nohup /usr/bin/php /var/www/html/training/cakephp/lib/Cake/Console/cake.php provision $userEmail > /dev/null &");
                $this->redirect(array('action' => 'signupfinish'));
            }else{
                $error = array_column($this->User->validationErrors, 0);
                $this->set(error, $error);
            }//end if validate
        }//if post
    }// end function signup


    public function signupfinish() {
    }

    public function top() {
      pr($_COOKIE);
      if(!$this->Auth->loggedIn()){
          throw new NotFoundException;
      }
      $user = $this->Auth->user();
      $this->set('user', $user);
    }//top終わり


    public function login() {
        $user = $this->Auth->user();
        /*--------------------------------------------------
        オートログイン処理
        --------------------------------------------------*/
        if (!(empty($_COOKIE['auto_login']))){//空の場合はクッキー保存していないユーザーとしてオートログインを飛ばす。
            if (isset($_COOKIE['auto_login']) && !is_array($_COOKIE['auto_login']) && strlen($_COOKIE['auto_login'])){
                $auto_login_key = $_COOKIE['auto_login'];
                $auto_login_key1 = substr($auto_login_key, 0, 64);
                $auto_login_key2 = substr($auto_login_key, 64, 33);
                App::uses('UserAutologin','Model');
                $this->UserAutologin = new UserAutologin;
                $auth_key = $this->UserAutologin->find('first',
                  array('conditions' => array('UserAutologin.auto_login_key1' => $auto_login_key1),
                      'fields' => array('UserAutologin.username','UserAutologin.auto_login_key2')
                ));
                //cookieによる認証
                App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
                $passwordHasher = new BlowfishPasswordHasher();
                if($passwordHasher->check($auto_login_key2, $auth_key['UserAutologin']['auto_login_key2'])){
                    if($this->User->hasAny(array('username' => $auth_key['UserAutologin']['username']))){
                        $this->delete_auto_login($auto_login_key, TRUE);
                        $this->setup_auto_login($auth_key['UserAutologin']['username']);
                        $this->Auth->login($auth_key['UserAutologin']['username']);
                        $this->Session->setFlash('自動ログインしました。トップページへ遷移しました');
                        $this->redirect($this->Auth->redirectUrl());
                    }else{
                        $this->delete_auto_login($auto_login_key, FALSE);
                        throw new ForbiddenException;
                    }
                //}else{
                    $this->delete_auto_login($auto_login_key, FALSE);
                    throw new ForbiddenException;
                }//end if count()$auth_key)
            }else{
            //空じゃないけど、中身が不適切なとき。
                throw new NotFoundException;
            }
        //if elseの場合は何もしない。
        }//end オートログイン処理 if empty
          //手動ログイン処理
          if ($this->request->is('post')) {
              $this->request->data['User']['username'] = htmlentities($this->request->data['User']['username'], ENT_QUOTES);
              $this->request->data['User']['password'] = htmlentities($this->request->data['User']['password'], ENT_QUOTES);
              //$this->request->data['User']['auto_login'] = 1
              pr($this->request->data);
              pr($_COOKIE);
              var_dump($_SERVER);

              // Important: Use login() without arguments! See warning below.
              $this->User->set($this->request->data);
              unset($this->User->validate['username']['conflictUsername']);
              unset($this->User->validate['password']['authEdit']);
              unset($this->User->validate['username']['email']);
              unset($this->User->validate['username']['matchIdandbrith']);
              if($this->User->validates()){
                    /*--------------------------------------------------
                    手動ログイン時
                    --------------------------------------------------*/
                    if(!empty($_COOKIE['auto_login'])){
                        $this->delete_auto_login($_COOKIE['auto_login'],FALSE);
                    }
                    if($this->request->data['User']['auto_login'] == 1){
                        $this->setup_auto_login($this->request->data['User']['username']);
                    }
                    $this->Auth->login($this->request->data['User']);
                    $this->Session->setFlash('ログイン成功。トップページへ遷移しました');
                    $this->redirect($this->Auth->redirectUrl());
              }else{
                  $error = array_column($this->User->validationErrors, 0);
                  $this->set(error, $error);
              }//if validate
        }//if post
    //}//if isset($user);
  }//end login controller

    public function logout() {
        if (!empty($_COOKIE['auto_login'])){
            //クッキーのDBに存在する、アカウントも存在するクッキーデータなら。$existAccount = TRUE,
            $existAccount = TRUE;
            $this->delete_auto_login($_COOKIE['auto_login'], $existAccount);
        }
        $this->Session->setFlash('ログアウト完了！');
        $this->redirect($this->Auth->logout());
        }

    public function passreissue() {
      if ($this->request->is('post')) {
          $this->User->set($this->request->data);
          unset($this->User->validate['username']['conflictUsername']);
          unset($this->User->validate['birth']);
          if($this->User->validates()){
              $userEmail = $this->request->data['User']['username'];
              exec("nohup /usr/bin/php /var/www/html/training/cakephp/lib/Cake/Console/cake.php passreissue $userEmail > /dev/null &");
              $this->redirect(array('action' => 'passreissuefinish'));
          }else{
              $error = array_column($this->User->validationErrors, 0);
              $this->set(error, $error);
          }//end if validate
      }//if post

    }//passreissue終わり



    public function passreissuefinish() {
    }//end action passreissuefinish


    //password再登録処理
    public function forgetpasswordregister() {
        $token = $this->request->query('token');
        $token1 = substr($token, 0, 64);
        $token2 = substr($token, 64, 64);
        $this->set('token', $token);
        try{
            //1.URLValidation start provision_uniqueテーブルから
            App::uses('PassreissueUnique','Model');
            $this->PassreissueUnique = new PassreissueUnique;
            if(isset($token1)){
                $identifyPassreissueUni = $this->PassreissueUnique->find('first',
                array('conditions' => array('PassreissueUnique.unique_token1' => $token1),
                    'fields' => array('PassreissueUnique.id','PassreissueUnique.created')
                ));
            }else{
                    $errMsg = "URL is none & not correct";
                    throw new Exception($errMsg);
            }
            if(count($identifyPassreissueUni) != 1){
                $errMsg = "No url match with DB";
                throw new Exception($errMsg);
            }
            //2.URLValidation start Passreissueテーブルから
            App::uses('Passreissue','Model');
            $this->Passreissue = new Passreissue;
            $identifyPassreissue = $this->Passreissue->find('first',
            array('conditions' => array('Passreissue.id' => $identifyPassreissueUni['PassreissueUnique']['id'], 'Passreissue.del_flag' => 0),
                'fields' => array('Passreissue.username','Passreissue.token','Passreissue.created')
            ));
            //2-1:データ有無確認
            if(count($identifyPassreissue) != 1){
                $errMsg = "No url match with DB or was deleted";
                throw new Exception($errMsg);
            }
            //2-1:有効期限確認
            //$created1 = $identifyPassreissue['Passreissue']['created'];
            $created = strtotime($identifyPassreissue['Passreissue']['created']);
            $now = time();
            $passedTimemin = ($now - $created)/60;
            if($passedTimemin > 30){
                $errMsg = "Time for registration expired";
                //$errMsg = "Time for registration expired"."登録時間1：".$creted1."登録時間2：".$created."現在時刻：".$now."経過時間：".$passedTimemin;
                throw new Exception($errMsg);
            }
            //2-3:同ユーザーURL最新是非確認
            $sameuserMaxid = $this->Passreissue->find('first', array(
                  'conditions' => array('Passreissue.username' => $identifyPassreissue['Passreissue']['username']),
                  "fields" => "MAX(Passreissue.id) as max_id"));
            $sameuserMaxid = $sameuserMaxid[0]['max_id'];
            if($identifyPassreissueUni['PassreissueUnique']['id'] != $sameuserMaxid){
                $errMsg = "URL is older";
                throw new Exception($errMsg);
            }
            //2-4:ハッシュマッチ確認
            App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
            $passwordHasher = new BlowfishPasswordHasher();
            if(!($passwordHasher->check($token2, $identifyPassreissue['Passreissue']['token']))){
                $errMsg = "Token doesn't match with hashed";
                throw new Exception($errMsg);
            }
        } catch(Exception $e) {
            //$this->Session->setFlash("無効なURLです。URLが間違っているか、有効期限切れの可能性があります。再登録をしてください。");
            //下記1行デバッグ用
              $this->Session->setFlash("{$e->getMessage()}");
              $this->redirect(array('action' => 'signup'));
        }

        if ($this->request->is('post')) {
            $this->User->set($this->request->data);
            unset($this->User->validate['password']['authEdit']);
            unset($this->User->validate['password']['authLogin']);
            unset($this->User->validate['birth']);
            if($this->User->validates()){
                $this->request->data['User']['id'] = $this->User->findId($identifyPassreissue['Passreissue']['username']);
                $this->request->data['User']['passreissue_id'] = $identifyPassreissueUni['PassreissueUnique']['id'];
                $this->request->data['User']['username'] = $identifyPassreissue['Passreissue']['username'];
                pr($this->request->data);
                if($this->User->updateTransaction($this->request->data)){
                    $this->Session->setFlash('パスワード再登録完了しました。ログインページへ遷移しました、ログインしてください。');
                    $this->redirect($this->Auth->logout());
                }else{
                    echo "パスワードの再登録に失敗しました。再度やり直してください";
              }// if save終わり
          }else{
              $error = array_column($this->User->validationErrors, 0);
              $this->set('error', $error);
          }//if validate終わり
        }//postif終わり
    }//end forgetpassregister終わり


    //登録処理
    public function register() {
        $token = $this->request->query('token');
        $token1 = substr($token, 0, 64);
        $token2 = substr($token, 64, 64);
        $this->set('token', $token);
        try{
            //1.URLValidation start provision_uniqueテーブルから
            App::uses('ProvisionUnique','Model');
            $this->ProvisionUnique = new ProvisionUnique;
            if(isset($token1)){
                $identifyProvisionUni = $this->ProvisionUnique->find('first',
                array('conditions' => array('ProvisionUnique.unique_token1' => $token1),
                    'fields' => array('ProvisionUnique.id','ProvisionUnique.created')
                ));
            }else{
                    $errMsg = "URL is none & not correct";
                    throw new Exception($errMsg);
            }
            if(count($identifyProvisionUni) != 1){
                $errMsg = "No url match with DB";
                throw new Exception($errMsg);
            }
            //2.URLValidation start provisionテーブルから
            App::uses('Provision','Model');
            $this->Provision = new Provision;
            $identifyProvision = $this->Provision->find('first',
            array('conditions' => array('Provision.id' => $identifyProvisionUni['ProvisionUnique']['id'], 'Provision.del_flag' => 0),
                'fields' => array('Provision.username','Provision.token','Provision.created')
            ));
            //2-1:データ有無確認
            if(count($identifyProvision) != 1){
                $errMsg = "No url match with DB or was deleted";
                throw new Exception($errMsg);
            }
            //2-1:有効期限確認
            //$created1 = $identifyProvision['Provision']['created'];
            $created = strtotime($identifyProvision['Provision']['created']);
            $now = time();
            $passedTimemin = ($now - $created)/60;
            if($passedTimemin > 30){
                $errMsg = "Time for registration expired";
                //$errMsg = "Time for registration expired"."登録時間1：".$creted1."登録時間2：".$created."現在時刻：".$now."経過時間：".$passedTimemin;
                throw new Exception($errMsg);
            }
            //2-3:同ユーザーURL最新是非確認
            $sameuserMaxid = $this->Provision->find('first', array(
                  'conditions' => array('Provision.username' => $identifyProvision['Provision']['username']),
                  "fields" => "MAX(Provision.id) as max_id"));
            $sameuserMaxid = $sameuserMaxid[0]['max_id'];
            if($identifyProvisionUni['ProvisionUnique']['id'] != $sameuserMaxid){
                $errMsg = "URL is older";
                throw new Exception($errMsg);
            }
            //2-4:ハッシュマッチ確認
            App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
            $passwordHasher = new BlowfishPasswordHasher();
            if(!($passwordHasher->check($token2, $identifyProvision['Provision']['token']))){
                $errMsg = "Token doesn't match with hashed";
                throw new Exception($errMsg);
            }
        } catch(Exception $e) {
            //$this->Session->setFlash("無効なURLです。URLが間違っているか、有効期限切れの可能性があります。再登録をしてください。");
            //下記1行デバッグ用
              $this->Session->setFlash("{$e->getMessage()}");
              $this->redirect(array('action' => 'signup'));
        }

        if ($this->request->is('post')) {
            //
            //$uid = $this->User->find('first',
            //array('conditions' => array('User.username' => $this->request->data['User']['username']),
            //    'fields' => array('User.id')
            //));
            //pr($this->request->data);
            $this->User->set($this->request->data);
            unset($this->User->validate['password']['authEdit']);
            unset($this->User->validate['password']['authLogin']);
            if($this->User->validates()){
                $this->request->data['User']['provision_id'] = $identifyProvisionUni['ProvisionUnique']['id'];
                $this->request->data['User']['username'] = $identifyProvision['Provision']['username'];
                if($this->User->saveTransaction($this->request->data)){
                    $this->Session->setFlash('登録完了しました。ログインページへ遷移しました、ログインしてください。');
                    $this->redirect($this->Auth->logout());
                    //$this->redirect('login');
                    //echo "登録完了";
              }else{
                  echo "登録に失敗しました。再度やり直してください";
                  //$this->redirect('action' =>'register?token='.$token);
              }// if save終わり
          }else{
              $error = array_column($this->User->validationErrors, 0);
              $this->set('error', $error);
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


    /*----------------------------------------------
    自動ログイン処理関数 @controller login
    function setup_auto_login, delete_auto_login
    ----------------------------------------------*/

    public function setup_auto_login($request_data){
        $cookieName = 'auto_login';
        App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
        $auto_login_key1 = $this->User->genRandStr(64);
        $auto_login_key2 = uniqid() . mt_rand( 1,999999999 ) . '_auto_login';
        $passwordHasher = new BlowfishPasswordHasher();
        $hash_key = $passwordHasher->hash($auto_login_key2);
        $cookieExpire = time() + 3600 * 24 * 7; // 7日間
        $cookiePath = '/';
        $cookieDomain = $_SERVER['SERVER_NAME'];
        App::uses('UserAutologin','Model');
        $this->UserAutologin = new UserAutologin;
        $data = array();
        $data['UserAutologin']['username'] = $request_data;
        $data['UserAutologin']['auto_login_key1'] = $auto_login_key1;
        $data['UserAutologin']['auto_login_key2'] = $hash_key;
        $this->UserAutologin->set($data);
        if($this->UserAutologin->save()){
            //$this->db_manager->get('Author')->autoLoginSet($request_data, $auto_login_key);
            setcookie($cookieName, $auto_login_key1.$auto_login_key2, $cookieExpire, $cookiePath, $cookieDomain);
        }else{
            echo "user_autologinにセーブ失敗だよ！";
        }
    }//end setup_auto_login function

    public function delete_auto_login($auto_login_key = '', $existAccount){
        //アカウントがあるとき$exsitAccount = TRUE、テーブルの削除
        if($existAccount){
        $auto_login_key1 = substr($auto_login_key, 0, 64);
        App::uses('UserAutologin','Model');
        $this->UserAutologin = new UserAutologin;
        $idDeleted = $this->UserAutologin->find('first',
            array('conditions' => array('UserAutologin.auto_login_key1' => $auto_login_key1),
                'fields' => array('UserAutologin.id')
          ));
        $this->UserAutologin->delete($idDeleted['UserAutologin']['id']);
        }
        //(２)クッキーの削除
        $cookieName = 'auto_login';
        $cookieExpire = time() - 1800;
        $cookiePath = '/';
        $cookieDomain = $_SERVER['SERVER_NAME'];
        setcookie($cookieName, $auto_login_key, $cookieExpire, $cookiePath, $cookieDomain);
    }//end delete_auto_login function


}//end UsersController


