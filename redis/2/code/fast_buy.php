<?php
//第一步：添加库存到链表里面；
$redis = new Redis();
$redis->connect('192.168.1.70');
$redis->auth('beijing');
//添加100件商品
/*for($i=1;$i<=100;$i++){
	$redis->lpush('goods_store',1);
}*/
//第二步：开始抢购了
//设置库存的失效时间；
//$redis->setTimeout('goods_store',30);

//第三步：执行抢购的代码
$id = $redis->lpop('goods_store');
if(!$id){
	echo 'buy fail';
}else {
	echo 'buy success';
}
?>