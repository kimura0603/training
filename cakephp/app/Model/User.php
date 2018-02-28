<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
  //user_idはパスワードとIDの合致に利用
  public $name = 'User';

  public $validate = array(
      'username' => array(
           #rule1:usernameが未入力
          //controllerで0と未入力の違いをstrlen関数を使って整理する方法があり。
          'rule-1' => array(
              'rule' => 'notBlank',
              'message' => 'IDが未入力。入力してください。'
          ),//rule1終わり
          #rule2:データベースで検索して該当板IDがない場合の返し。
           'conflictUsername' => array(
               'rule' => array('conflictUsername'),//関数置く以外ないのかな。
               'message' => 'そのidはすでに存在しています'
          ),#rule3終わり
                #rule3:emailアドレスか否か
          'email' => array(
                'rule' => 'email',
                'message' => 'メールアドレスの形式ではありません。再入力してください。'
          ),//rule3終わり,
          'matchIdandbrith' => array(
                'rule' => 'matchIdandbrith',
                'message' => '生年月日とIDが合致するアカウントがありません。再入力してください。'
          )//rule3終わり
    ),#username終わり
     'password' => array(
          #rule3:passwordが未入力
         'rule-1' => array(
             'rule' => 'notBlank',
             'message' => 'PASSWORDが未入力です。入力してください。'
         ),
         'authLogin' => array(
             'rule' => array('auth2'),//user_idは。
             'message' => 'IDとPASSWORDの組み合わせが異なっています。再入力してください。'
         ),
          'authEdit' => array(
              'rule' => array('auth2'),//
              'message' => '現在のPASSWORDが正しくありません。再入力してください。'
          )#authEdit終わり
      ),#auth終わり
      'password2' => array(
          'matchRegist' => array(
              'rule' => 'matchRegist',
              'message' => 'パスワードの入力内容が確認用と一致していません。再入力してください。'
          )
       ),#auth終わり
      'newpassword1' => array(
           #rule3:passwordが未入力
          'match' => array(
              'rule' => 'matchPass12',
              'message' => '新しいパスワードの内容が一致しません。確認してください。'
          ),
          'checkNew' => array(
              'rule' => 'checkNew',
              'message' => '前と同じPASSWORDは使えません。新しいPASSWORDを入力してください。'
          )
       ),//newpassword終わり
      'birth' => array(
           #rule3:passwordが未入力
          'rule-1' => array(
              'rule' => 'confirmAge1',
              'message' => '生年月日と年齢が一致しません。再度確認して入力してください。'
          )
       )
  );#validate終わり

  public function beforeSave($options=array()) {
    if($this->data['User']['password']){
        $passwordHasher = new BlowfishPasswordHasher();
        $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        //$this->data['User']['password'] = Security::hash($this->data['User']['password'], 'sha512', true);
    }
      return true;
  }

  /*
  public function beforeFind($queryData) {
      $passwordHasher = new BlowfishPasswordHasher();
      $queryData['conditions']['User.password'] = $passwordHasher->hash($queryData['conditions']['User.password']);
      return $queryData;
  }
  */

  public function dateFormatBeforeSave($dateString) {
      return date('Y-m-d', strtotime($dateString));
  }

  public function auth2($data){
    $passwordHasher = new BlowfishPasswordHasher();
    $currentPassword = $this->find('first', array(
        'conditions' => array('User.username' => $this->data['User']['username']),
        'fields' => 'password'
    ));
      //var_dump($currentPassword);
      //パスワードの正誤判定
      //check関数の中身はpassword_verifyで、bool値を返す
    return $passwordHasher->check($data['password'], $currentPassword['User']['password']);

  }

  public function conflictUsername($data){
      if($this->hasAny($data)){
        //trueならconflictなのでfalseを返す。
        return FALSE;
      }else{
        return TRUE;
      }
  }//conflictUsername終わり

  public function matchIdandbrith($data){
      $recordBirthday = $this->find('first', array(
          'conditions' => array('User.username' => $data['username']),
          'fields' => 'birthday'
      ));
      $inputBirthday = $this->data['User']['birth']['year'].$this->data['User']['birth']['month'].$this->data['User']['birth']['day'];
      return $recordBirthday['User']['birthday'] == $inputBirthday;
  }//matchIdandbrith終わり

  public function matchRegist($data){
      //if内がtrueなら、同じパスワードを再利用しようとしていることなのでvalidationerrorのためfalse返す
      return $this->data['User']['password'] == $data['password2'];
  }//matchPass12終わり



  public function matchPass12($data){
      //if内がtrueなら、同じパスワードを再利用しようとしていることなのでvalidationerrorのためfalse返す
      return $data['newpassword1'] == $this->data['User']['newpassword2'];
  }//matchPass12終わり

  public function checkNew($data){
      $passwordHasher = new BlowfishPasswordHasher();
      $currentPassword = $this->find('first', array(
          'conditions' => array('User.username' => $this->data['User']['username']),
          'fields' => 'password'
      ));
      if($passwordHasher->check($data['newpassword1'], $currentPassword['User']['password'])){
          return FALSE;
      }else{
          return TRUE;
      }
  }//checkNew終わり

  /*
  public function samePassword($data){
      //if内がtrueなら、同じパスワードを再利用しようとしていることなのでvalidationerrorのためfalse返す
      if(explode(",", $data['samepass'])[0] === explode(",", $data['samepass'])[1]){
        return FALSE;
      }else{
        return TRUE;
      }
  }//samePassword終わり
  */

    public function findId($data){
        //var_dump($data);
        $id = $this->find('first',
            array('conditions' => array('User.username' => $data),
                'fields' => 'User.id'
            )
        );
        return $id['User']['id'];
    }//findId終わり

    public function saveTransaction($data){
      App::uses('UserUnique','Model');
      $this->UserUnique = new UserUnique;
      App::uses('Provision','Model');
      $this->Provision = new Provision;
        $datasource = $this->getDataSource();
        try{
            $datasource->begin();
            $uniqueData = array();
            $uniqueData['UserUnique']['username'] = $data['User']['username'];
            $data['User']['birthday'] = $data['User']['birth']['year'].$data['User']['birth']['month'].$data['User']['birth']['day'];
            //$uniqueData['UserUnique']['password'] = Security::hash($data['User']['password'], 'sha512', true);
            //$data['User']['password'] = Security::hash($data['User']['password'], 'sha512', true);
            if(!($this->UserUnique->save($uniqueData))){
                throw new Exception("ID重複のため登録失敗しました。別のIDでやり直してください！！");
            }
            if(!($this->save($data, false))){
                throw new Exception("Userのsaveに失敗しました！！");
            }
            $change_dltflag = array('id' => $data['User']['provision_id'],'del_flag' => 1);
            if(!($this->Provision->save($change_dltflag, false))){
                throw new Exception("Provisionのdel_flagの変更に失敗しました！！");
            }
                $datasource->commit();
                return true;
        } catch(Exception $e) {
            $datasource->rollback();
            echo "{$e->getMessage()}";
            //return false;
        }//try&catch終わり
    }//function saveTransaction終わり

    public function updateTransaction($data){
      App::uses('Passreissue','Model');
      $this->Passreissue = new Passreissue;
        $datasource = $this->getDataSource();
        try{
            $datasource->begin();
            $uniqueData = array();
            if(!($this->save($data, false))){
                throw new Exception("Userのsaveに失敗しました！！");
            }
            $change_dltflag = array('id' => $data['User']['passreissue_id'],'del_flag' => 1);
            if(!($this->Passreissue->save($change_dltflag, false))){
                throw new Exception("Passreissueのdel_flagの変更に失敗しました！！");
            }
                $datasource->commit();
                return true;
        } catch(Exception $e) {
            $datasource->rollback();
            echo $e->getMessage();
            return false;
        }//try&catch終わり
    }//function updateTransaction終わり


    public function testUnique($data){
        App::uses('UserUnique','Model');
        $this->UserUnique = new UserUnique;
        return $this->UserUnique->find('all');
    }//function testUnique終わり

    public function confirmAge($data){
        $now = date("Ymd");
        $estAge = floor(($now-$data['birthValid']['date'])/10000);
        if($estAge == $data['birthValid']['age']){
              return true;
        }else{
              return false;
        }
    }//confirmAge終わり


    public function confirmAge1($data){
        //var_dump($this->data);
        $birthday = $data['birth']['year'].$data['birth']['month'].$data['birth']['day'];
        $now = date("Ymd");
        $estAge = floor(($now-$birthday)/10000);
        if($estAge == $this->data['User']['age']){
              return true;
        }else{
              return false;
        }
    }//confirmAge終わり

    public function uniquetokenIssue($model){

      /*
        目的：ユーザーURLの事前作成
        //1.provision_uniquesの登録量チェック
        //2.1の量が十分でないなら作成
      */
        //$uniqueModelはモデル$modelの片割れtokenの記録テーブルのモデル名


      //$modelはモデル名。url用のtokenを発行するモデルを選択

      //$uniqueModelはモデル$modelの片割れtokenの記録テーブルのモデル名
      $uniqueModel = $model.'Unique';
      //1.provision_uniquesの登録量チェック
      App::uses($model,'Model');
      $this->$model = new $model;
      $modelMaxid = $this->$model->find('first',
          array(
            "fields" => "MAX($model.id) as max_id"
      ));
      pr($modelMaxid);

      //pr({$model}.'Unique');
      //pr({$model}."Unique");

      pr($uniqueModel);

      App::uses($uniqueModel,'Model');
      $this->$uniqueModel = new $uniqueModel;
          $uniMaxid = $this->$uniqueModel->find('first',
              array(
                "fields" => "MAX($uniqueModel.id) as max_id"
          ));
      pr($uniMaxid);

      $availableUrl = $uniMaxid[0]['max_id'] - $modelMaxid[0]['max_id'];//差分がまだ利用されていないid＝利用できるurl用のtokenの数
      //$availableUrl = 150 - $modelMaxid[0]['max_id'];//差分がまだ利用されていないid＝利用できるurl用のtokenの数
      //2.1の量が一定量以下なら作成
      pr($availableUrl);
      $issueCriteria = 100;
      if($availableUrl < $issueCriteria){
          $db = $this->$uniqueModel->getDataSource();
          $type = "WRITE";
          $a = 0;
          $data = array();
          try{
              $db->begin();
              $q = "LOCK TABLE {$this->$uniqueModel->useTable} {$type}, {$this->$uniqueModel->useTable} AS {$this->$uniqueModel->name} {$type};";
              $db->query($q);
              while($a < 50){
                  $uniqueToken = $this->$uniqueModel->genRandStr(64);
                  if($this->$uniqueModel->hasAny(array('unique_token1'=>$uniqueToken))){
                      continue;
                  }else{
                      $data[$uniqueModel][$a] = array('unique_token1' => $uniqueToken);
                      $a += 1;
                  }
              }//while終わり
              pr($data);
              $this->$uniqueModel->set($data);
              if($this->$uniqueModel->saveAll($data[$uniqueModel])){
                  $db->commit();
                  $db->query("UNLOCK TABLES");
                  echo "セーブうまくできたよ！";
              }else{
                  throw new Exception("saveに失敗しました！！");
              }
              $db->commit();
              $db->query("UNLOCK TABLES");
          } catch(Exception $e) {
              $db->rollback();
              $db->query("UNLOCK TABLES");
              //$this->ProvisionUnique->rollback();
              //$this->ProvisionUnique->unlock();
              $this->Session->setFlash("{$e->getMessage()}");
              echo "失敗したからロールバックしたよ";
          }//try&catch終わり
      }else{
              echo $model."テーブルは".$issueCriteria."件以上未使用のレコードがあるのでTokenの新規作成をしませんでした。";
      }//end if $left_volURL < 100
  }//end function uniquetokenIssue


}

