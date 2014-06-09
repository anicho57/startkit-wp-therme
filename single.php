<!DOCTYPE html>
<html lang="ja">
<head>

	<meta charset="utf-8" />

	<title><?php wp_title('| ', 1, 'right'); ?><?php bloginfo('name'); ?></title>

<?php get_template_part('parts/headread'); ?>

</head>
<body id="<?php echo PAGE_ID;?>">

<?php get_header(); ?>

<div id="contents">

<div id="mainContent">
<main role="main">

<?php get_template_part('parts/pankuzu'); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
		<h2 class="entry-title"><?php the_title() ?></h2>
		<div class="entry-body">
			<?php the_content(); ?>
		</div>
		<p class="entry-meta">投稿日：<?php the_time('Y-m-d'); ?> | コメント数：<?php comments_popup_link('0','1','%'); ?> | カテゴリ：<?php the_category(', '); ?> | タグ：<?php the_tags('' , ', ' , ''); ?><?php edit_post_link('| <strong>この記事を編集する</strong>'); ?></p>
	</article>
<?php endwhile; endif; ?>

<?php get_template_part('parts/pager'); ?>

</main>
</div>
<!-- /#mainContent -->

<?php get_sidebar(); ?>

</div>
<!-- /#contents -->

<?php get_footer(); ?>

</body>
</html>