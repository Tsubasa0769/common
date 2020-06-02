<?php
fsdfsd
$a = ['id' => 1, 'weight' => 5, 'num' => 0];
$b = ['id' => 2, 'weight' => 7, 'num' => 0];
$c = ['id' => 3, 'weight' => 8, 'num' => 0];
$arr = [$a,$b,$c];
$sum = 0;
$sumweight = 20;
foreach($arr as $k => $v){
	$sum += $v['num'];
	$arr[$k]['pre'] = floor($v['weight'] / $sumweight * 100);
}
for($i=0;$i<100;$i++){
	$sum++;
	$compareArr = [];
	foreach($arr as $k => $v) {
		$compareArr[$k] = $sum * $v['weight'] - $v['num'] * $sumweight;
	}
	$index = array_search(max($compareArr),$compareArr);
	echo $index.'</br>';
	$arr[$index]['num']++;
}
print_r($arr);