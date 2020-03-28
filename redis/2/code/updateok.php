<?php
require 'redis.php';
$id = $_POST['id'];
$username = $_POST['username'];
$age = $_POST['age'];
$password = $_POST['password'];
//根据id值拼接哈希的键，拼接好了，重新设置即可
$redis->hmset('user_id_'.$id,['id'=>$id,'username'=>$username,'age'=>$age,'password'=>$password]);
header('location:list.php');
?>