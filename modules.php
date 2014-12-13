<?php
$modules = array(
	'Forums' => array(
			'description'=> 'Forums',
			'link'=> 'forum.class.php',
			'enabled'=> '1',
			'admin'=>'0',
			'href'=> 'index.php?action=viewcategory',
			'sidebar'=>'index.php?action=posttopic',
			'sidebarDesc'=>'Post Topic',
			'acp'=>''
	),
	'Pages' => array(
			'description'=> 'Pages',
			'link'=> 'pages.class.php',
			'enabled'=> '1',
			'admin'=>'1',
			'href'=> 'index.php?action=pages',
			'sidebar'=>'',
			'sidebarDesc'=>'Add Page',
			'acp'=>'index.php?action=pages&mode=addpage'
	),
	'Gallery' => array(
			'description'=> 'Gallery',
			'link'=> 'gallery.class.php',
			'enabled'=> '1',
			'admin'=>'1',
			'href'=> 'index.php?action=viewgallery',
			'sidebar'=>'',
			'sidebarDesc'=>'Add Picture to Gallery',
			'acp'=>'index.php?action=uploadphoto'
	),
	'Blog' => array(
			'description'=> 'Blog',
			'link'=> 'blog.class.php',
			'enabled'=> '1',
			'admin'=>'1',
			'href'=> 'index.php?action=Blog',
			'sidebar'=>'',
			'sidebarDesc'=>'Post Blog',
			'acp'=>'index.php?action=Blog&mode=postblog'
	),
	'Chat' => array(
			'description'=> 'Chat',
			'link'=> 'chat.class.php',
			'enabled'=> '1',
			'admin'=>'0',
			'href'=> 'index.php?action=chat',
			'sidebar'=>'index.php?action=chat',
			'sidebarDesc'=>'Join Chat',
			'acp'=>''
	)
);

?>
