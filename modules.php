<?php
$modules = array(
	'Forums' => array(
			'description'=> 'Forums',
			'link'=> 'forum.class.php',
			'enabled'=> '1',
			'class'=>'Forums',
			'stats'=>'true',
			'admin'=>'0',
			'href'=> '/forums',
			'sidebar'=>'/posttopic',
			'sidebarDesc'=>'Post Topic',
			'acp'=>''
	),
	'Downloads' => array(
			'description'=> 'Downloads',
			'link'=> 'downloads.class.php',
			'enabled'=> '1',
			'admin'=>'1',
			'class'=>'downloads',
			'stats'=>'false',
			'href'=> '/dlList',
			'sidebar'=>'/dlList',
			'sidebarDesc'=>'Downloads',
			'acp'=>'/uploadFile'
	),
	'Pages' => array(
			'description'=> 'Pages',
			'link'=> 'pages.class.php',
			'enabled'=> '1',
			'admin'=>'1',
			'class'=>'pages',
			'stats'=>'true',
			'href'=> '/pages',
			'sidebar'=>'',
			'sidebarDesc'=>'Add Page',
			'acp'=>'/pages/mode/addpage'
	),
	'Gallery' => array(
			'description'=> 'Gallery',
			'link'=> 'gallery.class.php',
			'enabled'=> '1',
			'admin'=>'1',
			'class'=>'gallery',
			'stats'=>'true',
			'href'=> '/viewgallery',
			'sidebar'=>'',
			'sidebarDesc'=>'Add Picture to Gallery',
			'acp'=>'/uploadphoto'
	),
	'Blog' => array(
			'description'=> 'Blog',
			'link'=> 'blog.class.php',
			'enabled'=> '0',
			'admin'=>'1',
			'class'=>'blog',
			'stats'=>'true',
			'href'=> '/Blog',
			'sidebar'=>'',
			'sidebarDesc'=>'Post Blog',
			'acp'=>'/Blog/mode/postblog'
	),
	'Chat' => array(
			'description'=> 'Chat',
			'link'=> 'chat.class.php',
			'enabled'=> '1',
			'admin'=>'0',
			'class'=>'Chat',
			'stats'=>'false',
			'href'=> '/chat',
			'sidebar'=>'/chat',
			'sidebarDesc'=>'Join Chat',
			'acp'=>''
	)
);

?>
