<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public function genRandStr($length, $charSet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'){
        $retStr = '';
        $randMax =  strlen($charSet) - 1;
        for ($i = 0; $i < $length; ++$i) {
            $retStr .= $charSet[rand(0, $randMax)];
        }
        return $retStr;
    }

    public function match($data){
      return $this->data[$this->name]['password'] === $data['password2'];
    }//match終わり
    /*
    function begin() {
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $db->begin($this);
    }

    function commit() {
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $db->commit($this);
    }

    function rollback() {
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $db->rollback($this);
    }
    function lock($type="WRITE"){
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $q = "LOCK TABLE {$this->useTable} {$type}, {$this->useTable} AS {$this->name} {$type};";
        return $this->query($q);
    }
    function unlock(){
        return $this->query("UNLOCK TABLES");
    }
    */

}
