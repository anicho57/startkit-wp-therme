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

		<h2 class="tit01">「<?php printf('%1$s', wp_specialchars($s, 1) ); ?>」の検索結果</h2>
	<?php if (have_posts()) : ?>

		<ul id="search-lists">
		<?php while (have_posts()) : the_post(); ?>
			<li><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>" rel="bookmark"><?php the_title() ?></a></li>
		<?php endwhile; ?>
		</ul>

	<?php else : ?>
		<p class="p20"><strong>検索結果は0件です。</strong></p>
		<p>検索された語句を含む記事が存在しないか、該当する記事が見つからりません。<br />違う語句でもう一度検索してみてください。</p>

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