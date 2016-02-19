<?php
namespace infrajs\event;
use infrajs\ans\Ans;
use infrajs\config\Config;

if (!is_file('vendor/autoload.php')) {
	chdir('../../../../');	
	require_once('vendor/autoload.php');
}


$ans = array();
$ans['title'] = 'Рекурсия в событиях';

Config::get('event');
Event::$conf['debug']=false;

$test = '';
Event::handler('ontestrec', function () use (&$test) {
	Event::handler('ontestrec', function () use (&$test) {
		$test.='b';
	});
	$test.='a';
});
$r=Event::fire('ontestrec');
if($test!='ab'||!$r) return Ans::err($ans,'Вложенная подписка '.$test);



$test = '';
Event::handler('onfoo', function () use (&$test) {
	$r=Event::fire('onfoo'); //Реультат события без учёта текущего обработчика
	if(!$r) return false;

	$test.='2'; //Так я могу записать себя в конец списка

	return false; //Событие false только тогда когда оно true 
});
Event::handler('onfoo', function () use (&$test) {
	$test.='1';
});


$r=Event::fire('onfoo');

if($r) return Ans::err($ans,'Самозависимость');
if($test!='12') return Ans::err($ans,'Динамическое управление порядком');



Event::handler('ohoho', function () use (&$test) {
	
},'foo:bar');
Event::handler('ohoho', function () use (&$test) {
	
},'bar:foo');

$r=false;
try {
	ob_start();
	Event::fire('ohoho');
} catch (\Exception $e){
	ob_end_clean();
	$r=true;
}
if (!$r) return Ans::err($ans,'Должно было сработать рекурсивное исключение');


Event::handler('ohoho2', function () use (&$test) {
	$test='asdf';
},'some:some');

Event::fire('ohoho2');

if ($test!='asdf') return Ans::err($ans,'Сам себя не может заблокировать');
Event::$conf['debug']=true;

return Ans::ret($ans);

