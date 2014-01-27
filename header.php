<!DOCTYPE html>
<html lang="ja">
<head>

	<meta charset="utf-8" />

	<title><?php wp_title('| ', 1, 'right'); ?><?php bloginfo('name'); ?></title>

	<meta name="keywords" content="" />
	<meta name="viewport" content="" />

	<link href="<?php echo get_bloginfo( "stylesheet_url" ) ?>" rel="stylesheet" />

<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="<?php echo BASE_PATH ?>js/common.js"></script>

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
