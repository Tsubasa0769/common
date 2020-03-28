<?php
//创建一个对象
$redis = new Redis();
//$redis->connect('localhost');//连接redis服务器；
//连接linux系统里面的redis
$redis->connect('192.168.1.69');
$redis->auth('beijing');
//如果redis服务器设置了密码，则使用如下代码验证
//$redis->auth('密码');
//字符串类型操作
$redis->set('username','libai');
$redis->set('age',12);
//哈希类型的操作
$redis->hset('user:id:1','name','songjiang');
$redis->hmset('user:id:2',['name'=>'xiaohei','age'=>12,'email'=>'xiaohei@sohu.com']);
//链表操作
$redis->lpush('user_list','王刚');
$redis->lpush('user_list','宋江');
$redis->lpush('user_list','李白');
echo  'ok';
?>