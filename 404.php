<!DOCTYPE html>
<html lang="ja">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta charset="utf-8" />

	<title><?php wp_title('| ', 1, 'right'); ?><?php bloginfo('name'); ?></title>

<?php get_template_part('parts/head-read'); ?>

</head>
<body id="<?php echo PAGE_ID;?>">

<?php get_header(); ?>

<div id="page-content">

<div id="content-main">
<main role="main">

<?php get_template_part('parts/pankuzu'); ?>

    <h2 class="tit01 mb20">404 File Not Found</h2>
    <p>
        <strong>お探しのページは一時的にアクセスが出来ない状況にあるか移動もしくは削除された可能性があります。</strong><br />
        大変お手数ですが、下記のリンクよりお探しください。
    </p>
    <p class="mt20"><a class="btn01" href="/">トップページ</a></p>

</main>
</div>
<!-- /#content-main -->

</div>
<!-- /#page-content -->

<?php get_footer(); ?>

</body>
</html>