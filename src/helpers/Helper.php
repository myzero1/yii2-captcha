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
    public static function genCaptcha($minLen=4,$maxLen=6, $timeout=300,$key='myzero1自研',$source='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ我是中国人这是myzero1自研的验证码验证器')
    {
        // myzero1\captcha\helpers::genCaptcha()
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
     * @param int $timestamp 1552886962 the will be convered timestamp.
     * @return string 2019-03-23 19:10:23
     */
    public static function time2string($timestamp,$format='Y-m-d H:i:s')
    {
        if (empty($timestamp)) {
            return '';
        } else {
            if (self::isTimestamp($timestamp)) {
                return date($format, intval($timestamp));
            } else {
                return '';
            }
        }
    }

    /**
     * @param string $string 2019-03-23 19:10:23
     * @return int 1552886962
     */
    public static function string2time($string)
    {
        if (empty($string)) {
            return 0;
        } else {
            return strtotime($string);
        }
    }

    /**
     * @param mixed $timestamp .
     * @return bool
     */
    public static function isTimestamp($timestamp)
    {
        $timestamp = intval($timestamp);
        if (strtotime(date('Y-m-d H:i:s', $timestamp)) === $timestamp) {
            return true;
        } else {
            return false;
        }
    }

}