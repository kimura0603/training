<?php

App::uses('AppModel', 'Model');

class Postnumber extends AppModel {
    public $validate = array(
        'num7' => array(
	           #rule1:郵便番号が未入力ですよ！'
            //controllerで0と未入力の違いをstrlen関数を使って整理する方法があり。
            'rule1' => array(
                'rule' => 'notBlank',
                'message' => '郵便番号が未入力ですよ!　 from Modelのバリデーション'
            ),//rule1終わり
	         #rule2:「郵便番号」は半角数字でハイフンなしの7字でご入力ください。
            'rule2' => array(
                'rule' => array('custom', '/^\d{7}$/'),
                'message' => '「郵便番号」は半角数字でハイフンなしの7字でご入力ください from Modelのバリデーション'
            ),#rule2終わり
            #rule3:データベースで検索して該当板番号がない場合の返し。
              //controllerではfindが0ならエラーで返してたな
             'rule3' => array(
                 'rule' => array('existData'),//関数置く以外ないのかな。
                 'message' => '該当する住所がありませんでした。入力した「郵便番号」を確認してください。 from Modelのバリデーション'
             )#rule3終わり
       )#num7終わり
    );#validate終わり

    //validationのカスタム用関数
    public function existData($data) {
        return $this->hasAny($data);
    }

    public function validationForAjax($data){
        $this->set($data);
        $ret = array(
          'status' => $this->validates(),
          'msg' => $this->validationErrors,
        );
        //validationが問題なければ番号検索もやっちゃう。
        return $ret;
  }

    public function findData($data){
            $addresses = $this->find('all',
            array('conditions' => array('Postnumber.num7' => $data['num7']),
                  'fields' => array('Postnumber.num7','Postnumber.address1', 'Postnumber.address2', 'Postnumber.address3'),
                  'order' => array('Postnumber.id ASC')
                )
            );
            $addnum = count($addresses);
            $return['address']['error'] = 0;
            //$ret['address']['Postnumber'] = array();
            $return['address']['Postnumber'][] = 'dummy';/* 0番目予約 */
            foreach ($addresses as $a){
                $tmp = '';
                $tmp .= $a['Postnumber']['address1'];
                $tmp .= $a['Postnumber']['address2'];
                $tmp .= $a['Postnumber']['address3'];
                $return['address']['Postnumber'][] = $tmp;
            }//foreach終わり
      return $return;
  }//findData終わり

}

