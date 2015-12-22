<!DOCTYPE html>
<html lang="ja">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta charset="utf-8" />

	<title><?php wp_title('| ', 1, 'right'); ?><?php bloginfo('name'); ?></title>

<?php get_template_part('parts/head-read'); ?>

</head>
<body id="page-<?php echo PAGE_ID;?>">

<?php get_header(); ?>

<div id="page-content">

<div id="content-main">
<main role="main">

<?php get_template_part('parts/pankuzu'); ?>

<?php if (has_post_thumbnail()) :?>
		<h2><?php the_post_thumbnail( 'post-thumbnail', array( 'class'=>"imgTitle" ) );?></h2>
<?php else: ?>
		<h2><?php the_title(); ?></h2>
<?php endif; ?>

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>

		<?php the_content('&raquo; 続きを読む'); ?>


	<?php endwhile; ?>
<?php endif; ?>

</main>
</div>
<!-- /#content-main -->

<?php get_sidebar(); ?>

</div>
<!-- /#page-content -->

<?php get_footer(); ?>

</body>
</html>