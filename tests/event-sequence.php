<?php
namespace infrajs\event;
use infrajs\ans\Ans;

if (!is_file('vendor/autoload.php')) {
	chdir('../../../../');	
	require_once('vendor/autoload.php');
}


$ans = array();
$ans['title'] = 'Последовательность событий';

$obj1=array('id'=>'a');
$obj2=array('id'=>'b');
Event::$classes['layer'] = function ($obj) {
	return $obj['id'];
};



$test = '';
Event::handler('layer.oncheck', function (&$obj) use (&$test) {
	$test.='2:'.$obj['id']."#";

},'env:external');
Event::handler('layer.oncheck', function (&$obj) use (&$test) {
	$test.='1:'.$obj['id'].'-';
},'external');

Event::fire('layer.oncheck', $obj1);

Event::fire('layer.oncheck', $obj2);

if ($test!=='1:a-2:a#1:b-2:b#') return Ans::err($ans, 'Некорректный порядок '.$test);




return Ans::ret($ans);

