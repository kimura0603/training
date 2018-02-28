<?php

App::uses('AppModel', 'Model');

class UserUnique extends AppModel {
  //user_idはパスワードとIDの合致に利用
    public $name = 'UserUnique';

}

