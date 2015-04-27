<!DOCTYPE html>
<html lang="ja">
<head>

	<meta charset="utf-8" />

	<title><?php wp_title('| ', 1, 'right'); ?><?php bloginfo('name'); ?></title>

<?php get_template_part('parts/head-read'); ?>

</head>
<body id="page-<?php echo PAGE_ID;?>">

<?php get_header(); ?>

<div id="eyecatch" style="background-image:url(../images/home/eyeCatchBg<?php echo sprintf("%02d", rand(1,3)) ?>.png)"></div>

<div id="page-content">

<div id="content-main">
<main role="main">

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
			<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>" rel="bookmark"><?php the_title() ?></a></h2>
			<?php the_content('&raquo; 続きを読む'); ?>
			<p class="entry-meta">投稿日：<?php the_time('Y-m-d'); ?> | コメント数：<?php comments_popup_link('0','1','%'); ?> | カテゴリ：<?php the_category(', '); ?> | タグ：<?php the_tags('' , ', ' , ''); ?><?php edit_post_link('| <strong>この記事を編集する</strong>'); ?></p>
		</article>
	<?php endwhile; ?>

<?php endif; ?>


<section id="information">
	<header>
		<h2 class="tit01">News &amp; Topics</h2>
		<p class="moreLink"><a href="<?php echo BASE_PATH; ?>news_release/">一覧</a></p>
	</header>
<?php
$args = array( 'post_type' => 'news_release', 'numberposts'=> 5 );
if (is_user_logged_in())$args += array('post_status' => 'any');
$myposts = get_posts($args);
if ($myposts) : ?>
			<dl>
<?php
	foreach($myposts as $post):
	setup_postdata($post);
?>
				<dt>
					<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y-m-d'); ?></time>
					<?php the_tags('' , ', ' , ''); ?>
				</dt>
				<dd><p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p></dd>
<?php
	endforeach;
	wp_reset_postdata();
?>
			</dl>
<?php else: ?>
			<p>News &amp; Topicsはありません。</p>
<?php endif ?>
</section>

</main>
</div>
<!-- /#content-main -->

<?php get_sidebar(); ?>

</div>
<!-- /#page-content -->

<?php get_footer(); ?>

</body>
</html>