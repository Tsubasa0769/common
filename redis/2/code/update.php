<?php
require 'redis.php';
//接收传递的id
$id = $_GET['id'];

//取出被修改的数据
$info = $redis->hgetall('user_id_'.$id);//一维数组，就是一行数据
/*echo '<pre>';
print_r($info);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>新建网页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<script type="text/javascript">

</script>

<style type="text/css">
</style>
</head>
    <body>
        <form action="updateok.php" method="post"/>
        <input type="hidden" name="id" value="<?php echo $info['id']?>" />
        用户名：<input type="text" name="username" value="<?php echo $info['username']?>" /><br/>
        密　码：<input type="text" name="password" value="<?php echo $info['password']?>" /> <br/>
        年　龄：<input type="text" name="age" value="<?php echo $info['age']?>"/><br/>
            <input type="submit" value="修改"/>
        </form>
    </body>
</html>