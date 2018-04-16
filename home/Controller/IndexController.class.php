<?php

/**
 * 测试控制器
 * Class IndexController
 */
class IndexController extends BaseController{

    /**
     *
     */
    public function index(){


        echo strtotime("2018-04-08 00:00:00");


    }

    /**从一个纯数字的数组中找出最大的数,最小的数也同样算法
     * @param  输入数组
     * @return 最大的数
     */
    private function getMaxNumber($arrayNum){


        if(!is_array($arrayNum)){
            die('no array put in!');
        }else{
            $len = count($arrayNum);
            $maxNum = $arrayNum[0];
            for($i = 0;$i<$len;$i++){
                if($arrayNum[$i] > $maxNum){
                    $maxNum = $arrayNum[$i];
                }
            }
            return $maxNum;
        }

    }

    /**
     * @param $arrayNum
     */
    private function countNum($arrayNum){

        $len = count($arrayNum);
        $countArr = array();
        for($i = 0; $i < $len; $i++){

            if(!isset($countArr[$arrayNum[$i]])){
                $countArr[$arrayNum[$i]]=1;

            }else{
                $countArr[$arrayNum[$i]]++;
            }
        }

        foreach ($countArr as $key => $value){

            echo "this num  ".$key." is appear ".$value."  numbers<br>";

        }

    }


    /**
     * @param $maxWeight
     * @param $arrayWidget
     */
    private function getBag($maxWeight, $arrayWidget){

            $tempBag = array();

            while ($this->countWeight($tempBag)<$maxWeight){


                $index = $this->getMaxValue($arrayWidget);


                $arrayWidget[$index]['s']=1;



                array_push($tempBag,$arrayWidget[$index]);


                if($this->countWeight($tempBag)>$maxWeight){

                    array_pop($tempBag);

                    break;


                }




            }

            return $tempBag;


    }

    /**
     * @param $arr
     * @return int|string
     */
    private function getMaxValue($arr){

        $maxValue = 0;
        $index = 0;

        foreach ($arr as $key => $value){


            if($value['p'] > $maxValue && $value['s']==0){
                $maxValue = $value['p'];
                $index = $key;
            }
        }

        return $index;

    }


    private function countWeight($arr){

        $weight = 0;

        foreach ($arr as $key=>$value){

            $weight+=$value['w'];
        }

        return $weight;
    }


    /**
     *阿拉伯数字转换为中文数字
     */
    private function changeCheseNum($num){



        $lowNum = array('0'=>'零','1'=>'一','2'=>'二','3'=>'三','4'=>'四','5'=>'五','6'=>'六','7'=>'七','8'=>'八','9'=>'九');

        $highNum = array('1'=>'','2'=>'十','3'=>'百','4'=>'千','5'=>'万','6'=>'十','7'=>'百','8'=>'千','9'=>'亿','10'=>'十亿');

        $numArr = $this->getEveryNum($num);



        $count = count($numArr);

        $str = '';


        for($i = $count; $i>=1; $i--){

                if($numArr[$i]>0){


                    $str.=($lowNum[$numArr[$i]].$highNum[$i]);


                }


                else if($numArr[$i]==0 && (isset($numArr[$i-1]))){

                    if($numArr[$i-1]!=0)
                        $str.=($lowNum[$numArr[$i]]);

                    if($i==5){
                        $str.='万';
                    }

                }

        }


        return $str;


    }

    private function getNumWeiShu($num){


        if($num > 9){

            $count = 1;

            while ($num / 10 > 0){

                $count++;

                $num = ($num / 10);

                if($num < 10) break;

            }

            return $count;


        }else{


            return 1;
        }

    }


    /**
     * @param $num
     * @return float|int
     */
    private function getEveryNum($num){


        $numArr = array();

        $wei = $this->getNumWeiShu($num);



        for($i = $wei;$i>=1;$i--){

            $tempnum = intval($num/(pow(10,$i-1)));

            $numArr[$i] = $tempnum;

            $num = $num-($tempnum*pow(10,$i-1));


        }

        return $numArr;

    }


    /**
     *
     */
    private function flushWater(){


        $obj = json_encode(array(array('size'=>8,'water'=>4),array('size'=>5,'water'=>4),array('size'=>3,'water'=>0)));


        $water = array(array('size'=>8,'water'=>8),array('size'=>5,'water'=>0),array('size'=>3,'water'=>0));


        $status = array();


        array_push($status,json_encode($water));

        $step = array();

        $k = 0;


            while (10>$k++){


                for($i=0;$i<3;$i++){

                    for ($j=0;$j<3;$j++){

                        if($i!=$j){


                            if($this->checkFlush($water[$i],$water[$j])){

                                if(count($status)==1 ){
                                    $this->doFlush($water[$i],$water[$j]);
                                    array_push($status,json_encode($water));
                                    array_push($step,"$i-->$j");

                                }

                                else{

                                    if(!in_array(json_encode($water),$status)){
                                        $this->doFlush($water[$i],$water[$j]);
                                        array_push($status,json_encode($water));
                                        array_push($step,"$i-->$j");


                                    }

                                }





                            }

                        }


                    }

                }
            }


        var_dump($step);

            echo "<br>";
            var_dump($status);

        }




    private function doFlush(&$water1,&$water2){



        if($water1['water']<$water2['size']-$water2['water']){

            $water2['water']+=$water1['water'];

            $water1['water'] = 0;




        }else{



            $water1['water'] = $water1['water']-($water2['size']-$water2['water']);

            $water2['water'] = $water2['size'];



        }





    }


    private function checkFlush(&$water1,&$water2){

        if($water1['water']>0 && $water2['water']<$water2['size'])
            return true;
        else
            return false;

    }

}