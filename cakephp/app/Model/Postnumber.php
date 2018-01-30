<?php

App::uses('AppModel', 'Model');

class Postnumber extends AppModel {
    public $validate = array(
        'num7' => array(
	#'郵便番号が未入力ですよ！'
            'rule1' => array(
                'rule' => 'notBlank',
                'message' => '郵便番号が未入力ですよ!　 from Modelのバリデーション'
            ),//rule1終わり
	#「郵便番号」は半角数字でハイフンなしの7字でご入力ください。
            'rule2' => array(
                'rule' => array('custom', '/^\d{7}$/'),
                'message' => '「郵便番号」は半角数字でハイフンなしの7字でご入力ください from Modelのバリデーション'
            )#rule2終わり
       )#num7終わり
    );#validate終わり
}

