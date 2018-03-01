<?php

App::uses('AppModel', 'Model');

class PostContact extends AppModel {

    public $validate = array(
        'name' => array(
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Name」が未入力です。入力してください。'
            ),
            'escape' => array(
                'rule' => 'escapeCheck',
                'message' => '不当な入力です。再度入力してください。'
            )
        ),
        'department' => array(
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Department」が未入力です。入力してください。'
            )
        ),
        'company' => array(
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Company」が未入力です。入力してください。'
            )
        ),
        'email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => 'Emailの入力内容がメールアドレスの形式ではありません。<br>再度入力してください。'
            ),
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Email」が未入力です。入力してください。'
            )
        ),
        'message' => array(
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Message」が未入力です。入力してください。'
            ),
            'maxLength'=>array(
                'rule' => array('maxLength', 200),
                'message' => '200字以内で入力して下さい。',
            )
        )
    );//end vaidation

    //htmlやscriptのタグ入力有無判定チェック
    function escapeCheck($data){
        //ここでは全入力項目をチェックしている。
        $i = 0;
        $dataValues = array_values($data);
        foreach($dataValues as $value){
            if($value != h(h($value))){
                $i += 1;
            }
        }//end foreach
        return $i == 0;//
    }//end escapeCheck

}//end Postmodel

