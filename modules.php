<?php
$modules = array(
	'Forums' => array(
			'description'=> 'Forums',
			'link'=> 'forum.class.php',
			'enabled'=> '1',
			'href'=> 'index.php?action=viewcategory',
			'sidebar'=>'index.php?action=posttopic',
			'sidebarDesc'=>'Post Topic',
			'acp'=>''
	),
	'Pages' => array(
			'description'=> 'Pages',
			'link'=> 'pages.class.php',
			'enabled'=> '1',
			'href'=> 'index.php?action=pages',
			'sidebar'=>'index.php?action=pages&mode=addpage',
			'sidebarDesc'=>'Add Page',
			'acp'=>''
	),
	'Members' => array(
			'description'=> 'Members',
			'link'=> 'members.class.php',
			'enabled'=> '0',
			'href'=> 'index.php?action=m'	
	),
	'Blog' => array(
			'description'=> 'Blog',
			'link'=> 'blog.class.php',
			'enabled'=> '1',
			'href'=> 'index.php?action=Blog',
			'sidebar'=>'index.php?action=Blog&mode=postblog',
			'sidebarDesc'=>'Post Blog',
			'acp'=>''
	),
	'Gallery' => array(
			'description'=> 'Gallery',
			'link'=> 'gallery.class.php',
			'enabled'=> '0',
			'href'=> 'index.php?action=vg&limit=0'	
	)

);

?>
