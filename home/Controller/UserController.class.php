<?php
class UserController extends BaseController{
    
    public function index(){
        
        $membermodel = new MemberModel();
        var_dump($membermodel->select(array("id"=>"U1520924867")));
    }

    public function addUser(){


        $this->render();


    }
}