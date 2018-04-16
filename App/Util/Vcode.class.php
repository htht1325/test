<?php
/**
 * 验证码生成类
 * @author Administrator
 *
 */
class Vcode{
    
    private $width; //生成图片验证码的宽度
    private $height;  //生成图片验证码的高度
    private $nums;   //生成图片验证码的位数
    private $image;
    
    function __construct($width,$height,$nums){
        $this->width = $width;
        $this->height = $height;
        $this->nums = $nums;
    }
    
    public function createVcode(){
        if($this->width=='' || $this->height=='' || $this->nums==''){
            die('请先初始化验证码参数!');
        }else{

            $this->createImage($this->width,$this->height,$this->nums);
            
        }
    }
    
    private function createImage($width,$height,$nums){

        session_start();

        $image = imagecreatetruecolor($width, $height);
        $bgcolor = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgcolor);

        $captch_code = '';

        for($i=0;$i<$nums;$i++) {

            $fontsize = 6;

            $fontcolor = imagecolorallocate($image, rand(0, 120), rand(0, 120),rand(0, 120));

            $data = 'abcdefghijkmnpqrstuvwxy3456789';

            $fontcontent = substr($data, rand(0, strlen($data)-1), 1);

            $captch_code .= $fontcontent;

            $x = ($i*100/4) + rand(5, 10);

            $y = rand(5, 10);

            imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);


        }
        $_SESSION['authcode'] = $captch_code;

        //增加点干扰元素
        for($i=0; $i<$width;$i++) {
            $pointcolor = imagecolorallocate($image, rand(50,200), rand(50,200), rand(50,200));
            imagesetpixel($image, rand(1,$width), rand(1,$height), $pointcolor);
        }

        //增加线干扰元素
        for($i=0;$i<3;$i++) {
            $linecolor = imagecolorallocate($image, rand(80,220), rand(80,220), rand(80, 220));
            imageline($image, rand(1,99), rand(1,29), rand(1,99), rand(1,29), $linecolor);
        }


        header('content-type:image/png');
        imagepng($image);

        imagedestroy($image);
        
    }
    
    /**
     * 返回指定位数的随机字符串
     * @return string
     */
    private function createRandomStr(){
        
        $randArr = array('2','3','4','5','6','7','8','9','A','B','C','D','E','F','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');
        $totalNum = count($randArr);
        $randStr = '';
        for($i=0;$i<$this->nums;$i++){
            mt_srand();
            $randNum = mt_rand(0, $totalNum-1);
            $randStr.=$randArr[$randNum];
        }
        return $randStr;
        
    }
    
    
}