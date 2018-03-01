<?php

App::uses('AppModel', 'Model');

class PostContact extends AppModel {

    public $validate = array(
        'name' => array(
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Name」が未入力です。入力してください。'
            ),
            'maxlength' => array(
                'rule' => array('minlength',15),
                'message' => '「Name」が字数が足りていません。'
            ),
            'maxlength' => array(
                'rule' => array('maxlength',10),
                'message' => '「Name」が字数オーバーです。'
            ),
            'escape' => array(
                'rule' => 'escapeCheck',
                'message' => '「Name」が不当な入力です。再度入力してください。'
            )
        ),
        'department' => array(
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Department」が未入力です。入力してください。'
            ),
            'escape' => array(
                'rule' => 'escapeCheck',
                'message' => '「Name」が不当な入力です。再度入力してください。'
            )
        ),
        'company' => array(
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Company」が未入力です。入力してください。'
            ),
            'escape' => array(
                'rule' => 'escapeCheck',
                'message' => '「Company」が不当な入力です。再度入力してください。'
            )
        ),
        'email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => '「Email」の入力内容がメールアドレスの形式ではありません。<br>再度入力してください。'
            ),
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Email」が未入力です。入力してください。'
            ),
            'minlength1' => array(
                'rule' => array('minlength',15),
                'message' => '「Name」が字数が足りていません。'
            )
        ),
        'message' => array(
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Message」が未入力です。入力してください。'
            ),
            'maxLength'=>array(
                'rule' => array('maxLength', 200),
                'message' => '「Message」は200字以内で入力して下さい。',
            ),
            'escape' => array(
                'rule' => 'escapeCheck',
                'message' => '「Message」が不当な入力です。再度入力してください。'
            )
        )
    );//end vaidation

    function escapeCheck($data){
        $value = array_values($data);
        return $value['0'] == h(h($value['0']));
    }//end escapeCheck

}//end Postmodel

