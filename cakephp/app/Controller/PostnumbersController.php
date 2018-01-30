<?php
#error_reporting(0);

class PostnumbersController extends AppController {    //AppControllerを継承して使う

    public $components = array('RequestHandler');


    public function test() {
        $data=array(
          'num7' => '1234',
        );
        $this->Postnumber->set($data);
        var_dump($this->Postnumber->validates());
        pr($this->Postnumber->validationErrors);
        if($this->Postnumber->validates()){
            echo "true";
        }else{
            $return['error']['post'] = $this->Postnumber->validationErrors['num7']['0'];
            echo $return['error']['post'];
        }
        $this->render('index');
    }


    public function index() {
       //郵便番号検索処理
       //php
       $addnum = '';
       if ($this->request->is('post')) {
           //ajaxの場合
           //if ($this->request->is('ajax')) {
           //$postnumber = ["Postnumber"];
           //$this->set(test, $postnumber);
           //var_dump($postnumber);
            if ($this->RequestHandler->isAjax()) {
            //ajaxなら上記,cakeなら下記
            //$postnumber = $_POST["postData"];
            //var_dump($this->request);
            $postnumber = '';
            if(!isset($this->request->data['num7'])){
                $return['error']['post'] = '必要なフィールドがpostされていません';
                //throw new NotFoundException("");
                echo json_encode($return);
                exit();
            }
            $postnumber = $this->request->data['num7'];
            //unset($this->request->data['Postnumber']);
            //if (count($this->request->data)){
            //  $return['error']['post'] = 'ゴミが入ってる';
            //  echo json_encode($return);
            //  exit();
            //}
            //$return = array();
            //pr($this->request->data);
            $this->Postnumber->set($this->request->data);
            //pr($this->request->data);
            if ($this->Postnumber->validates()) {
            /*
            if(!strlen($postnumber)){
                           $return['error']['post'] = '郵便番号が未入力ですよ！';
                           #var_dump($return);
                           //$this->autoRender = false;
                           //$this->response->type('json');
                           //return json_encode($return);
                           //$test = "郵便番号が未入力ですよ！";
                           //echo json_encode($test);
                           echo json_encode($return);
                           exit();
                 //exit();
                 //$this->set('return', $return);
            }elseif(!preg_match("/^\d{7}$/",$postnumber)){
                        //if(empty($this->request->data["Postnumber"]["num7"])){
                             $return['error']['post'] = '「郵便番号」は半角数字でハイフンなしの7字でご入力ください。';
                             //pr($return);
                             //http://wp.tech-style.info/archives/609
                             $this->autoRender = false;
                             $this->response->type('json');
                             return json_encode($return);
                             //exit();
                             //$this->set('return', $return);
                   //}elseif(!preg_match("/^[0-9]{7,7}$/",$_POST["Postnumber"]["num7"])){

         }else{
            $addnum = '';
            $addresses = $this->Postnumber->find('all',
                        //array('conditions' => array('Postnumber.num7' => $_POST['num7']),
                        array('conditions' => array('Postnumber.num7' => $postnumber),
                              'fields' => array('Postnumber.num7','Postnumber.address1', 'Postnumber.address2', 'Postnumber.address3'),
                              'order' => array('Postnumber.id ASC')
                            )
                    );
            $addnum = count($addresses);
            if($addnum == 0){
                 $return['error']['post'] = '該当する郵便番号がありませんでした。検索しなおしてください。';
                 //$this->autoRender = false;
                 $this->response->type('json');
                 echo json_encode($return);
                 exit();
                 //$this->set('return', $return);
            //それ以外
            }else{*/
                $addnum = '';
                $addresses = $this->Postnumber->find('all',
                        //array('conditions' => array('Postnumber.num7' => $_POST['num7']),
                        array('conditions' => array('Postnumber.num7' => $postnumber),
                              'fields' => array('Postnumber.num7','Postnumber.address1', 'Postnumber.address2', 'Postnumber.address3'),
                              'order' => array('Postnumber.id ASC')
                            )
                    );
                  $addnum = count($addresses);
                  $merge_address['error'] = 0;
                  $merge_address['Postnumber'] = array();
                  //pr($addresses);
                  //$i = 1;
                  /*
                  foreach ($addresses as $key){
                  $merge_address['Postnumber'][$i] = $key['Postnumber']['address1'];
                  $merge_address['Postnumber'][$i] .= $key['Postnumber']['address2'];
                  $merge_address['Postnumber'][$i] .= $key['Postnumber']['address3'];
                        $i += 1;
                  }
                  */
                  //$merge_address = array();
                  $merge_address['Postnumber'][] = 'dummy';/* 0番目予約 */
                  foreach ($addresses as $a){
                      $tmp = '';
                      $tmp .= $a['Postnumber']['address1'];
                      $tmp .= $a['Postnumber']['address2'];
                      $tmp .= $a['Postnumber']['address3'];
                      $merge_address['Postnumber'][] = $tmp;
                  }
                  //$merge_address['Postnumber'][] = '3番目・最後';/* 0番目予約 */
                  //pr($merge_address);
                      //$this->set('addresses', $merge_address);
                      //$this->autoRender = false;
                      //$this->response->type('json');
                    //pr("validation success!");
                      echo json_encode($merge_address);
                      exit();
            }else{
              $return['error']['post'] = $this->Postnumber->validationErrors['num7']['0'];
              //pr("validation error!");
              echo json_encode($return);
              exit();
        }//if validation終わり
      //echo "</br>";
      //var_dump($merge_address);
      //var_dump(count($addresses));
    // }//if postnumber判定終わり

   }//if rquest handler ajax終わり

      }//if post終わり
   }#index終わり
}#PostnumberController終わり
