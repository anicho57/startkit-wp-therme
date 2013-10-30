<?php get_header(); ?>

<div id="eyeCatch" style="background-image:url(../images/home/eyeCatchBg<?php echo sprintf("%02d", rand(1,3)) ?>.png)"></div>

<main id="main" role="main">

<section id="workList">
<?php
if ( is_user_logged_in() ){
	$myposts = get_posts('post_type=past_results&post_status=any&numberposts=8');
}else{
	$myposts = get_posts('post_type=past_results&numberposts=8');
}

if ($myposts) : ?>
<?php
foreach($myposts as $post):
    setup_postdata($post);
?>
	<article class="hvact">
		<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
		<time datetime="<?php the_time('Y-m-d'); ?>"><?php echo date('F Y',strtotime(get_the_time('Y-m-d'))); ?></time>
		<div class="image"><figure><?php echo wp_get_attachment_image(get_post_meta($post->ID,"画像",true),'thumbnail'); ?></figure></div>
	</article>
<?php endforeach;?>
<?php endif ?>
</section>


<section id="information">
	<header>
		<h2 class="tit01">News &amp; Topics</h2>
		<p class="moreLink"><a href="/news_release/">一覧</a></p>
	</header>

<?php
if ( is_user_logged_in() ){
	$myposts = get_posts('post_type=news_release&post_status=any&numberposts=5');
}else{
	$myposts = get_posts('post_type=news_release&numberposts=5');
}

if ($myposts) : ?>
				<dl>
<?php
foreach($myposts as $post):
    setup_postdata($post);

?>
					<dt>
						<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y-m-d'); ?></time>
						<?php get_my_terms($post->ID,'news_type'); ?>
					</dt>
					<dd><p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p></dd>
<?php endforeach;?>
				</dl>
<?php else: ?>
				<p>News &amp; Topicsはありません。</p>
<?php endif ?>
</section>

</main><!-- /#main -->


<?php get_footer(); ?>