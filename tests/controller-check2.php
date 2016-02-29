<?php
namespace infrajs\controller;
use infrajs\view\View;
use infrajs\ans\Ans;
use infrajs\config\Config;
use infrajs\path\Path;
use infrajs\load\Load;



if (!is_file('vendor/autoload.php')) {
    chdir('../../../../');
    require_once('vendor/autoload.php');
}

Config::get('controller');
$query = Crumb::$query;
Crumb::change('test');


$ans = array();
$ans['title'] = 'Проверка чек';

View::html('<div id="main"></div>', true);

$layers = Load::loadJSON('-test-akiyatkin/resources/check2.json');
$html = Controller::check($layers);

preg_match_all('/x/', $html, $matches);
$count = sizeof($matches[0]);

if ($count != 4) {
	return Ans::err($ans, 'Нет '.$count);
}
Crumb::change($query);
Layer::$start_id = 1;
Layer::$ids = array();
View::html('',true);

return Ans::ret($ans);
