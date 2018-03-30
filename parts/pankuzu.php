<ul class ="breadcrumbs" ><?php
	global $post;
	$str ='';
	$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. home_url( '/', 'relative') .'"><span itemprop="title">HOME</span></a></li>'."\n";
	//カテゴリーのアーカイブページ
	if(is_category()) {
		$cat = get_queried_object();
		if($cat -> parent != 0){
			$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
			foreach($ancestors as $ancestor){
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_category_link($ancestor) .'"><span itemprop="title">'. get_cat_name($ancestor) .'</span></a></li>'."\n";
			}
		}
		$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $cat -> name . '</span></li>'."\n";
	//ブログの個別記事ページ
	} elseif(is_single()){
		$cats = get_the_category();
		// term_idで並び替え
		$baff = array();
		foreach($cats as $key => $value){
			$baff[$key] = $value->term_id;
		}
		array_multisort($baff ,SORT_DESC,$cats);
		$cat = $cats[0];
		if($cat -> parent != 0){
			$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
			foreach($ancestors as $ancestor){
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_category_link($ancestor).'"><span itemprop="title">'. get_cat_name($ancestor). '</span></a></li>'."\n";
			}
		}
		$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_category_link($cat -> term_id). '"><span itemprop="title">'. $cat-> cat_name . '</span></a></li>'."\n";
		$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $post -> post_title .'</span></li>'."\n";
	//固定ページ
	} elseif(is_page()){
		if($post -> post_parent != 0 ){
			$ancestors = array_reverse(get_post_ancestors( $post->ID ));
			foreach($ancestors as $ancestor){
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_permalink($ancestor).'"><span itemprop="title">'. get_the_title($ancestor) .'</span></a></li>'."\n";
			}
		}
		$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $post -> post_title .'</span></li>'."\n";
	//日付ベースのアーカイブページ
	} elseif(is_date()){
		//年別アーカイブ
		if(get_query_var('day') != 0){
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_year_link(get_query_var('year')). '"><span itemprop="title">' . get_query_var('year'). '年</span></a></li>'."\n";
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_month_link(get_query_var('year'), get_query_var('monthnum')). '"><span itemprop="title">'. get_query_var('monthnum') .'月</span></a></li>'."\n";
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('day'). '日</span></li>'."\n";
		//月別アーカイブ
		} elseif(get_query_var('monthnum') != 0){
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'. get_year_link(get_query_var('year')) .'"><span itemprop="title">'. get_query_var('year') .'年</span></a></li>'."\n";
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('monthnum'). '月</span></li>'."\n";
		//年別アーカイブ
		} else {
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('year') .'年</span></li>'."\n";
		}
	//検索結果表示ページ
	} elseif(is_search()) {
		$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">「'. get_search_query() .'」で検索した結果</span></li>'."\n";
	//投稿者のアーカイブページ
	} elseif(is_author()){
		$str .='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">投稿者 : '. get_the_author_meta('display_name', get_query_var('author')).'</span></li>'."\n";
	//タグのアーカイブページ
	} elseif(is_tag()){
		$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">タグ : '. single_tag_title( '' , false ). '</span></li>'."\n";
	//添付ファイルページ
	} elseif(is_attachment()){
		$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $post -> post_title .'</span></li>'."\n";
	//404 Not Found ページ
	} elseif(is_404()){
		$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">404 Not found</span></li>'."\n";
	//その他
	} else{
		$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. wp_title('', false) .'</span></li>'."\n";
	}
	echo $str;

?></ul >
