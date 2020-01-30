<?php

#var_dump(json_decode(file_get_contents('php://input'),true));

# 获取原生的请求数据
$xml = file_get_contents('php://input');

# 把xml转换为object对象来处理
$obj = simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA); # SimpleXMLElement LIBXML_NOCDATA

var_dump($obj);
// 获取name
echo $obj->stus->name;

echo "\n";

$name = '张三';
$age = 20;
# 数据展开一定要是索引数组
$arr[] = $name;
$arr[] = $age;

#$str = "小伙子姓名：{$name} 芳龄：${age}";
$str = "小伙子姓名：%s 芳龄：%d";
# 格式化替换输出
$str = sprintf($str,$name,$age);

# 数据展开
$str = sprintf($str,...$arr);

echo $str;
