<?php
/**
 * Created by PhpStorm.
 * User: nantei
 * Date: 2018/4/6
 * Time: 上午11:08
 */
class UtilController extends BaseController{


    public function createVcode(){

        $image = new Vcode(100,30,4);
        $image->createVcode();

    }


    /**菜单生成函数
     * @return array菜单的数组
     */
    public function createMenu(){

        $menuModel = new MenuModel();
        $where['pid'] = 0;
        $menuArr = array();
        $iconArr = array();
        $pMenu = $menuModel->select($where);
        foreach ($pMenu as $menu => $value){

            $subMenu = $menuModel->select(array('pid'=>$value['id']));

            $iconArr = array_merge($iconArr,array($value['title']=>$value['icon']));


            if($subMenu){

                $tempArray = array($value['title']=>$subMenu);

                $menuArr = array_merge($menuArr,$tempArray);


            }else{

                $tempArray = array($value['title']=>'');

                $menuArr = array_merge($menuArr,$tempArray);
            }


        }

        $this->assign('iconArr',$iconArr);

        return array($menuArr,$iconArr);

    }

    /**
     * 上传文件
     */
    public function uploadFile(){

        $fileupload = new FileUpload('./Upload');
        $fileupload->upload();

    }

}