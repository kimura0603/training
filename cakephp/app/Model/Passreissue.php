<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Passreissue extends AppModel {
  //user_idはパスワードとIDの合致に利用
  public $name = 'Passreissue';

}

