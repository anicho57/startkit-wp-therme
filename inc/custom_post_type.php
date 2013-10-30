<?php

// カスタム投稿タイプの追加
function custom_post_type_set()
{
	wbCustom::custom_post_type('News &amp; Topics', 'news_release', Array('title','editor','excerpt'),'post',5);
	wbCustom::custom_post_type('制作実績', 'past_results', Array('title','excerpt'),'post',6);
}
add_action('init', 'custom_post_type_set');


if (get_option('wordbooker_settings')) {
	add_action('admin_menu', 'galleria_add_custom_box');}
	function galleria_add_custom_box() {
	if (current_user_can(WORDBOOKER_MINIMUM_ADMIN_LEVEL)) {
		add_meta_box( 'wordbook_sectionid',
		__('WordBooker Options'),'wordbooker_inner_custom_box', 'news_release', 'advanced' );
		add_meta_box( 'wordbook_sectionid',
		__('WordBooker Options'),'wordbooker_inner_custom_box', 'past_results', 'advanced' );
	}
}


// カスタムタクソノミーを作成
function custom_taxonomies_set()
{
    wbCustom::custom_taxonomies('カテゴリー' , 'news_type' , 'news_release');

    wbCustom::custom_taxonomies('業種カテゴリー' , 'industry_type' , 'past_results');
    wbCustom::custom_taxonomies('機能カテゴリー' , 'additional_functions' , 'past_results');

}
add_action('init', 'custom_taxonomies_set', 0);


function custom_post_dashboard_set()
{
    wbCustom::custom_post_dashboard('news_release');
    wbCustom::custom_post_dashboard('past_results');
}
add_action('right_now_content_table_end', 'custom_post_dashboard_set');


//管理画面記事一覧にカスタムタクソノミーの表示追加
function manage_posts_columns($columns) {
        $columns['fcategory1'] = "業種カテゴリー" ;
        $columns['fcategory2'] = "機能カテゴリー" ;
        return $columns;
}
function manage_posts_columns2($columns) {
        $columns['news_cat'] = "カテゴリー" ;
        return $columns;
}
function add_column($column_name, $post_id){
    //カテゴリー名取得
    if( $column_name == 'fcategory1' ) {
        $fcategory = get_the_term_list($post_id, 'industry_type');
    }else if( $column_name == 'fcategory2' ) {
        $fcategory = get_the_term_list($post_id, 'additional_functions');
    }else if( $column_name == 'news_cat' ) {
        $fcategory = get_the_term_list($post_id, 'news_type');
    }
    //該当カテゴリーがない場合「なし」を表示
    if ( isset($fcategory) && $fcategory ) {
        echo $fcategory;
    } else {
        echo __('None');
    }
}
add_filter('manage_edit-past_results_columns', 'manage_posts_columns');
add_filter('manage_edit-news_release_columns', 'manage_posts_columns2');
add_action('manage_posts_custom_column',  'add_column', 10, 2);







// カスタム投稿タイプ用クラス
class wbCustom
{
		function custom_post_type($title, $slug, $supports, $capability_type = 'post', $menu_position = 30)
		{
			$args = Array(
				'labels' => Array(
					'name' => _x($title, 'post type general name'),
					'singular_name' => _x($title, 'post type singular name'),
					'add_new' => _x('新規追加', 'book'),
					'add_new_item' => __('新しい' . $title . 'を追加'),
					'edit_item' => __($title . 'を編集'),
					'new_item' => __('新しい' . $title),
					'view_item' => __($title . 'を表示'),
					'search_items' => __($title . 'を探す'),
					'not_found' =>  __($title . 'はありません'),
					'not_found_in_trash' => __('ゴミ箱に' . $title . 'はありません'),
					'parent_item_colon' => ''
				),
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => true,
				'capability_type' => $capability_type,
				'hierarchical' => false,
				'menu_position' => $menu_position,
				'has_archive' => true,
				'supports' => $supports
			);
			register_post_type($slug, $args);
		}

		function custom_taxonomies($taxName, $taxSlug, $postType)
		{
			register_taxonomy(
				$taxSlug,
				$postType,
				array(
					'hierarchical' => true,
					'label' => $taxName,
					'singular_name' => $taxName,
					'query_var' => true,
					'rewrite' => true
				)
			);
		}

		function custom_post_dashboard($custom_post_type)
		{
				global $wp_post_types;
				$num_post_type = wp_count_posts($custom_post_type);
				$num = number_format_i18n($num_post_type->publish);
				$text = _n( $wp_post_types[$custom_post_type]->labels->singular_name, $wp_post_types[$custom_post_type]->labels->name, $num_post_type->publish );
				$capability = $wp_post_types[$custom_post_type]->cap->edit_posts;

				if (current_user_can($capability)) {
						$num = "<a href='edit.php?post_type=" . $custom_post_type . "'>$num</a>";
						$text = "<a href='edit.php?post_type=" . $custom_post_type . "'>$text</a>";
				}

				echo '<tr>';
				echo '<td class="first b b_' . $custom_post_type . '">' . $num . '</td>';
				echo '<td class="t ' . $custom_post_type . '">' . $text . '</td>';
				echo '</tr>';
		}
}
