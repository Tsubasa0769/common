<?php
$redis = new Redis();
$redis->connect('192.168.1.70');
$redis->auth('beijing');
?>