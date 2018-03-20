<?php

App::uses('AppModel', 'Model');

class Post extends AppModel {
    public $name = 'Post';

    //参考
    //http://www.webopixel.net/cakephp/259.html
    public $hasAndBelongsToMany = array(
        'MstPosttag' => array(
            'className' => 'MstPosttag',
            'joinTable' => 'post_tags',
            'foreignKey' => 'post_id',
            'associationForeignKey' => 'tagname_id',
            'unique' => true
        )
    );


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
                                            'fields' => array('Post.id','Post.title', 'Post.body', 'Post.created'),
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


    // public function accesslog($userIp, $referer, $searchwords){
    public function accesslog($searchwords){
      if(preg_match('/_/', $searchwords)){
          $searchwords = implode(' ', explode('_', $searchwords));
      }
      pr($searchwords);
      if(!isset($_SERVER['HTTP_REFERER'])){
          $_SERVER['HTTP_REFERER'] = 'unknown';
      }
      $url = parse_url(Router::url(NULL, true))['path'];
      $access = $url . '_' . $_SERVER['REMOTE_ADDR'] . '_' . $_SERVER['HTTP_REFERER'] . '_' . $searchwords;
      pr($access);
      $this->log($access, 'access');
    }

    public function stringtoConditions($string){
        $settings = array(
            array('field' => 'Post.title', 'type' => 'LIKE'),
            array('field' => 'Post.body' , 'type' => 'LIKE'),
            // array('field' => 'Post.id' , 'type' => 'FUNCTION', 'function' => 'tagSearch')
            array('type' => 'FUNCTION', 'function' => 'tagSearch')
        );
        $searchWords = mb_ereg_replace("(\s|　)", ' ', $string);
        $searchWords = explode(' ',$searchWords);
        $searchWords = array_filter($searchWords, "strlen");
        foreach($searchWords as $word){
            $condTmp = array();
            foreach ($settings as $s){
                if ($s['type'] == 'LIKE'){
                    $condTmp[$s['field'].' LIKE' ] = '%'. $word . '%';
                }
                if ($s['type'] == 'FUNCTION'){
                    $condTmp[] = $this->$s['function']($word);
                }
            }
            $conditions[] = array('OR' => $condTmp);
        }
        $conditions[] = array('Post.del_flag' => 0);
        return $conditions;
    }

    public function accesslogSave($searchwords){
        //noneはvalueの値がない場合の挿入値
        //fieldを追加する場合は下記logSettingsに条件と値追加
/*
        $logSettings = array(
            array('field' => 'url', 'value' => parse_url(Router::url(NULL, true))['path']),
            array('field' => 'address', 'value' => $_SERVER['REMOTE_ADDR']),
            array('field' => 'refer' , 'value' => $_SERVER['HTTP_REFERER'], 'none' => 'unknown'),
            array('field' => 'searchwords' , 'value' => $searchwords, 'none' => "")
        );
        $savelog = array();
        foreach($logSettings as $v){
            if(isset($v['value'])){
                $savelog['PostAccess'][$v['field']] = $v['value'];
            }else{
                $savelog['PostAccess'][$v['field']] = $v['none'];
            }
        }
*/
        $savelog['PostAccess']['url'] = parse_url(Router::url(NULL, true))['path'];
        $savelog['PostAccess']['address'] = $_SERVER['REMOTE_ADDR'];
        $savelog['PostAccess']['refer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'unknown';
        $savelog['PostAccess']['searchwords'] = isset($searchwords) ? $searchwords : '';
        //PHP7系だと右記のように表記：$savelog['PostAccess']['searchwords'] = $searchwords ?? '';
        //原因：valueが複雑じゃないから、配列で各メリットがない。次元が低い。

        App::uses('PostAccess','Model');
        $this->PostAccess = new PostAccess;
        $this->PostAccess->set($savelog);
        $this->PostAccess->save($savelog, false);
    }//end accesslogSave

    public function tagsearchJoins($words) {
        return [
                'fields' => 'id',
                'joins' => [
                    [
                        'type' => 'inner',
                        'table' => 'post_tags',
                        'conditions' => 'Post.id = post_tags.post_id'
                    ],
                    [
                        'type' => 'inner',
                        'table' => 'mst_posttags',
                        'conditions' => 'post_tags.tagname_id = mst_posttags.id'
                    ],
                ],
                'conditions' => ['mst_posttags.tagname LIKE' => '%'. $words . '%']
            ];
    }//end getJoins


    public function tagSearch($words){
        $joinParam = $this->tagsearchJoins($words);
        $searchBytags = $this->find('all', $joinParam);
        $arrayId = array();
        foreach($searchBytags as $v){
            $arrayId['Post.id'][] = $v['Post']['id'];
        }
        return $arrayId;
    }//end tagSearch

}//end Postmodel

