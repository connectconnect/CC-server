<?php
/**
 * Default index page
 * @author Lazypeople<hfutming@gmail.com>
 */
define('ROOT', dirname(__FILE__));
include_once ROOT.'/src/Epi.php';
include ROOT.'/lib/base.function.php';
include ROOT.'/lib/base.class.php';
include ROOT.'/lib/mail.function.php';

Epi::setPath('base', ROOT.'/src');
Epi::init('api', 'database');
$routes = parse_route($_GET['__route__']);
if (!$routes) {
	showEndpoints();
}
$mod_file = ROOT.'/mod/'.$routes['mod'].'.class.php';
if (file_exists($mod_file)) {
	require $mod_file;
	$class_name = ucfirst(strtolower($routes['mod']));
	if (class_exists($class_name)) {
		$instance = new $class_name;
	} else {
		showEndpoints();
	}
} else {
	showEndpoints();
}

// Judge is post
$method = is_post() ? 'post' : 'get';
getApi()->$method($_GET['__route__'], array($instance, $routes['action']), EpiApi::external);
getRoute()->run();

function showEndpoints()
{
  	echo 'Bad route';
  	exit();
}
