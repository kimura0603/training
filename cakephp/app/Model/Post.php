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

    //
    public function recommendPost($id, $recommendNum){
        //下記（１）〜（３）の手順で関連記事をピックアップ
        //(1)閲覧している記事のカテゴリを抽出
        $postCategory = $this->find('first', array('conditions' => array('id' => $id), 'fields' => array('category1','category2','category3')));
        $postCategory = array_filter(array_values($postCategory['Post']), 'strlen');
        //（２）$idの記事のカテゴリ$postCategoryに該当する記事抽出
        foreach($postCategory as $v){
              $sameCategoryposts = $this->find('all', array('conditions' => array('del_flag' => 0, 'id !=' => $id,'or' => array('category1' => $v,'category2' => $v,'category3' => $v)), 'fields' => array('id','title','category1','category2','category3')));
              // $sameCategoryposts[] = $this->Post->find('all', array('conditions' => array('id !=' => $id,'or' => array('category1' => $v,'category2' => $v,'category3' => $v)), 'fields' => array('id','title','category1','category2','category3')));
              foreach($sameCategoryposts as $v2){
                      $catPostid[] = $v2['Post']['id'];
              }
        }
        //(３)引用記事のカテゴリを多く含む記事のidをソート
        $sort_catPostid = array_count_values($catPostid);
        arsort($sort_catPostid);
        $sort_catPostid = array_keys($sort_catPostid);
        $count = count($sort_catPostid);
        for($i=0;$i<$recommendNum;++$i){
            if($i >= $count){
                  break;
            }
            $recommendId[$i] = $sort_catPostid[$i];
        }
        return $this->find('all', array('conditions' => array('id' => $recommendId, 'del_flag' => 0), 'fields' => array('id','title'),'order' => "FIELD(id, ". implode(',',$recommendId).")"));
    }//end function



}//end Postmodel

