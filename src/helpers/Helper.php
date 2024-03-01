<?php

/**
 * @link https://gitee.com/myzero1/yii2-authz
 * @copyright Copyright (c) 2019-7357 myzero1
 * @license Apache2
 */

namespace myzero1\captcha\helpers;

/**
 * Class Helper provides some useful static methods.
 *
 * For all user.
 *
 * @author Myzero1 <myzero1@qq.com>
 * @since 0.0.1
 */
class Helper
{
    /**
     * @param int $minLen 4
     * @param int $maxLen 6
     * @param int $timeout 300
     * @param string $key myzero1自研
     * @param string $source 0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ我是中国人这是myzero1自研的验证码验证器
     * @return array $data ['id'=>'e539595922a2f20ac152f3597ccce86a','code'=>'1QUC',]
     */
    public static function getVerifyCode(
        $minLen=4,
        $maxLen=6, 
        $timeout=300,
        $key='myzero1自研',
        // $source='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ我是中国人这是myzero1自研的验证码验证器'
        $source='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    )
    {
        // myzero1\captcha\helpers::getVerifyCode()
        // $source='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ我是中国人这是myzero1自研的验证码验证器';
        // $minLen=4;
        // $maxLen=4;
        // $key='myzero1自研';
        // $timeout=300; // s

        $code='';
        $id='';

        $len=mt_rand($minLen, $maxLen);
        $sourceLen=mb_strlen($source, 'UTF-8');
        for ($i=0; $i < $len; $i++) {
            $randomNumber = mt_rand(0, $sourceLen-1);
            $code.=mb_substr($source, $randomNumber, 1, 'UTF-8');
        }

        $mod=intval(time()/$timeout);
        $str=sprintf('%s_%s_%s',$code,$key,$mod);
        $id=md5($str);

        $data=[
            'id'=>$id,
            'code'=>$code,
        ];

        // var_dump($data);exit;

        return $data;
    }

    /**
     * @param string $id e539595922a2f20ac152f3597ccce86a
     * @param string $code 1QUC
     * @param int $timeout 300
     * @param string $key myzero1自研
     * @return bool $ok true
     */
    public static function validate($id,$code,$timeout=300,$key='myzero1自研')
    {
        // $id='e539595922a2f20ac152f3597ccce86a';
        // $code='1QUC';

        $mod=intval(time()/$timeout);
        $str1=sprintf('%s_%s_%s',$code,$key,$mod);
        $str2=sprintf('%s_%s_%s',$code,$key,$mod+1);
        $id1=md5($str1);
        $id2=md5($str2);

        $ok=false;
        if ($id===$id1 || $id===$id2) {
            $ok=true;
        }

        // var_dump($ok);exit;

        return $ok;
    }

    /**
     * @param string $code 1QUC 不支持中文绘图
     * @return 
     */
    public static function draw(
        $code,
        $width = 100,
        $height = 30,
        $bgColour= [255, 255, 255],
        $fontSize = 14,
        $startLeftTopPoint = [10,5],
        $noiseSpot = 50,
        $noiseLine = 3,
        $imgFile = '',
        $base64 = false
    )
    {
        // $code='123aE6';
        // $width = 100;
        // $height = 30;
        // $bgColour= [255, 255, 255]; // rgb
        // $fontSize = 14; // 字体大小
        // $startLeftTopPoint = [10,5];
        // $noiseSpot = 50;
        // $noiseLine = 3;
        // $imgFile = 't.png';

        $colors=[];
        for ($i=0; $i < 3; $i++) { 
            $colors[$i]=self::randRgbColor();
        }

        $image = imagecreate($width, $height);
        $bgColor = imagecolorallocate($image, $bgColour[0], $bgColour[1], $bgColour[2]);
        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

        $len=mb_strlen($code, 'UTF-8');
        for ($i=0; $i < $len; $i++) {
            // $randomNumber = mt_rand(0, $sourceLen-1);
            // $code.=mb_substr($source, $randomNumber, 1, 'UTF-8');
            $color=$colors[mt_rand(0, 2)];
            $textColor = imagecolorallocate($image, $color[0], $color[1], $color[2]);
            $chart=mb_substr($code, $i, 1, 'UTF-8');

            $x=$i*$fontSize + $startLeftTopPoint[0]+mt_rand(0-$fontSize/2, $fontSize/2);
            $y=mt_rand($startLeftTopPoint[1], $height-3*$startLeftTopPoint[1]);
            // $y=$startLeftTopPoint[1];

            imagestring($image, $fontSize, $x, $y, $chart, $textColor);
        }

        for ($i=0; $i < $noiseSpot; $i++) { 
            $color=$colors[mt_rand(0, 2)];
            $textColor = imagecolorallocate($image, $color[0], $color[1], $color[2]);
            imagesetpixel($image, rand(0, $width), rand(0, $height), $textColor);
        }

        for ($i=0; $i < $noiseLine; $i++) { 
            $color=$colors[mt_rand(0, 2)];
            $textColor = imagecolorallocate($image, $color[0], $color[1], $color[2]);
            imageline($image, 0, rand(0, $height), $width, rand(0, $height), $textColor);
        }

        if ($imgFile!=='') {
            if (file_exists($imgFile)) {
                unlink($imgFile);
            }
            
            imagepng($image,$imgFile);

            imagedestroy($image);
            return;
        }

        if ($base64) {
            // 在内存中将图像保存为 PNG 格式，并将其输出到变量
            ob_start(); // 启动输出缓冲
            imagepng($image); // 将图像输出到输出缓冲
            $pngData = ob_get_contents(); // 从输出缓冲中获取数据
            ob_end_clean(); // 关闭并清空输出缓冲
            
            imagedestroy($image);

            $base64Img=sprintf('data:image/png;base64,%s',base64_encode($pngData));

            return $base64Img;
        } 
        
        header('Content-type: image/png');

        imagepng($image);

        imagedestroy($image);
    }

    public static function randRgbColor()
    {
        $color=[];
        for ($i=0; $i < 3; $i++) { 
            $color[$i]=mt_rand(0, 255);
        }
        
        return $color;
    }
}