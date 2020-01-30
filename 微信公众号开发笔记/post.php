<?php
// 引入数据库
$pdo = include './db.php';
// 引入微信操作类
include './Wechat.php';

$files = $_FILES['media'];
# 得到扩展名
$ext = pathinfo($files['name'],PATHINFO_EXTENSION);
# 上传后的文件名
$name = time().'.'.$ext;

# 上传到服务器的绝对路径
$realpath = __DIR__.'/up/'.$name;
move_uploaded_file($files['tmp_name'],$realpath);


// 上传素材到公众号平台
$wx = new Wechat();
$media_id = $wx->uploadMaterial($realpath,'image',$_POST['is_forever']);


$sql = "insert into material (realpath,ctime,is_forever,media_id) values (?,?,?,?)";
// 预处理对象
$stmt = $pdo->prepare($sql);

// 执行入库
$ret = $stmt->execute([$realpath,time(),$_POST['is_forever'],$media_id]);