<?php
require 'redis.php';
$id = $_GET['id'];//我关注的用户id
//创建一个集合，把我关注的人添加到里面；
session_start();
$my_id = $_SESSION['user_id'];//登录用户的id;
//拼接集合的名称，使用登录用户的id
$redis->sadd('my_follow_'.$my_id,$id);
header('location:list.php');
?>