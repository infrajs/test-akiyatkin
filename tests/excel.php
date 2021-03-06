<?php

namespace infrajs\excel;

use infrajs\access\Access;
use infrajs\ans\Ans;
use infrajs\config\Config;

Access::test(true);
$ans = array();

$data = Xlsx::init('-test-akiyatkin/resources/test.xlsx');

if (!$data) {
	return Ans::err($ans, 'Cant read test.xlsx');
}
	
$data = Xlsx::init('-test-akiyatkin/resources/test.csv');
if (!$data) {
	return Ans::err($ans, 'Cant read test.csv');
}
if (sizeof($data['childs']) != 1) {
	return Ans::err($ans, 'Cant read test.csv '.sizeof($data['childs']));
}


$num=ini_get('mbstring.func_overload');
if($num!=0){
	$ans['class']='bg-warning';
	return Ans::err($ans, 'mbstring.func_overload should be 0, not '.$num);
} else {
	$data = Xlsx::get('-test-akiyatkin/resources/test.xls');
	if (sizeof($data['childs'][0]['data']) != 30) {
		return Ans::err($ans, 'Cant read test.xls '.sizeof($data['childs'][0]['data']));
	}
}
return Ans::ret($ans, 'csv, xls, xlsx read ok!');
