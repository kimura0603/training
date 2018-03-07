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
                  'fields' => array('PostComment.id','PostComment.layer_1','PostComment.layer_2','PostComment.layer_3','PostComment.name','PostComment.comment','PostComment.created'),
                  'order' => array('PostComment.layer_1','PostComment.layer_2','PostComment.layer_3')
                  ));
    }//end commentDisplay

    function commentSave($data){
        $data['PostComment']['post_id'] = explode('/', parse_url($data['params'])['path'])['3'];
        if($data['PostComment']['divname'] == 'top'){
                $max_layer1 = $this->find('first', array('fields' => array('max(PostComment.layer_1) as max_layer1'), 'conditions' => array('PostComment.post_id' => $data['PostComment']['post_id'])));
                $data['PostComment']['layer_1'] = $max_layer1['0']['max_layer1'] + 1;
                $data['PostComment']['layer_2'] = 0;
                $data['PostComment']['layer_3'] = 0;
        }else{
            $divname = explode('-', $data['PostComment']['divname']);
            $divCount = count($divname);
            $start = microtime(true);
            for($i= 0; $i < $divCount; ++$i){
                  $j = $i + 1;
                  $data['PostComment']["layer_$j"] = $divname[$i];
                  if (microtime(true) - $start > 5) { break;}
            }
            $start = microtime(true);
            $j_max = $j;
            $condition = array('PostComment.post_id' => $data['PostComment']['post_id']);
            for($j= 1; $j <= $j_max; ++$j){
                if($data['PostComment']["layer_$j"] != 0){
                    $condition += array("PostComment.layer_$j" => $data['PostComment']["layer_$j"]);
                    continue;
                }else{
                    $max_layer_value = $this->find('first', array('fields' => array("max(PostComment.layer_$j) as max_layer_value"), 'conditions' => $condition));
                    $data['PostComment']["layer_$j"] = $max_layer_value['0']['max_layer_value'] + 1;
                    break;
                }
                if (microtime(true) - $start > 5) { break;}
            }//end for
        }// end if $data['PostComment']['divname'] = 'top'
        //
        //
        //       if($divname[$i] != 0){
        //             continue;
        //       }else{
        //         if($divname[$i] != 0){
        //             $max_layer1 = $this->find('first', array('fields' => array('max(PostComment.layer_1) as max_layer1'), 'condition' => array('PostComment.post_id' => $data['PostComment']['post_id'])));
        //       }
        //
        //
        //       $data['PostComment']["layer_$j"] = $divname[$j];
        //
        // for($i= $divCount; $i > 0;){
        //       $j = $i - 1;
        //       $data['PostComment']["layer_$i"] = $divname[$j];
        //             $i += -1;
        //       //タイムアウト時
        //       if (microtime(true) - $start > 5) { break; }
        // }
        // $start = microtime(true);
        // for($i= $divCount; $i > 0;){
        //       $j = $i - 1;
        //       if($divname[$j] == 0){
        //             $i += -1;
        //             continue;
        //       }else{
        //           $divname[$j] = $divname[$j] + 1;
        //           $data['PostComment']["layer_$i"] = $divname[$j];
        //           break;
        //       }
        //       //タイムアウト時
        //       if (microtime(true) - $start > 5) { break; }
        // }
        // pr($max_layer1);
        //保存処理
        $data['PostComment']['name'] = 'test';
        $data['PostComment']['open'] = 0;
        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }//end commentSave

}//end Postmodel

