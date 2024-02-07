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
    public static function getVerifyCode($minLen=4,$maxLen=6, $timeout=300,$key='myzero1自研',$source='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ我是中国人这是myzero1自研的验证码验证器')
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


}