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
        return 	$GLOBALS['db_'];
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
     * 插入数据
     * @param string $table 待插入的表名
     * @param array  $vals  待插入的数据
     * @reutrn boolean
     */
     function makeSets($array) {
        $sql_sets = '';

        foreach ($array as $f => $v) {
            $sql_sets .= '`' . $f . '`=' . $this->quote($v) . ',';
        }

        if ($sql_sets) {
            return 'SET ' . substr($sql_sets, 0, -1);
        } else {
            return '';
        }
    }
    
    
    /**
     * 转义字符串
     * @param string $str
     * @return string
     */
     function quote($str) {
        if (is_null($str)) {
            return 'NULL';
        } elseif (is_numeric($str))  {
            return $str;
        } elseif (! is_array($str)) {
            //别的地方copy的code，暂时注掉  return '\''.mysql_real_escape_string((string) $str, $this->rdbh ? $this->rdbh : $this->wdbh).'\'';
        } else {
            $a = array_unique($str);
            $str = '';
            foreach ($a as $s) {
                $str .= $this->quote($s) . ',';
            }
            if ($str) {
                $str = substr($str, 0, -1);
            } else {
                $str = '\'\'';
            }
            return $str;
        }
    }
    /**
     * 构建 VALUES 语句
     * @param array $array
     * @return string
     */
     function makeVals($array) {
        $sql_fields = '';
        $sql_values = '';

        if (array_key_exists(0, $array)) {
            $fields = array_keys($array[0]);
            foreach ($fields as $f) {
                $sql_fields .= "`$f`,";
            }
            if ($sql_fields) {
                $sql_fields = '(' . substr($sql_fields, 0, -1) . ')';
            }

            foreach ($array as $array2) {
                $sql_values2 = '';
                foreach ($fields as $f) {
                    $sql_values2 .= $this->quote($array2[$f]) . ',';
                }
                if ($sql_values2) {
                    $sql_values .= '(' . substr($sql_values2, 0, -1) . '),';
                }
            }
            if ($sql_values) {
                $sql_values = substr($sql_values, 0, -1);
            }
        } else {
            foreach ($array as $f => $v) {
                $sql_fields .= "`$f`,";
                $sql_values .= quote((string) $v) . ',';
            }
            if ($sql_fields && $sql_values) {
                $sql_fields = '(' . substr($sql_fields, 0, -1) . ')';
                $sql_values = '(' . substr($sql_values, 0, -1) . ')';
            }
        }

        if ($sql_fields && $sql_values) {
            return $sql_fields . ' VALUES ' . $sql_values;
        } else {
            return '';
        }
    }

     function insert($table, $vals) {
        $sql_vals = makeVals($vals);
        $sql = "insert INTO `$table` $sql_vals";

        return getDatabase()->execute($sql);
    }
     function register_db($post) {
        $data = array('name'=>$post['name'],'password'=>encryptionPassword($post['password']),'email'=>$post['email']);
                
        $res = insert("user_base_info", $data);
        //如果成功。。。
        {
            $ret['code'] = 200;
            $ret['content'] = array('uid' => $res);
            $ret['msg'] = '注册成功';
        }
    }
// 以上是db操作相关
