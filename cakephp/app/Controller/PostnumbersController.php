<?php
#error_reporting(0);

class PostnumbersController extends AppController {    //AppControllerを継承して使う

    public $components = array('RequestHandler');

    public function index() {
       //郵便番号検索処理
       //php
       $addnum = "";
       if ($this->request->is('post')) {
          try {
           //ajaxの場合
           //if ($this->request->is('ajax')) {
            if ($this->RequestHandler->isAjax()) {
            //ajaxなら上記,cakeなら下記
            //$postnumber = $_POST["postData"];
            //var_dump($this->request);
            $postnumber = "";
            #TODO:要削除
            $postnumber = $this->request->data["Postnumber"];
            //pr($postnumber);
            $return = array();
            if(!preg_match("/^[0-9]{7,7}$/",$postnumber)){
            //if(empty($this->request->data["Postnumber"]["num7"])){
                 $return["error"]["post"] = "「郵便番号」は半角数字でハイフンなしの7字でご入力ください。";
                 //pr($return);
                 //http://wp.tech-style.info/archives/609
                 $this->autoRender = false;
                 $this->response->type('json');
                 return json_encode($return);
                 //exit();
                 //$this->set('return', $return);
            }elseif(empty($postnumber)){
                           $return["error"]["post"] = "郵便番号が未入力ですよ！";
                           #var_dump($return);
                           $this->autoRender = false;
                           $this->response->type('json');
                           return json_encode($return);
                           //exit();
                           //$this->set('return', $return);
                   //}elseif(!preg_match("/^[0-9]{7,7}$/",$_POST["Postnumber"]["num7"])){

         }else{
            $addnum = "";
            $addresses = $this->Postnumber->find('all',
                        //array('conditions' => array('Postnumber.num7' => $_POST['num7']),
                        array('conditions' => array('Postnumber.num7' => $postnumber),
                              'fields' => array('Postnumber.num7','Postnumber.address1', 'Postnumber.address2', 'Postnumber.address3'),
                              'order' => array('Postnumber.id ASC')
                            )
                    );
            $addnum = count($addresses);
            if($addnum == 0){
                 $return["error"]["post"] = "該当する郵便番号がありませんでした。検索しなおしてください。";
                 $this->autoRender = false;
                 $this->response->type('json');
                 return json_encode($return);
                 //exit();
                 //$this->set('return', $return);
            //それ以外
            }else{
                  $merge_address['error'] = 0;
                  $merge_address['Postnumber'] = array();
                  for ($i = 0; $i < $addnum;$i++){
                      //$merge_address[$i]['Postnumber']['num7'] = $addresses[$i]['Postnumber']['num7'];
                      //$merge_address[$i]['Postnumber']['address'] = $addresses[$i]['Postnumber']['address1'];
                      //$merge_address[$i]['Postnumber']['address'] .= $addresses[$i]['Postnumber']['address2'];
                      //$merge_address[$i]['Postnumber']['address'] .= $addresses[$i]['Postnumber']['address3'];
                      //$merge_address['Postnumber'][$i+1] = $addresses[$i]['Postnumber']['address1'];
                      //$merge_address['Postnumber'][$i+1] .= $addresses[$i]['Postnumber']['address2'];
                      //$merge_address['Postnumber'][$i+1] .= $addresses[$i]['Postnumber']['address3'];
                      $merge_address['Postnumber'][$i+1] = $addresses[$i]['Postnumber']['address1'];
                      $merge_address['Postnumber'][$i+1] .= $addresses[$i]['Postnumber']['address2'];
                      $merge_address['Postnumber'][$i+1] .= $addresses[$i]['Postnumber']['address3'];
                      }//for文終わり
                      //pr($addnum);
                      //pr($merge_address);
                      //$this->set('addresses', $merge_address);
                      $this->autoRender = false;
                      $this->response->type('json');
                      return json_encode($merge_address);
                      //exit();
            }//if $addnum == 0 else　終わり
      //echo "</br>";
      //var_dump($merge_address);
      //var_dump(count($addresses));
     }//if postnumber判定終わり

   }//if rquest handler ajax終わり

         } catch (Exception $e) {
        $_POST['is_error'] = true;
        $_POST['message'] = $e->getMessage();}#try&catch終わり

      }//if post終わり
   }#index終わり
}#PostnumberController終わり
