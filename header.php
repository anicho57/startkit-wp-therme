<div class="page">

<div class="page-header">
<header>

	<h1 class="logo-main"><a href="<?php echo home_url($path = '/', $scheme = relative); ?>"><?php bloginfo('name'); ?></a></h1>

	<nav class="nav-main" role="navigation">
<?php wp_nav_menu( array( 'menu_class' => 'nav-menu' ) ); ?>
	</nav>

</header>
</div>
<!-- /.page-header -->
