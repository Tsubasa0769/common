<?php
require 'redis.php';
$id = $_GET['id'];
//构建哈希的键,并删除
$redis->delete('user_id_'.$id);
//从链表里面把该id元素该删除；
$redis->lrem('user_list_ids',$id,0);
header('location:list.php');
?>