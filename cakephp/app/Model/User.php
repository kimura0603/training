<?php

App::uses('AppModel', 'Model');

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
         )//rule3終わり
      ),//password終わり
      'auth' => array(
          #rule4:ID（username)とPASSWORD（password）の一致確認。
          'rule-1' => array(
              'rule' => array('auth'),//user_idは。
              'message' => 'IDとPASSWORDの組み合わせが異なっています。再入力してください。'
          ),#rule4終わり
          'rule-2' => array(
              'rule' => array('auth'),//user_idは。
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
          #rule3:passwordが未入力
         'rule-1' => array(
             'rule' => 'notBlank',
             'message' => '確認用PASSWORDが未入力です。入力してください。'
         )//rule7終わり
      ),//password2終わり
      'match' => array(
           #rule3:passwordが未入力
          'rule-1' => array(
              'rule' => array('match'),
              'message' => '新しいPASSWORDが一致しません。一致しているか確認してください。'
          )//rule8終わり
      ),//match終わり
      'birth' => array(
           #rule3:passwordが未入力
          'rule-1' => array(
              'rule' => 'confirmAge1',
              'message' => '生年月日と年齢が一致しません。再度確認して入力してください。'
          )//rule3終わり
       ),//password終わり
      'birthValid' => array(
           #rule3:passwordが未入力
          'rule-1' => array(
              'rule' => 'confirmAge',
              'message' => '生年月日と年齢が一致しません。再度確認して入力してください。'
          )//rule3終わり
       )//password終わり
  );#validate終わり

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
      if(explode(",", $data['samepass'])[0] == explode(",", $data['samepass'])[1]){
        return FALSE;
      }else{
        return TRUE;
      }
  }//samePassword終わり

  public function match($data){
      return explode(",", $data['match'])[0] == explode(",", $data['match'])[1];
  }//match終わり


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
            $data['User']['password'] = Security::hash($data['User']['password'], 'sha512', true);
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
        $birthday = $data['birth']['year'].$data['birth']['month'].$data['birth']['day'];
        $now = date("Ymd");
        $estAge = floor(($now-$birthday)/10000);
        if($estAge == $data['birth']['age']){
              return true;
        }else{
              return false;
        }
    }//confirmAge終わり


}

