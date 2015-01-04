<?php
$modules = array(
	'Forums' => array(
			'description'=> 'Forums',
			'link'=> 'forum.class.php',
			'class'=>'Forums',
			'classVar'=>'forum',
			'enabled'=> '1',
			'admin'=>'0',
			'href'=> '/viewcategory',
			'sidebar'=>'/posttopic',
			'sidebarDesc'=>'Post Topic',
			'acp'=>''
	),
	'Pages' => array(
			'description'=> 'Pages',
			'link'=> 'pages.class.php',
			'enabled'=> '0',
			'class'=>'Forums',
			'admin'=>'1',
			'href'=> '/pages',
			'sidebar'=>'',
			'sidebarDesc'=>'Add Page',
			'acp'=>'/pages/mode/addpage'
	),
	'Gallery' => array(
			'description'=> 'Gallery',
			'link'=> 'gallery.class.php',
			'class'=>'Forums',
			'enabled'=> '0',
			'admin'=>'1',
			'href'=> '/viewgallery',
			'sidebar'=>'',
			'sidebarDesc'=>'Add Picture to Gallery',
			'acp'=>'/uploadphoto'
	),
	'Blog' => array(
			'description'=> 'Blog',
			'link'=> 'blog.class.php',
			'class'=>'Forums',
			'enabled'=> '0',
			'admin'=>'1',
			'href'=> '/Blog',
			'sidebar'=>'',
			'sidebarDesc'=>'Post Blog',
			'acp'=>'/Blog/mode/postblog'
	),
	'Chat' => array(
			'description'=> 'Chat',
			'link'=> 'chat.class.php',
			'class'=>'Forums',
			'enabled'=> '0',
			'admin'=>'0',
			'href'=> '/chat',
			'sidebar'=>'/chat',
			'sidebarDesc'=>'Join Chat',
			'acp'=>''
	)
);

?>
