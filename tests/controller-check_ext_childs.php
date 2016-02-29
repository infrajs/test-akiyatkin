<?php

namespace infrajs\controller;
use infrajs\config\Config;
use infrajs\view\View;
use infrajs\load\Load;
use infrajs\ans\Ans;



if (!is_file('vendor/autoload.php')) {
    chdir('../../../../');
    require_once('vendor/autoload.php');
}
$query = Crumb::$query;
$ans = array();
$ans['title'] = 'check_ext_childs';

Config::get('controller');


View::html('<div id="main1"></div><div id="main2"></div>', true);
$layers = Load::loadJSON('-test-akiyatkin/resources/check_ext_childs.json');
Crumb::change('test');

$html = Controller::check($layers);
preg_match_all('/x/', $html, $matches);
$count = sizeof($matches[0]);
$countneed = 2;

if ($count != $countneed) return Ans::err($ans, 'line:'.__LINE__.' '.$count);	
Crumb::change($query);
Layer::$start_id = 1;
Layer::$ids = array();
View::html('',true);

return Ans::ret($ans);

