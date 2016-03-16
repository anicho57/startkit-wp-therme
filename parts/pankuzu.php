<p class ="breadcrumbs" ><?php
	global $post;
	$str ='';
	$str.= '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. home_url() .'/"><span itemprop="title">HOME</span></a></span>';
	$str.= ' &gt; ';
	//カテゴリーのアーカイブページ
	if(is_category()) {
		$cat = get_queried_object();
		if($cat -> parent != 0){
			$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
			foreach($ancestors as $ancestor){
				$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_category_link($ancestor) .'"><span itemprop="title">'. get_cat_name($ancestor) .'</span></a></span>';
				$str.=' &gt; ';
			}
		}
		$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $cat -> name . '</span></span>';
	//ブログの個別記事ページ
	} elseif(is_single()){
		$categories = get_the_category($post->ID);
		$cat = $categories[0];
		if($cat -> parent != 0){
			$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
			foreach($ancestors as $ancestor){
				$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_category_link($ancestor).'"><span itemprop="title">'. get_cat_name($ancestor). '</span></a></span>';
				$str.=' &gt; ';
			}
		}
		$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_category_link($cat -> term_id). '"><span itemprop="title">'. $cat-> cat_name . '</span></a></span>';
		$str.=' &gt; ';
		$str.= '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $post -> post_title .'</span></span>';
	//固定ページ
	} elseif(is_page()){
		if($post -> post_parent != 0 ){
			$ancestors = array_reverse(get_post_ancestors( $post->ID ));
			foreach($ancestors as $ancestor){
				$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_permalink($ancestor).'"><span itemprop="title">'. get_the_title($ancestor) .'</span></a></span>';
				$str.=' &gt; ';
			}
		}
		$str.= '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $post -> post_title .'</span></span>';
	//日付ベースのアーカイブページ
	} elseif(is_date()){
		//年別アーカイブ
		if(get_query_var('day') != 0){
			$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_year_link(get_query_var('year')). '"><span itemprop="title">' . get_query_var('year'). '年</span></a></span>';
			$str.=' &gt; ';
			$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_month_link(get_query_var('year'), get_query_var('monthnum')). '"><span itemprop="title">'. get_query_var('monthnum') .'月</span></a></span>';
			$str.=' &gt; ';
			$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('day'). '日</span></span>';
		//月別アーカイブ
		} elseif(get_query_var('monthnum') != 0){
			$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_year_link(get_query_var('year')) .'"><span itemprop="title">'. get_query_var('year') .'年</span></a></span>';
			$str.=' &gt; ';
			$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('monthnum'). '月</span></span>';
		//年別アーカイブ
		} else {
			$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('year') .'年</span></span>';
		}
	//検索結果表示ページ
	} elseif(is_search()) {
		$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">「'. get_search_query() .'」で検索した結果</span></span>';
	//投稿者のアーカイブページ
	} elseif(is_author()){
		$str .='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">投稿者 : '. get_the_author_meta('display_name', get_query_var('author')).'</span></span>';
	//タグのアーカイブページ
	} elseif(is_tag()){
		$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">タグ : '. single_tag_title( '' , false ). '</span></span>';
	//添付ファイルページ
	} elseif(is_attachment()){
		$str.= '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $post -> post_title .'</span></span>';
	//404 Not Found ページ
	} elseif(is_404()){
		$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">404 Not found</span></span>';
	//その他
	} else{
		$str.='<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. wp_title('', false) .'</span></span>';
	}
	echo $str;

?></p >
