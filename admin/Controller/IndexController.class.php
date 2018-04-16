<?php
/**
 * Created by PhpStorm.
 * User: nantei
 * Date: 2018/4/5
 * Time: 上午9:06
 */

class IndexController extends BaseController{



    public function index(){

        $this->render();

    }


    public function main(){


        $util = new UtilController();

        $dataArr = $util->createMenu();

        $this->assign('menuArr',$dataArr[0]);
        $this->assign('iconArr',$dataArr[1]);

        $this->render();
    }


    public function login(){


        if(!empty($_POST)){


            echo "hello";


        }else{

            $this->render();
        }


    }


}