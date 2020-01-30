<?php
// 数据库
return new PDO("mysql:host=localhost;dbname=wx69",'root','root',[
    // 有错误抛异常
    PDO::ERRMODE_EXCEPTION,
    // 以关联数组的形式输出
    PDO::FETCH_ASSOC
]);