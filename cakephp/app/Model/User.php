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
          )#rule4終わり
      ),#auth終わり
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
              'message' => 'PASSWORDが一致しません。一致しているか確認してください。'
          )//rule8終わり
      )//match終わり
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
      //idで登録したpasswordといれて、それがないかどうか。
      //$pre_pass = $this->find('all',
      //      array('conditions' => array('User.username' => explode(",", $data['same'])[0]),
      //            'fields' => array('User.password')
      //    )
      //);
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
        $datasource = $this->getDataSource();
        try{
            $datasource->begin();
            //#1:findを実行。でだぶってたらexceptionで例外処理
            //#2:このfindの結果が0件ならsave処理実施
            $hasAny = array('username' => $data['User']['username']);
            if ($this->hasAny($hasAny)) {
                throw new Exception("ID重複のため登録失敗しました。別のIDでやり直してください！！");
            }
            $data['User']['password'] = Security::hash($data['User']['password'], 'sha512', true);
            $this->save($data, false);
            $datasource->commit();
            return true;
        } catch(Exception $e) {
            $datasource->rollback();
            return false;
        }//try&catch終わり
    }//function saveTransaction終わり
}

