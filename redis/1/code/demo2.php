<?php
//创建一个对象
$redis = new Redis();
$redis->connect('localhost');//连接redis服务器；
//获取字符串数据
$username = $redis->get('username');
echo $username;
echo '<br/>';
echo $redis->get('age');
echo '<hr>';
//获取哈希类型
$data = $redis->hgetall('user:id:2');
echo '<pre>';
print_r($data);
echo '<hr>';
//获取链表类型
$info  = $redis->lrange('user_list',0,-1);
print_r($info);