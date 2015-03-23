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
        $keyRedis = $_POST['email'];
        try{
            $captcha = create_rand_string(6);
            $mail_content = "Hi,您好<br/>请完成Email验证，在验证页面输入验证码：" . $captcha."<br/>有任何疑问都可以反馈给 cc@qiuhubang.com ，我们会第一时间答复您哦！";

            redis()->set($keyRedis, $captcha, null);

            //$rongyun_token =  redis()->get($keyRedis);
            send_mail($_POST['email'],'开源聊天源码注册体验 cc 验证码',$mail_content);//测试
            _return(200, "验证码已经发到你的邮箱");
        }
        catch (Exception $e)
        {
             _return(6001, $e->getMessage());
        }
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
        $server_captcha = redis()->get($post['email']);
        // 20140716  wangtianbao  验证码不区分大小写
        if (empty($server_captcha) || strtolower($post['captcha']) != strtolower($server_captcha)) {
            _return('6002', '验证码错误');
        }
        try{
            $ret = db()->execute($sql, array(':name' => $post['name'], ':email' => $post['email'], ':password' => encryptionPassword($post['password'])));
            $content = array(
                         'uid' => $ret, 
                    );
            _return(200, $content);
        }
        catch (Exception $e)
        {
             _return(6001, $e->getMessage());
        }
        _return(201);
    }
        
     
}
