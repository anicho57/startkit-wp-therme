<!DOCTYPE html>
<html lang="ja">
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />

	<title><?php wp_title('| ', 1, 'right'); ?><?php bloginfo('name'); ?></title>

	<meta name="description" content="" />
	<meta name="keywords" content="" />

	<link href="<?php echo get_bloginfo( "stylesheet_url" ) ?>" rel="stylesheet" />

<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<?php wp_head();?>

<?php get_template_part('parts/ogp'); ?>


</head>
<body id="<?php echo PAGE_ID;?>">
<div id="wrap">

<header id="header">

	<h1 id="logo"><a href="<?php echo BASE_PATH ?>" title=""><?php bloginfo('name'); ?></a></h1>

	<nav id="gNav" role="navigation">
<?php wp_nav_menu( array( 'menu_class' => 'nav-menu' ) ); ?>
	</nav>

</header>
<!-- /#header -->
