<?php

App::uses('AppModel', 'Model');

class Post extends AppModel {
    public $name = 'Post';

    public function topPost($n){
        App::import('Model','PostAccess');
        $this->PostAccess = new PostAccess;
        $postView =  $this->PostAccess->find('all', array(
                                                        'conditions' => array('url LIKE' => '/posts/view/'.'%'),
                                                        'fields' => array('url',  'count(url) as viewcount'),
                                                        'group' => array('url'),
                                                        'limit' => $n,
                                                        'order' => array('viewcount DESC')));
        // pr($postView);
        $topBlogid = array();
        foreach($postView as $values){
            $topBlogid[] = substr($values['PostAccess']['url'], -1);
        }
        // modelから引っ張ってポストに
        return $this->find('all', array(
                                            'conditions' => array('id' => $topBlogid,'del_flag'=> '0'),
                                            'fields' => array('id','title'),
                                            'order' => "FIELD(id, ". implode(',',$topBlogid).")",));
    }//end function topBlog

}//end Postmodel

