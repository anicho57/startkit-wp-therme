<?php get_header(); ?>

<main id="main" role="main">

	<section id="contents">

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

	</section>
	<!-- /#contents -->

	<?php get_sidebar(); ?>

</main>
<!-- /#main -->

<?php get_footer(); ?>