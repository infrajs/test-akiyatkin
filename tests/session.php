<?php
use infrajs\ans\Ans;
use infrajs\db\Db;
use infrajs\session\Session;

if (!is_file('vendor/autoload.php')) {
	chdir('../../../../');
	require_once('vendor/autoload.php');
}

$ans = array();
$ans['title'] = 'Проверка сессии на сервере';

$conf = Db::$conf;
if(!$conf['db']){
	$ans['class']='bg-warning';
	return Ans::ret($ans,'db.conf.db=false Нет разрешения на использование базы данных');
}

$db=&Db::pdo();
if(!$db){
	return Ans::err($ans,'Не удалось соединиться с базой данных');
}
$val=Session::get('test');


$conf = Config::get();
if (!$conf['session']['sync']) {
	$ans['class'] = 'bg-warning';

	return Ans::ret($ans, 'Сессия не синхронизируется с сервером session.sync:false');
}
if (!class_exists('PDO')) {
	return Ans::err($ans, 'class PDO is required');
}
$db = &Db::pdo();
if (!$db) {
	return Ans::err($ans, 'ERROR нет базы данных');
}
$val = Session::get('test');

$val = (int) $val + 1;
Session::set('test', $val);

$d = Session::get();
$ans['test'] = $d['test'];
if ($d['test'] > 1) {
	return Ans::ret($ans, 'PASS');
} else {
	return Ans::err($ans, 'ERROR нажмите 1 раз F5');
}
