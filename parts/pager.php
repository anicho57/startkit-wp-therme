<?php if(is_single()): ?>
<ul class="single-pager">
	<li class="prev"><?php previous_post_link('%link','古い記事へ &gt;',false) ?></li>
	<li class="next"><?php next_post_link('%link','&lt; 新しい記事へ',false) ?></li>
</ul>
<?php else: ?>
<div class="pager">
	<?php global $wp_rewrite;
	$paginate_base = get_pagenum_link(1);
	if(strpos($paginate_base, '?') || ! $wp_rewrite->using_permalinks()){
		$paginate_format = '';
		$paginate_base = add_query_arg('paged','%#%');
	}
	else{
		$paginate_format = (substr($paginate_base,-1,1) == '/' ? '' : '/') .
		user_trailingslashit('page/%#%/','paged');;
		$paginate_base .= '%_%';
	}
	echo paginate_links(array(
		'base' => $paginate_base,
		'format' => $paginate_format,
		'total' => $wp_query->max_num_pages,
		'mid_size' => 4,
		'current' => ($paged ? $paged : 1),
		'prev_text' => '古い記事へ',
		'next_text' => '新しい記事へ',
	)); ?>
</div>
<?php endif; ?>
