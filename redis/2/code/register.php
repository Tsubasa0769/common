<?php
require 'redis.php';
//接收数据
$username = $_POST['username'];
$age = $_POST['age'];
$password = $_POST['password'];

//构建哈希的键，先获取自增的id值
$id = $redis->incr('user_id');//获取id的值
$redis->hmset('user_id_'.$id,['id'=>$id,'username'=>$username,'age'=>$age,'password'=>$password]);
//把用户的id值存储到链表里面
$redis->lpush('user_list_ids',$id);
//注册，创建一个字符串类型，键(用户名_login)    值是用户的id
$redis->set($username.'_login',$id);
header('location:list.php');
?>