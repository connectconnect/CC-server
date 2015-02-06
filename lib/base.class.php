<?php
/**
 * Base class
 * @author Lazypeople<hfutming@gmail.com>
 */



class Base
{
    private $errorCode = array(
        200 => "success",
        600 => "数据库插入不唯一",
        
    );
    
    public function error($code)
    {
            echo $this->errorCode[$code];
    }
}