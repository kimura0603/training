<?php

App::uses('AppModel', 'Model');

class PostComment extends AppModel {

    public $validate = array(
        'name' => array(
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Name」が未入力です。入力してください。'
            ),
            'spaceCheck' => array(
                'rule' => 'spaceCheck',
                'message' => '「Name2」が未入力です。入力してください。'
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
        'contact' => array(
            'blank' => array(
                'rule' => 'notBlank',
                'message' => '「Message」が未入力です。入力してください。'
            ),
            'maxLength'=>array(
                'rule' => array('maxLength', 500),
                'message' => '「Message」は500字以内で入力して下さい。',
            ),
            'escape' => array(
                'rule' => 'escapeCheck',
                'message' => '「Message」が不当な入力です。再度入力してください。'
            )
        )
    );//end vaidation


    public function beforeSave($options=array()) {
        if(isset($this->data['PostContact']['name'])){
            $this->data['PostContact']['name'] = $this->rmSpace($this->data['PostContact']['name']);
        }
        return true;
    }

    function escapeCheck($data){
        $value = array_values($data);
        return $value['0'] == h(h($value['0']));
    }//end escapeCheck

    function spaceCheck($data){
        return strlen($this->rmSpace($data['name']));
    }//end spaceCheck

    private function rmSpace($string){
        if(!is_string($string)){
            return '';
        }
        $str1 = mb_ereg_replace("(\s|　)", ' ', $string);
        $words = explode(' ',$str1);
        $words = array_filter($words, "strlen");
        return implode(' ',$words);
    }

    public function commentDisplay($id){
        return $this->find('all', array(
                  'conditions' => array('PostComment.post_id' => $id,'PostComment.del_flag' => 0, 'PostComment.open' => 0),
                  'fields' => array('PostComment.id','PostComment.layer_1','PostComment.layer_2','PostComment.layer_3','PostComment.comment','PostComment.created'),
                  'order' => array('PostComment.layer_1','PostComment.layer_2')
                  ));
    }//end commentDisplay

    function commentSave($data){
        $data['PostComment']['post_id'] = explode('/', parse_url($data['params'])['path'])['3'];
        $data['PostComment']['related_id'] = 1;
        if($data['PostComment']['related_id'] == 0){
            $data['PostComment']['comment_layer'] = 1;
        }else{
            $relatedcommentLayer = $this->find('first', array(
                   'conditions' => array('PostComment.id' => $data['PostComment']['related_id']),
                   'fields' => array('PostComment.comment_layer')
              ));
            $data['PostComment']['comment_layer'] = $relatedcommentLayer['PostComment']['comment_layer'] + 1;
        }
        // pr($data);
        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }//end commentSave

}//end Postmodel

