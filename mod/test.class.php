<?php
/**
 * test instance
 * @author ihero

 */

class Test extends Base
{
    const hosturl = 'http://cc.com';
    //const hosturl = 'http://cc.qiuhubang.com';
    /**
     *  @example http://cc.qiuhubang.com/test/register.json
     */
    public function register(){
        $action  = self::hosturl.'/user/register.json';
        $params = array('email'=>"hfutming@gmail.com",'name'=>"nm",'password'=>"nm");
        $ret = $this->curl($action,$params);
        return $ret;
    }
    /**
     *  @example http://cc.qiuhubang.com/test/captcha.json
     */
    public function captcha(){
        $action  = self::hosturl.'/user/captcha.json';
        $params = array('email'=>"22204361@qq.com");
        $ret = $this->curl($action,$params);
        return $ret;
    }
    private  function curl($action, $params) {
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $action);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $ret = curl_exec($ch);
                if (false === $ret) {
                    $ret =  curl_errno($ch);
                }
                curl_close($ch);
                return $ret;
        }
}
