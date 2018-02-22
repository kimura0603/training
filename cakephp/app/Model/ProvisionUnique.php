<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class ProvisionUnique extends AppModel {
  //user_idはパスワードとIDの合致に利用
  public $name = 'ProvisionUnique';

}

