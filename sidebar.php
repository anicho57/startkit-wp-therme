<div class="content-sub">

<?php
global $ThermeSetting;
$parent_slug = $ThermeSetting->get_page_id();
if (is_home()) : //ホームページの場合?>


<?php elseif (is_page(array('hp')) || $parent_slug == 'hp' || $parent_slug == 'past_results' || $parent_slug == 'additional_functions' || $parent_slug == 'industry_type') : //ホームページ作成 ?>



<?php elseif (is_page(array('system')) || $parent_slug == 'system') : //ホームページ作成 ?>


<?php elseif (is_page(array('corporate')) || $parent_slug == 'corporate' || $parent_slug == 'news_release' || $parent_slug == 'news_type' || $parent_slug == 'contact' || $parent_slug == 'other-works') : //会社情報 ?>


<?php elseif ($parent_slug == 'news_release') : //news & topics ?>

	<aside class="subMenu">
		<h3>News &amp; Topics</h3>
		<ul>
			<?php wp_get_archives(); ?>
		</ul>
	</aside>


<?php else : ?>



<?php endif; ?>

	<aside class="blog-menu">
		<dl class="cate">
			<dt>カテゴリー</dt>
			<dd>
				<ul>
					<?php wp_list_categories(array(
						'show_count' => 1,
					)); ?>
				</ul>
			</dd>
		</dl>
		<dl class="new">
			<dt>最新の記事</dt>
			<dd>
				<ul>
					<?php wp_get_archives('type=postbypost&limit=10'); ?>
				</ul>
			</dd>
		</dl>
		<dl class="archive">
			<dt>アーカイブ</dt>
			<dd>
				<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
					<?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option', 'show_post_count' => 1 ) ); ?>
				</select>
			</dd>
		</dl>
	</aside>

</div>
<!-- /.content-sub -->
