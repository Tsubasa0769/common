<?php

/*return [

	'button' => [
		[
			'type' => 'click',
			'name' => '一级菜单',
			'key' => 'key001'
		],
		[
			'name' => '二级菜单',
			'sub_button' => [
				[
					"type" => "view",
					"name" => "传智",
					"url"  => "http://m.itcast.cn/"
				],
				[
					"type" => "view",
					"name" => "搜索",
					"url"  => "http://m.baidu.com/"
				],
			]
		],
		[
			'type' => 'click',
			'name' => '最后一个',
			'key' => 'key002'
		]

	]
];*/

/*return <<<EOL
	 {
     "button":[
     {    
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {    
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }
EOL;*/

return '{
     "button":[
     {    
          "type":"click",
          "name":"首页",
          "key":"index001"
      },
      {
           "name":"最新活动",
           "sub_button":[
           {    
               "type":"view",
               "name":"搜索",
               "url":"http://qwppf9.natappfree.cc/jssdk/share.php"
            },
            {
               "type":"click",
               "name":"客服",
               "key":"kefu001"
            },{
                    "type": "pic_sysphoto", 
                    "name": "系统拍照", 
                    "key": "photo001"
              },{
                "name": "发送位置", 
            "type": "location_select", 
            "key": "rselfmenu_2_0"
                }]
       },
       {    
          "type":"view",
          "name":"个人中心",
          "url":"http://m.itcast.cn/"
      }
       ]
 }';