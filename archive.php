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

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article>
		<figure><a href="<?php the_permalink() ?>" ><?php $mySetting->the_post_thumb_image() ?></a></figure>
		<div class="body">
			<h2><a href="<?php the_permalink() ?>" ><?php the_title() ?></a></h2>
			<p class="except">
				<?php the_excerpt(); ?>
				... <span><a href="<?php the_permalink() ?>" >続きを読む</a></span>
			</p>
			<p class="meta">
				<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y-m-d'); ?></time>
				<span class="category"><?php the_category(','); ?></span>
				<span class="tag"><?php the_tags('' , ', ' , ''); ?></span>
				<?php edit_post_link('この記事を編集する'); ?>
			</p>
		</div>
	</article>
<?php endwhile; endif; ?>

<?php get_template_part('parts/pager'); ?>

</main>
</div>
<!-- /#content-main -->

<?php get_sidebar(); ?>

</div>
<!-- /#page-content -->

<?php get_footer(); ?>

</body>
</html>