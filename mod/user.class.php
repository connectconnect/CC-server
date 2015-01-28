<?php
/**
 * User instance
 * @author Lazypeople<hfutming@gmail.com>
 */
class User extends Base
{
    
    /**
    * register action second
    * @author ihero
     *  
    */
    public function register()
    {
	$sql = "insert into `user_base_info`(name,email,password)values(:name,:email,:password)";
	$ret = db()->execute($sql, array(':name' => 'test', ':email' => 'test@test.com', ':password' => 'test222'));
	return $ret;
        $post = $_POST;
        check_email($post);
        //check_password($post);
        //$this->check_captcha_value($post);
	send_mail('377087477@qq.com','hello','hello');//测试
        $ret = register_db($post);



        _return($ret['code'], $ret['content']);
    }
        
        
}
