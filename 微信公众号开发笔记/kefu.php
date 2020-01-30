<?php
include './Wechat.php';

if ($_POST['msg']) {
	$openid = $_POST['openid'];
	$msg = $_POST['msg'];

	// 实现公众平台主动发送消息给指定的客户
	echo (new Wechat())->kefuMsg($openid,$msg);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>客服消息</title>
</head>
<body>
	
	<form action="" method="post">
		<input type="text" name="openid" value="ovTcg1ZAoofbOGFx8WIlOfMV8IgM">
		<input type="text" name="msg" id="">
		<input type="submit" value="发送消息">
	</form>

</body>
</html>