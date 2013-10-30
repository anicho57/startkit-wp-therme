<?php get_header(); ?>

<main id="main" role="main">

	<section id="contents">

<?php get_template_part('parts/pankuzu'); ?>

		<h2 class="tit01">「<?php printf('%1$s', wp_specialchars($s, 1) ); ?>」の検索結果</h2>
	<?php if (have_posts()) : ?>

		<ul id="sLists">
		<?php while (have_posts()) : the_post(); ?>
			<li><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>" rel="bookmark"><?php the_title() ?></a></li>
		<?php endwhile; ?>
		</ul>


	<?php else : ?>
		<p class="p20"><strong>検索結果は0件です。</strong></p>
		<p>検索された語句を含む記事が存在しないか、該当する記事が見つからりません。<br />違う語句でもう一度検索してみてください。</p>

	<?php endif; ?>

	</section>
	<!-- /#contents -->

	<?php get_sidebar(); ?>

</main>
<!-- /#main -->

<?php get_footer(); ?>