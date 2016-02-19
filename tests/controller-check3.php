<?php
namespace infrajs\controller;

use infrajs\path\Path;
use infrajs\view\View;
use infrajs\load\Load;
use infrajs\config\Config;
use infrajs\ans\Ans;



if (!is_file('vendor/autoload.php')) {
    chdir('../../../../');
    require_once('vendor/autoload.php');
}



$ans = array();
$ans['title'] = 'check3';

Config::get('controller');


View::html('<div id="main"></div>', true);

$layers = Load::loadJSON('-test-akiyatkin/resources/check3.json');

Crumb::change('test');

$html = Controller::check($layers);

preg_match_all('/x/', $html, $matches);
$count = sizeof($matches[0]);
$countneed = 4;

if ($count != $countneed) return Ans::err($ans, 'Неожиданный результат '.$count);

return Ans::ret($ans, 'ret');

