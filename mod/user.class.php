<?php
/**
 * User instance
 * @author Lazypeople<hfutming@gmail.com>
 */
class User extends Base
{
    /**
    * register action first , get captcha
    * @author ihero
     *  
    */
    public function captcha()
    {
        check_email($_POST);
        $keyRedis = "gu";
        
        redis()->set($keyRedis, "tesssst", null);

        $rongyun_token =  redis()->get($keyRedis);
        echo $rongyun_token;exit;
        send_mail($_POST['email'],'cc 验证码','验证码是：123456，请确认');//测试
    }

    /**
    * register action second
    * @author ihero
     *  
    */
    public function register()
    {
	$sql = "insert into `user_base_info`(name,email,password)values(:name,:email,:password)";
        $post = $_POST;//$this->error(200);exit;
        try{
            $ret = db()->execute($sql, array(':name' => $post['name'], ':email' => $post['email'], ':password' => encryptionPassword($post['password'])));
        }
        catch (Exception $e)
        {
             _return(6001, $e->getMessage());
        }
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
