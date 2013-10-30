<?php get_header(); ?>

<main id="main" role="main">

	<section id="contents">

	<?php if (have_posts()) : ?>


		<?php while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
				<div class="entry-head">
					<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>" rel="bookmark"><?php the_title() ?></a></h2>
					<p class="entry-meta">投稿日：<?php the_time('Y-m-d'); ?> | コメント数：<?php comments_popup_link('0','1','%'); ?> | カテゴリ：<?php the_category(', '); ?> | タグ：<?php the_tags('' , ', ' , ''); ?><?php edit_post_link('| <strong>この記事を編集する</strong>'); ?></p>
				</div>
				<div class="entry-body">
					<?php the_content('&raquo; 続きを読む'); ?>
				</div>
			</article>

		<?php endwhile; ?>

	<?php endif; ?>

	</section>
	<!-- /#contents -->

	<?php get_sidebar(); ?>

</main>
<!-- /#main -->

<?php get_footer(); ?>