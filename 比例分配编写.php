<?php
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





<?php
//方法一
$a = ['id' => 1, 'weight' => 5, 'num' => 0];
$b = ['id' => 2, 'weight' => 5, 'num' => 0];
$c = ['id' => 3, 'weight' => 5, 'num' => 0];
$arr = [$a,$b,$c];
$sumweight = 0;
foreach($arr as $v){
	$sumweight += $v['weight'];
}
foreach($arr as $k => $v){
	$arr[$k]['pre'] = floor($v['weight'] / $sumweight * 100);
}
for($i=0;$i<100;$i++){
	$num = mt_rand(0, $sumweight);
	$start = 0;
	foreach($arr as &$v){
		$end = $start + $v['weight'];
		if($start <= $num && $num < $end){
			$v['num']++;
			break;
		}
		$start = $end;
	}
}
print_r($arr);




//方法二
$a = ['id' => 1, 'weight' => 5, 'num' => 20];
$b = ['id' => 2, 'weight' => 5, 'num' => 14];
$c = ['id' => 3, 'weight' => 5, 'num' => 20];
$d = ['id' => 4, 'weight' => 1, 'num' => 0];
$arr = [$a,$b,$c,$d];
//客服总招的人数
$sumnum = 0;
//总比例
$sumweight = 0;
foreach($arr as $v){
	$sumnum += $v['num'];
	$sumweight += $v['weight'];
}
foreach($arr as $k => $v){
	$arr[$k]['pre'] = floor($v['weight'] / $sumweight * 100);
}
for($i=0;$i<46;$i++){
	$endnum = 0;
	if(ceil($sumnum / $sumweight) == 0){
		$loop = 1;
	}elseif(ceil($sumnum / $sumweight) != 0 && $sumnum % $sumweight == 0){
		$loop = ceil($sumnum / $sumweight) + 1;
	}else{
		$loop = ceil($sumnum / $sumweight);
	}
	foreach($arr as $v){
		$endnum += $v['weight'] * $loop - $v['num'];
	}
	$num = mt_rand(0, $endnum-1);
	$start = 0;
	foreach($arr as $k => $v){
		$end = $start + $v['weight'] * $loop - $v['num'];
		if($start <= $num && $num < $end){
			$arr[$k]['num']++;
			break;
		}
		$start = $end;
	}
	$sumnum++;
}
print_r($arr);