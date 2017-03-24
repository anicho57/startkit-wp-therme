
<!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

	<link href="<?php echo get_bloginfo( "stylesheet_url" ) ?>" rel="stylesheet" />
	<link href="<?php echo home_url('/', 'relative') ?>css/style.css" rel="stylesheet" />
	<link href="<?php echo home_url('/', 'relative') ?>css/<?php echo PAGE_ID;?>.css" rel="stylesheet" />

<?php wp_head();?>

<?php get_template_part('parts/ogp'); ?>

