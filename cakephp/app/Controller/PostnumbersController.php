<?php
#error_reporting(0);

class PostnumbersController extends AppController {    //AppControllerを継承して使う

    public $components = array('RequestHandler', 'Session');

    //validationのテスト用　本番では公開せず
    public function test() {
        $data=array(
          'num7' => '1234567',
        );
        pr($this->Postnumber->findData($data));
        $this->render('index');
    }

    //郵便番号検索処理
    public function index() {
      $user = $this->Auth->user();
      // ビューに渡す
      $this->set('user', $user);
      // 中に入っている配列を確認（必要なければ消してください。）
      var_dump($user);
      //pr($this->Session);
       if ($this->request->is('post')) {
            //ajaxの場合
            if ($this->RequestHandler->isAjax()) {
            //不必要な情報がフォームで送られていないか確認
            //controllerで0と未入力の違いをstrlen関数を使って整理する方法があり。
            if(!isset($this->request->data['num7'])){
                $return['error']['post'] = '必要なフィールドがpostされていません';
                //throw new NotFoundException("");//404エラーを返す
                echo json_encode($return);
                exit();
            }
            //モデルのfindDataの関数の中でvalidationチェックの関数tionForAjaxを呼び出している
            $return = $this->Postnumber->validationForAjax($this->request->data);
            if($return['status']){
            echo json_encode($this->Postnumber->findData($this->request->data));
            exit();
            }else{
            echo json_encode($return);
            exit();//右記よりも早い$this->autoRender = false;
            }//if $return['status'])　
          }//if rquest handler ajax終わり
      }//if post終わり
   }#index終わり
}#PostnumberController終わり
