<?php

App::uses('AppModel', 'Model');

class User extends AppModel {
  //user_idはパスワードとIDの合致に利用

  public $validate = array(
      'username' => array(
           #rule1:usernameが未入力
          //controllerで0と未入力の違いをstrlen関数を使って整理する方法があり。
          'rule1' => array(
              'rule' => 'notBlank',
              'message' => 'IDが未入力。再入力してください。'
          ),//rule1終わり
          #rule2:データベースで検索して該当板IDがない場合の返し。
           'rule2' => array(
               'rule' => array('existUsername'),//関数置く以外ないのかな。
               'message' => '該当するIDがありませんでした。再入力してください。'
           )#rule3終わり
     ),#username終わり
     'password' => array(
          #rule3:passwordが未入力
         'rule3' => array(
             'rule' => 'notBlank',
             'message' => 'PASSWORDが未入力です。入力してください。'
         )//rule3終わり
      ),//password終わり
      'auth' => array(
          #rule4:ID（username)とPASSWORD（password）の一致確認。
          'rule4' => array(
              'rule' => array('auth'),//user_idは。
              'message' => 'IDとPasswordが合致しません。再入力してください。'
          )#rule4終わり
      )#auth終わり
  );#validate終わり

  public $validate_regist = array(
      'username' => array(
           #rule1:usernameが未入力
          //controllerで0と未入力の違いをstrlen関数を使って整理する方法があり。
          'rule_edit1' => array(
              'rule' => 'notBlank',
              'message' => 'IDが未入力。再入力してください。'
          ),//rule_edit1終わり
          #rule2:データベースで検索して該当板IDがない場合の返し。
           'rule_edit2' => array(
               'rule' => array('conflictUsername'),//関数置く以外ないのかな。
               'message' => 'そのidはすでに存在しています'
           )#rule_edit_2終わり
     ),#username終わり
     'password' => array(
          #rule3:passwordが未入力
         'rule_edit3' => array(
             'rule' => 'notBlank',
             'message' => 'PASSWORDが未入力です。入力してください。'
         )//rule_dit3終わり
      )//password終わり
  );#validate終わり

  public $validate_editpass = array(
      'password' => array(
           #rule1:usernameが未入力
          //controllerで0と未入力の違いをstrlen関数を使って整理する方法があり。
          'rule_editpass1' => array(
              'rule' => 'notBlank',
              'message' => '1つ目のPASSWORDが未入力。再入力してください。'
          )//rule_edit1終わり
      ),
      #rule2:データベースで検索して該当板IDがない場合の返し。
      'samepass' => array(

           'rule_editpass2' => array(
               'rule' => array('samePassword'),//関数置く以外ないのかな。
               'message' => '前と同じPASSWORDは使えません。新しいPASSWORDを入力してください。'
           )#rule_edit_2終わり
      ),#samepass終わり
      'password2' => array(
          #rule3:passwordが未入力
         'rule_editpass3' => array(
             'rule' => 'notBlank',
             'message' => '確認用PASSWORDフォームが未入力です。入力してください。'
         )//rule_dit3終わり
      ),//password2終わり
      'match' => array(
           #rule3:passwordが未入力
          'rule_editpass4' => array(
              'rule' => array('match'),
              'message' => 'PASSWORDが一致しません。一致しているか確認してください。'
          )//rule_dit3終わり
      )//password2終わり
  );#validate終わり


  public function existUsername($data){
    return $this->hasAny($data);
  }//existUsername終わり

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
      $pre_pass = $this->find('all',
            array('conditions' => array('User.username' => explode(",", $data['same'])[0]),
                  'fields' => array('User.password')
          )
      );
      //if内がtrueなら、同じパスワードを再利用しようとしていることなのでvalidationerrorのためfalse返す
      if($pre_pass['0']['User']['password'] == explode(",", $data['auth'])[1]){
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

}

