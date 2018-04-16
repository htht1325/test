<?php
/**
 * Created by PhpStorm.
 * User: nantei
 * Date: 2018/4/9
 * Time: 上午10:07
 */
class UserController extends BaseController{



    public function userList(){



        if(!empty($_POST)){

            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
            $userModel = new UserModel();
            $users = $userModel->getUsers($page,$rows);
            $count = count($users);
            $jsonArr = array("total"=>$count,"rows"=>$users);
            $this->jsonMsg($jsonArr);

        }else{

            $this->render();
        }


    }



    public function addUser(){


        if(!empty($_POST)){

            echo "ok";

        }else{

            $this->render();
        }



    }

}