<?php


require_once("./db/db.class.php");

$start = $argv[1];
$end = $argv[2];
$sql="select * from test  where autoid > $start and autoid < $end";//INSERT INTO `test`.`test` (`id`, `sv`, `pn`) VALUES (NULL, '1', '111'), (NULL, '2', '2222');
$update=@$db->get_all($sql);
header("Content-Type: application/vnd.ms-execl");     
header("Content-Disposition: attachment; filename=myExcel.xls");    
header("Pragma: no-cache");    
header("Expires: 0");  

//$title = array('���','����','�绰','����','ְλ');
$title = array('q','sv','pn');
echo iconv('utf-8', 'gbk//IGNORE', implode("\t",$title));
echo "\t\n";
$data = array();
for ($i = 0; $i < count($update); $i++) // �����Ѿ�ͨ���İ汾
{
	//print_r($update[$i]);
	//echo $update[$i]['sv'];
	$d = array($update[$i]['id'],$update[$i]['sv'],$update[$i]['pn']);
	array_push($data,$d); 
}
foreach($data as $value){
	echo iconv('utf-8', 'gbk', implode("\t",$value));
	echo "\t\n";
}
   
?>

