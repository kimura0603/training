<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class UserAutologin extends AppModel {
    //user_idはパスワードとIDの合致に利用
    public $name = 'UserAutologin';

}

