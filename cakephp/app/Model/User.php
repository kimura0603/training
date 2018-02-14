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
           'rule-2' => array(
               'rule' => array('conflictUsername'),//関数置く以外ないのかな。
               'message' => 'そのidはすでに存在しています'
           )#rule3終わり
    ),#username終わり
     'password' => array(
          #rule3:passwordが未入力
         'rule-1' => array(
             'rule' => 'notBlank',
             'message' => 'PASSWORDが未入力です。入力してください。'
         ),
         'rule-auth' => array(
             'rule' => array('auth2'),//user_idは。
             'message' => 'function-auth2IDとPASSWORDの組み合わせが異なっています。再入力してください。'
         )
      ),//password終わり
      'auth' => array(
          #rule4:ID（username)とPASSWORD（password）の一致確認。
          'rule-1' => array(
              'rule' => array('auth'),//user_idは。
              'message' => 'function-authIDとPASSWORDの組み合わせが異なっています。再入力してください。'
          ),#rule4終わり
          'rule-2' => array(
              'rule' => array('auth'),//
              'message' => '現在のPASSWORDが正しくありません。再入力してください。'
          )#rule4終わり
      ),#auth終わり
      'newpassword1' => array(
           #rule3:passwordが未入力
          'rule-1' => array(
              'rule' => 'notBlank',
              'message' => '新しいPASSWORDが未入力です。入力してください。'
          )
       ),//newpassword終わり
       'newpassword2' => array(
            #rule3:passwordが未入力
           'rule-1' => array(
               'rule' => 'notBlank',
               'message' => '新しいPASSWORD（確認用）が未入力です。入力してください。'
           )
        ),//newpassword2終わり
      'samepass' => array(
           'rule-1' => array(
               'rule' => array('samePassword'),//関数置く以外ないのかな。
               'message' => '前と同じPASSWORDは使えません。新しいPASSWORDを入力してください。'
           )#rul6終わり
      ),#samepass終わり
      'password2' => array(
        #regist時のpasswordマッチ確認
        'rule-regist' => array(
            'rule' => 'match',
            'message' => 'PASSWORDが確認用と一致しません。入力内容を確認してください。'
        )//rule3終わり
      ),//match終わり
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

  public function auth($data){
    $password = $this->find('all',
    array('conditions' => array('User.username' => explode(",", $data['auth'])[0]),
          'fields' => array('User.password'),
        )
    );
    if($password){
      return $password['0']['User']['password'] == explode(",", $data['auth'])[1];
    }else{
    return FALSE;
    }
  }//auth終わり

  public function auth2($data){
    $passwordHasher = new BlowfishPasswordHasher();
    $currentPassword = $this->find('first', array(
        'conditions' => array('User.username' => $this->data['User']['username']),
        'fields' => 'password'
    ));
      //var_dump($currentPassword);
      //パスワードの正誤判定
      //check関数の中身はpassword_verifyで、bool値を返す
      if($passwordHasher->check($data['password'], $currentPassword['User']['password'])){
          return TRUE;
      }else{
          return FALSE;
      }
  }

  public function conflictUsername($data){
      if($this->hasAny($data)){
        //trueならconflictなのでfalseを返す。
        return FALSE;
      }else{
        return TRUE;
      }
  }//conflictUsername終わり

  public function samePassword($data){
      //if内がtrueなら、同じパスワードを再利用しようとしていることなのでvalidationerrorのためfalse返す
      if(explode(",", $data['samepass'])[0] === explode(",", $data['samepass'])[1]){
        return FALSE;
      }else{
        return TRUE;
      }
  }//samePassword終わり

    public function findId($data){
        $id = $this->find('all',
            array('conditions' => array('User.username' => $data['User']['username']),
                'fields' => 'User.id'
            )
        );
        return $id['0']['User']['id'];
    }//findId終わり

    public function saveTransaction($data){
      App::uses('UserUnique','Model');
      $this->UserUnique = new UserUnique;
        $datasource = $this->getDataSource();
        try{
            $datasource->begin();
            $uniqueData = array();
            $uniqueData['UserUnique']['username'] = $data['User']['username'];
            $uniqueData['UserUnique']['password'] = Security::hash($data['User']['password'], 'sha512', true);
            //$data['User']['password'] = Security::hash($data['User']['password'], 'sha512', true);
            if(!($this->UserUnique->save($uniqueData))){
                throw new Exception("ID重複のため登録失敗しました。別のIDでやり直してください！！");
            }
            if(!($this->save($data, false))){
                throw new Exception("saveに失敗しました！！");
            }
                $datasource->commit();
                return true;
        } catch(Exception $e) {
            $datasource->rollback();
            return false;
        }//try&catch終わり
    }//function saveTransaction終わり

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
        var_dump($this->data);
        $birthday = $data['birth']['year'].$data['birth']['month'].$data['birth']['day'];
        $now = date("Ymd");
        $estAge = floor(($now-$birthday)/10000);
        if($estAge == $this->data['User']['age']){
              return true;
        }else{
              return false;
        }
    }//confirmAge終わり

    public function checkPassword($data) {
        var_dump($data);
        $passwordHasher = new BlowfishPasswordHasher();
        $currentPassword = $this->find('first', array(
            'conditions' => array('User.username' => $data['User']['username']),
            'fields' => 'password'
        ));
        //var_dump($currentPassword);
        //パスワードの正誤判定
        //check関数の中身はpassword_verifyで、bool値を返す
        if($passwordHasher->check($data['User']['password'], $currentPassword['User']['password'])){
            return TRUE;
        }else{
            return FALSE;
        }
    }//function checkPassword end

}

