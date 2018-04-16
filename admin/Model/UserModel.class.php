<?php
/**
 * Created by PhpStorm.
 * User: nantei
 * Date: 2018/4/9
 * Time: 上午10:59
 */

class UserModel extends BaseModel{


    function __construct(){
        parent::__construct(__CLASS__);
    }

    function getUsers($page,$rows){


        $result = $this->select(array(),array('page'=>$page,'num'=>$rows));

        return $result;


    }
}