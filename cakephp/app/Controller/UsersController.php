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
    public $uses = array('User','Provision');

    public function beforeFilter() {
        parent::beforeFilter();
        //Security::setHash('sha512');
        // 非ログイン時にも実行可能とする
        $this->Auth->allow('edit','logout','test','register','login','signup','signupfinish','unique');
        //トークン設定
        //http://rihi.cocolog-nifty.com/blog/2010/07/cakephpsecurity.html
        //$this->Security->validatePost = false;
        //https://www.orenante.com/cakephp2-securitycomponent-%E3%81%A7-%E3%83%81%E3%82%A7%E3%83%83%E3%82%AF%E3%82%92%E5%A4%96%E3%81%97%E3%81%9F%E3%81%84action%E3%81%AE%E6%8C%87%E5%AE%9A/
        $this->Security->unlockedActions = array('register','login','top', 'editpass', 'mail','signup','test','unique');
    }

    public function test() {
        //pr(uniqid(12,true));
        App::uses('UserUnique','Model');
        App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
        $this->UserUnique = new UserUnique;
        $a = 0;
        $time_roopstart = microtime(true);
        $time2 = microtime(true);

        while($a < 5){
            $token = $this->UserUnique->genRandStr(128);
            pr($token);
            $passwordHasher = new BlowfishPasswordHasher();
            $hash = $passwordHasher->hash($token);
            //$hash = '$2a$10$zliRdlxHWWtqXAWHSBkPqO1iA.J8/UWrsKhnXkgKnyRiBtkgWF6L2';
            pr($hash);
            if($this->UserUnique->hasAny(array('password'=>$hash))){
                $time1 = microtime(true);
                $time_div = $time1 - $time2;
                echo "{$time_div}秒";
                $time2 = microtime(true);
                $a += 1;
            }else{
                break;
            }
        }

        /*
        //データ作成用
        while($a < 400){
            $token = $this->UserUnique->genRandStr(128);
            pr($token);
            $passwordHasher = new BlowfishPasswordHasher();
            $hash = $passwordHasher->hash($token);
            //$hash = '$2a$10$U4BNiZCpbQenVTdgnpyEFOhqYqDwGluNcNKU34o2j4ggp2V5.zXkO';
            pr($hash);
            if(!($this->UserUnique->hasAny(array('password'=>$hash)))){
                //$time2 = microtime(true);
                $data = array('UserUnique' => array('username' => $token, 'password' => $hash));
                $this->UserUnique->create();
                $this->UserUnique->set($data);
                $this->UserUnique->save();
                $a += 1;
            }else{
                continue;
            }
        }
        */

        $time_roopend = microtime(true);
        pr($time_roopend - $time_roopstart);
        pr($a);
        $sessionid = session_id();
        pr($sessionid);
        $data = array('UserUnique' => array('username' => $token, 'password' => $hash, 'sessionid' => $sessionid));
        $this->UserUnique->set($data);
        if($this->UserUnique->save()){
            echo "セーブ成功";
        }else{
            echo "セーブ失敗";
        }
        //↓除去禁止
        $this->render('top');
    }

    public function unique() {
      /*
        目的：ユーザーURLの事前作成
        //1.provision_uniquesの登録量チェック
        //2.1の量が十分でないなら作成
      */

        //1.provision_uniquesの登録量チェック
        App::uses('Provision','Model');
        $this->Provision = new Provision;
        $provisionMaxid = $this->Provision->find('first',
            array(
              "fields" => "MAX(Provision.id) as max_id"
        ));
        //pr($provisionMaxid[0]['max_id']);
        //exit();
        App::uses('ProvisionUnique','Model');
        $this->ProvisionUnique = new ProvisionUnique;
        $uniMaxid = $this->ProvisionUnique->find('first',
            array(
              "fields" => "MAX(ProvisionUnique.id) as max_id"
        ));

        $left_volURL = $uniMaxid[0]['max_id'] - $provisionMaxid[0]['max_id'];
        pr($provisionMaxid);
        pr($uniMaxid);
        //2.1の量が十分でないなら作成
        pr($left_volURL);
        if($left_volURL < 100){
        App::uses('ProvisionUnique','Model');
        App::import('Model','ConnectionManager');
        $this->ProvisionUnique = new ProvisionUnique;
        //pr($this->useDbConfig)
        //$db = ConnectionManager::getDataSource('default');
        //$db =& ConnectionManager::getDataSource($this->config);
        $db = $this->ProvisionUnique->getDataSource();
        $type = "WRITE";
        //pr($this->ProvisionUnique->useTable);
        //pr($this->ProvisionUnique);
        //pr($this->ProvisionUnique->name);
        //pr($this->name);
        $a = 0;
        //$datasource = $this->getDataSource();
        $data = array();
        try{
        $db->begin();
        $q = "LOCK TABLE {$this->ProvisionUnique->useTable} {$type}, {$this->ProvisionUnique->useTable} AS {$this->ProvisionUnique->name} {$type};";
        $db->query($q);
            while($a < 100){
                $uniqueToken = $this->ProvisionUnique->genRandStr(64);
                if($this->ProvisionUnique->hasAny(array('unique_token1'=>$uniqueToken))){
                  continue;
                }else{
                  $data['ProvisionUnique'][$a] = array('unique_token1' => $uniqueToken);
                  $a += 1;
                }
            }//while終わり
                pr($data);
                $this->ProvisionUnique->set($data);
                if($this->ProvisionUnique->saveAll($data['ProvisionUnique'])){
                    $db->commit();
                    $db->query("UNLOCK TABLES");
                    //$this->ProvisionUnique->commit();
                    //$this->ProvisionUnique->unlock();
                    echo "セーブうまくできたよ！";
                }else{
                    throw new Exception("saveに失敗しました！！");
                    //echo "セーブ失敗したよ";
                }
          $db->commit();
          $db->query("UNLOCK TABLES");
        } catch(Exception $e) {
            $db->rollback();
            $db->query("UNLOCK TABLES");
            //$this->ProvisionUnique->rollback();
            //$this->ProvisionUnique->unlock();
            echo "失敗したからロールバックしたよ";
        }//try&catch終わり
        }//end if $left_volURL < 100
        //↓除去禁止レンダー用
        $this->render('top');

    }


    public function signup() {
        if ($this->request->is('post')) {
            $this->request->data['User']['username'] = htmlentities($this->request->data['User']['username'], ENT_QUOTES);
            $this->User->set($this->request->data);
            unset($this->User->validate['username']['conflictUsername']);
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
              unset($this->User->validate['username']['email']);
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
        $token = $this->request->query('token');
        /*
            //下記URLテスト用
            //1.ランダムURL
            //$token = $this->User->genRandStr(65);
            //2.それ以外のURL
            App::uses('Provision','Model');
            $this->Provision = new Provision;
            $provisionMaxid = $this->Provision->find('first',
                array(
                  "fields" => "MAX(Provision.id) as max_id"
            ));
            //pr($provisionMaxid[0]['max_id']);
            //exit();
            App::uses('ProvisionUnique','Model');
            $this->ProvisionUnique = new ProvisionUnique;
            $uniURL = $this->ProvisionUnique->find('first',
                  array('conditions' => array('ProvisionUnique.id' => $provisionMaxid[0]['max_id']),
                        'fields' => array('ProvisionUnique.unique_token1')
            ));
            $token = $uniURL['ProvisionUnique']['unique_token1'].$this->User->genRandStr(5);
            //テスト終わり
        */
        $token1 = substr($token, 0, 64);
        $token2 = substr($token, 64, 64);
        $this->set('token', $token);
        pr($token1);
        pr($token2);

        $provisionAddress = "";
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
            $passwordHasher = new BlowfishPasswordHasher();
            if(!($passwordHasher->check($token2, $identifyProvision['Provision']['token']))){
                $errMsg = "Token doesn't match with hashed";
                throw new Exception($errMsg);
            }
        } catch(Exception $e) {
            $this->Session->setFlash("無効なURLです。URLが間違っているか、有効期限切れの可能性があります。再登録をしてください。");
            //下記1行デバッグ用
              //$this->Session->setFlash("{$e->getMessage()}");
          $this->redirect(array('action' => 'signup'));
        }

        /*
        if(isset($token)){
            $identify = $this->Provision->find('first',
            array('conditions' => array('Provision.token' => $token),
                'fields' => array('Provision.id','Provision.username','Provision.created','Provision.del_flag')
            ));

            if((count($identify) != 1)){
                    throw new NotFoundException;
            }else{
                $provisionAddress = $identify['Provision']['username'];
              //古いtokenなら期限切れ。
              //user.idを出す。usernameをベースにidを探して一番新しい状態でなければ期限切れ。
                $sameuserMaxid = $this->Provision->find('first', array(
                    'conditions' => array('Provision.username' => $identify['Provision']['username']),
                    "fields" => "MAX(Provision.id) as max_id"));
                $sameuserMaxid = $sameuserMaxid[0]['max_id'];
                if($sameuserMaxid != $identify['Provision']['id']){
                    throw new ForbiddenException;
                }elseif($identify['Provision']['del_flag'] == 1){
                      throw new ForbiddenException;
                }else{
                    $created = strtotime($identify['Provision']['created']);
                    $now = time();
                    $passedTimemin = ($now - $created)/60;
                    //pr($created);
                    //pr($now);
                    //pr($passedTimemin);
                    if($passedTimemin > 30){
                          throw new ForbiddenException;
                    //}else{
                    //    $this->Provision->updateAll(
                    //    array('Provision.del_flag' => "1"),
                    //    array('Provision.token' => $token));
                    }//if $passedTimemin
                }//if sameuserMaxid
            }//if count($identify
        }else{
                    throw new NotFoundException;
        }//end if isset($token)
        */

        //パスワードのバリデーションのみでよし
        if ($this->request->is('post')) {
            $uid = $this->User->find('first',
            array('conditions' => array('User.username' => $this->request->data['User']['username']),
                'fields' => array('User.id')
            ));
            //pr($this->request->data);
            $this->User->set($this->request->data);
            unset($this->User->validate['password']['authEdit']);
            unset($this->User->validate['password']['authLogin']);
            if($this->User->validates()){
                $this->request->data['User']['username'] = $provisionAddress;
                if($this->User->updateTransaction($this->request->data)){
                    $this->Session->setFlash('登録完了しました。ログインページへ遷移しました、ログインしてください。');
                    $this->redirect($this->Auth->logout());
                    //$this->redirect('login');
                    //echo "登録完了";
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

