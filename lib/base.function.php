<?php
/**
 * Base functions 
 * @author Lazypeople<hfutming@gmail.com>
 */

if (!function_exists('db')) {
	function db()
	{
            if (array_key_exists('db_', $GLOBALS)) {
                return $GLOBALS['db_'];
            }
            $config = parse_ini_file(ROOT.'/config/config.ini', true);
            $config = $config['DataBase'];
            EpiDatabase::employ('mysql',$config['dbname'],$config['host'],$config['username'],$config['password']);
            $GLOBALS['db_'] = getDatabase();
            return $GLOBALS['db_'];
	}
}
if (!function_exists('redis')) {
	function redis()
	{
            if (array_key_exists('redis_', $GLOBALS)) {
                return $GLOBALS['redis_'];
            }
            $config = parse_ini_file(ROOT.'/config/config.ini', true);
            $config = $config['Redis'];
            $GLOBALS['redis_'] = getRedis($config);
            return 	$GLOBALS['redis_'];
	}
}
if (!function_exists('parse_route')) {
	// parse route
	function parse_route($str) 
	{
		
		// User regrex 
		preg_match("/\/(.*)\/(.*)\.json/", $str, $match);
		if (!$match) {
			return false;
		}
		$mod = $match[1];
		$action = $match[2];
		return array('mod' => $mod, 'action' => $action);
	}
} 
function _return($code, $content = '') {
    if($code == 200 && is_array($content)){
        if(!count($content)){
            $code = 201;
        }
    }
    if($code == 200 && $content==''){
        $code = 201;
    }
    
    $info = array('code' => $code,
        'msg' => "尽快把code对应的message对应上",
        'content' => $content
        );
    
    exit(json_encode($info));
}
if (!function_exists('check_email')) {
	function check_email($post)
	{
            if (empty($post['email']))
            {
                //邮箱不能为空
                _return('100104', '邮箱不能为空');
            }

//            if (!check_is_email($post['email']))
//            {
//                //格式不正确
//                _return('100103', '格式不正确');
//            }
	}
}
if (!function_exists('encryptionPassword')) {
    function encryptionPassword($pwd)
    {
        return md5($pwd);
    }
}
if (!function_exists('is_post')) {
	function is_post()
	{
		if (count($_POST)) {
			return true;
		}
		return false;
	}
}
/**
 * 生成指定长度的验证码
 * @param int $len
 * @return string
 */
if (!function_exists('create_rand_string')) {
    function create_rand_string($len = 6)
    {
        $string = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
        $string = '0123456789';
        $chars = str_shuffle($string);
        $str = substr($chars, 0, $len);
        return $str;
    }
}
