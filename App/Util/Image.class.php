<?php
/**
 * 图象处理类,对图象进行缩放,加水印和裁剪
 * @author Administrator
 *
 */
class Image{
    
    private $filepath;  //图片保存的路径

    private $path;

    private $picname;
    
    function __construct($filepath){
        if(!file_exists($filepath)){
            die('图片文件不存在!');
        }else{
           $this->filepath = $filepath;
           $this->path = dirname($filepath);
           $this->picname = basename($filepath);


        }
         
    }
    /**
     * 生成图象缩略图
     * @param unknown $width
     * @param unknown $height
     * @param string $qz
     */
    function thumb($width,$height,$qz="th_"){
        
        $imginfo = $this->getInfo();
        $srcImg = $this->getImg($imginfo);
        $size = $this->getNewSize($width, $height, $imginfo);
        $newImg = $this->kidOfImage($srcImg, $size, $imginfo);
        return $this->createNewImage($newImg, $qz.$this->picname, $imginfo);
        
    }
    /**
     * 创建缩略图片
     * @param unknown $newImg
     * @param unknown $newName
     * @param unknown $imginfo
     * @return string
     */
    function createNewImage($newImg,$newName,$imginfo){

        $newName = $this->path.'/'.$newName;

        switch ($imginfo['type']){
            case 1:
                $result = imagegif($newImg,$newName,100);
                break;
            case 2:
                $result = imagejpeg($newImg,$newName,100);
                break;
            case 3:
                $result = imagepng($newImg,$newName,100);
                break;
            
        }
        imagedestroy($newImg);
        return $newName;
    }
    
    /**
     * 处理带有透明度的图片
     * @param unknown $srcImg
     * @param unknown $size
     * @param unknown $imgInfo
     * @return resource
     */
    function kidOfImage($srcImg,$size,$imgInfo){
        $newImg = imagecreatetruecolor($size['width'], $size['height']);
        $otsc = imagecolortransparent($newImg);
        if($otsc>=0 && $otsc<imagecolorstotal($srcImg)){
            $transparentcolor = imagecolorsforindex($srcImg, $otsc);
            $newtransparentcolor = imagecolorallocate($newImg, $transparentcolor['red'], $transparentcolor['green'], $transparentcolor['blue']);
            imagefill($newImg, 0, 0, $newtransparentcolor);
            imagecolortransparent($newImg,$newtransparentcolor);
        }
        imagecopyresized($newImg, $srcImg, 0, 0, 0, 0, $size['width'], $size['height'], $imgInfo['width'], $imgInfo['height']);
        imagedestroy($srcImg);
        return $newImg;
    }
    
    /**
     * 获取图象基本信息
     * @return unknown
     */
    private function getInfo(){
        $data = getimagesize($this->filepath);
        $imginfo["width"] = $data[0];
        $imginfo["height"] = $data[1];
        $imginfo["type"] = $data[2];
        return $imginfo;
    }
    
    /**
     * 根据源图象文件创建图象资源
     * @param unknown $imginfo
     * @return boolean|resource
     */
    private function getImg($imginfo){
        switch ($imginfo["type"]){
            case 1:
                $img = imagecreatefromgif($this->filepath);
                break;
            case 2:
                $img = imagecreatefromjpeg($this->filepath);
                break;
            case 3:
                $img = imagecreatefrompng($this->filepath);
                break;
            default:
                return false;
                break;
        }
        return $img;
    }
    /**
     * 计算获取缩略图的宽度和高度,等比缩放
     * @param unknown $width
     * @param unknown $height
     * @param unknown $imgInfo
     */
    private function getNewSize($width,$height,$imgInfo) {
        
        $size['width'] = $imgInfo['width'];
        $size['height'] = $imgInfo['height'];
        if($width<$imgInfo['width']){
            $size['width'] = $width;
        }
        if($height<$imgInfo['height']){
            $size['height'] = $height;
        }
        if($imgInfo['width']*$size['width'] > $imgInfo['height']*$size['height']){
            $size['height'] = round($imgInfo['height']*$size['width']/$imgInfo['width']);
        }else{
            $size['width'] = round($imgInfo['width']*$size['height']/$imgInfo['height']);
        }
        
        return $size;
        
    }
}