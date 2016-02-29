<?php

namespace infrajs\controller;
use infrajs\config\Config;
use infrajs\path\Path;
use infrajs\view\View;
use infrajs\load\Load;
use infrajs\ans\Ans;



if (!is_file('vendor/autoload.php')) {
    chdir('../../../../');
    require_once('vendor/autoload.php');
}


$ans = array();
$ans['title'] = 'check4';

$query = Crumb::$query;
Config::get('controller');


View::html('<div id="main1"></div><div id="main2"></div>', true);
$layers = Load::loadJSON('-test-akiyatkin/resources/check4.json');
Crumb::change('test');
Controller::check($layers);

$html = View::html();
preg_match_all('/x/', $html, $matches);
$count = sizeof($matches[0]);
$countneed = 2;

Crumb::change($query);
Layer::$start_id = 1;
Layer::$ids = array();
View::html('',true);

if ($count != $countneed) return Ans::err($ans);

return Ans::ret($ans);

