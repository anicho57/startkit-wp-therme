<?php
class setCustomPostType{

    public $postTypeTitle  = 'タイトル';
    public $postTypeSlug   = 'store_banner';
    public $taxonomieName  = 'カテゴリ';
    public $taxonomieSlug  = 'category';
    public $contentSupport = array('title','editor');
    public $customPostType = 'post';

    public function __construct(){

        // カスタム投稿タイプの追加
        add_action('init', array($this,'custom_post_type_set'));

        // カスタムタクソノミーを作成
        add_action('init', array($this,'custom_taxonomies_set'), 0);

        // ダッシュボードへ表示
        add_action('right_now_content_table_end', array($this,'custom_post_dashboard_set'));

        // カテゴリページへの項目追加
        add_filter('manage_edit-past_results_columns', array($this,'manage_posts_columns'));
        add_action('manage_posts_custom_column', array($this,'add_column'), 10, 2);

    }

    // カスタムの設定
    public function custom_post_type_set(){
        $this->custom_post_type($this->postTypeTitle, $this->postTypeSlug, $this->contentSupport,$this->customPostType,5);
    }

    // 追加タグの設定
    public function custom_taxonomies_set(){
        $this->custom_taxonomies($this->taxonomieName , $this->taxonomieSlug , $this->postTypeSlug);
    }

    //　ダッシュボード設定
    public function custom_post_dashboard_set(){
        $this->custom_post_dashboard($this->postTypeSlug);
    }


    public function manage_posts_columns($columns) {
        $columns['fcategory1'] = $this->taxonomieName ;
        return $columns;
    }

    public function add_column($column_name, $post_id){
        //カテゴリー名取得
        if( $column_name == 'fcategory1' ) {
            $fcategory = get_the_term_list($post_id, $this->postTypeSlug);
        }
        //該当カテゴリーがない場合「なし」を表示
        if ( isset($fcategory) && $fcategory ) {
            echo $fcategory;
        } else {
            echo __('None');
        }
    }


    /**
     * [custom_post_type description]
     * @param  string  $title           カスタム投稿タイプのタイトル
     * @param  string  $slug            カスタム投稿タイプのスラッグ
     * @param  array   $supports        サポート設定
     * @param  string  $capability_type 投稿タイプ
     * @param  integer $menu_position   メニューの位置
     * @return [type]                   [description]
     */
    public function custom_post_type($title, $slug, $supports, $capability_type = 'post', $menu_position = 30){
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

    public function custom_taxonomies($taxName, $taxSlug, $postType){
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

    public function custom_post_dashboard($custom_post_type){
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
$custompost = new setCustomPostType;