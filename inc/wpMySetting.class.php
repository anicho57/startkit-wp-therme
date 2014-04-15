<?php
class wpMySetting{

    public $except_len = 50;

    /**
     * コンストラクタ
     */
    public function __construct(){

        // 不要なhead出力削除
        $this->remove_head();

        // moreの...を変更
        add_filter('excerpt_more', array($this,'change_excerpt_more'));

        // カスタムフィールドのcss/js追加
        add_action('wp_head',array($this,'add_stylesheet'));
        add_action('wp_head',array($this,'add_javascript'));
    }

    function remove_head(){
        remove_action( 'wp_head', 'feed_links_extra', 3 );
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'index_rel_link' );
        remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'recent_comments_style');
        remove_action( 'wp_head', 'wp_shortlink_wp_head');
        return false;
    }

    function disable_update_notice(){

        // Disable All WordPress Updates プラグインを流用
        require( get_template_directory() . '/inc/disable-updates.php' );
    }

    function change_excerpt_more($more) {
        return '';
    }

    function disable_content_autop(){
        remove_filter('the_content',  'wpautop');
    }
    function disable_excerpt_autop(){
        remove_filter('the_excerpt',  'wpautop');
    }

    // 固定ページのビジュアルエディターを無効
    function desable_visual_editor_in_page_ex(){
        add_action( 'load-post.php', array($this,'disable_visual_editor_in_page' ));
        add_action( 'load-post-new.php', array($this,'disable_visual_editor_in_page' ));
    }
    function disable_visual_editor_in_page(){
        global $current_user;
        global $typenow;
        get_currentuserinfo();
        if( $typenow == 'page' ){
            add_filter('user_can_richedit', array($this,'disable_visual_editor_filter'));
        }
    }
    function disable_visual_editor_filter(){
        return false;
    }

    // アイキャッチ機能の有効化
    function use_eyecatch(){
        add_theme_support('post-thumbnails', array( 'post','page' ));
        set_post_thumbnail_size( 900, 9999, true );// サムネイルのサイズ
    }

    function add_stylesheet(){
        if(is_single()||is_page()){
            if($cssPath_arr = get_post_meta(get_the_ID(), 'css', false)){
                foreach($cssPath_arr as $cssPath)
                    echo "<link href=\"{$cssPath}\" rel=\"stylesheet\" />\n";
            }
        }
    }
    function add_javascript(){
        if(is_single()||is_page()){
            if($jsPath_arr = get_post_meta(get_the_ID(), 'js', false)){
                foreach($jsPath_arr as $jsPath)
                    echo "<script src=\"{$jsPath}\"></script>\n";
            }
        }
    }

    // 抜粋文字数変更
    function change_excerpt_mblength($length) {
        return $this->except_len;
    }
    function change_excerpt_mblength_ex(){
        add_filter('excerpt_mblength', array($this,'change_excerpt_mblength'));
    }


    //指定文字数で切る
    public static function truncate($str, $limit = 80, $etc = '...') {
        if($limit == 0) {return '';}
        $str = strip_tags($str);
        if(mb_strlen($str) > $limit) {
            return mb_substr($str, 0, $limit).$etc;
        } else {
            return $str;
        }
    }

    // wp_list_categoriesのFilter
    function list_categories_ancher_in_ex(){
        add_filter( 'wp_list_categories', array($this,'list_categories_ancher_in'), 10, 2 );
    }
    function list_categories_ancher_in( $output, $args ) {
        $output = preg_replace('/<\/a>\s*\((\d+)\)/',' ($1)</a>',$output);
        return $output;
    }

    /**
     * 記事内のサムネイル画像を返す。
     * 記事に画像の登録がない場合はコンテンツ内から検索して取得する。
     * それでもない場合はダミー画像を表示(images/noImage.png)
     * @return img要素
     */
    function get_post_thumb_image(){
        global $post, $posts;
        $image = $this->get_post_image($post->ID,"thumbnail");
        if(!$image){
            $image_url = $this->get_content_image_url();
            $image = '<img src="'.$image_url.'" width="'.get_option('thumbnail_size_w').'" alt="" />';
        }
        return $image;
    }
    function the_post_thumb_image(){
        echo $this->get_post_thumb_image();
    }

    /*
     * 所属画像を返す関数
     *
     *  $post_id 画像を取得したい記事のID
     *  $size 取得したい画像のサイズ（thumbnail, medium, large, full ）
     *  $order　ギャラリーでの順序で入れてる数字。2にしたら2番目の画像
     * */
    function get_post_image($postid,$size="thumbnail",$order=0) {
        $attachments = get_children(array('post_parent' => $postid, 'post_type' => 'attachment', 'post_mime_type' => 'image'));
        if ( is_array($attachments) ){
            $keys = array_keys($attachments);
            $num=$keys[$order];
            $img = wp_get_attachment_image($num,$size);
            return $img;
        }
    }
    function the_post_image($postid,$size="thumbnail",$order=0) {
        echo $this->get_post_image($postid,$size,$order);
    }

    /**
     * contents内を検索して画像を取得
     * ない場合はダミー画像を返す(images/noImage.png)
     */
    function get_content_image_url() {
        global $post, $posts;
        $first_img = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $first_img = $matches [1] [0];

        if(empty($first_img)){ //Defines a default image
            $first_img = $this->get_base_path()."images/noImage.png";
        }
        return $first_img;
    }

    /**
     * ファイルサイズ取得
     * @param  [type] $filepath ファイルのパス（サーバー絶対パス）
     * @return [type]           ファイルサイズ
     */
    function get_file_size($filepath) {
        // $mfile　= ABSPATH.$file;
        if ( is_file($filepath) ){
            $filesize = filesize($filepath);
            $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            $e = floor(log($filesize)/log(1024));
            if($e==0 || $e==1) {
                $format = '%d ';
            }else{
                $format = '%.1f ';
            }
            $filesize = sprintf($format.$s[$e], ($filesize/pow(1024, floor($e))));
        }else{
            $filesize="ファイルがみつかりません";
        }
        return $filesize;
    }

    function the_file_size($filepath){
        echo $this->get_file_size($filepath);
    }


    /**
     * 引数内のテキストから最初のURLを返す
     */
    function get_text_in_url($text){
        $urllist = array();
        if( preg_match_all('/https?:\/\/[a-zA-Z0-9\-\.\/\?\@&=:~#]+/', $text, $matchs) !== FALSE){
            foreach ($matchs[0] as $line){
                $urllist[] = $line;
            }
            return $urllist[0];
        }
    }
    /**
     * 引数内のテキストから最初のimg要素を返す
     */
    function get_text_in_img($text){
        $urllist = array();
        if( preg_match_all('/<img(.+?)>/', $text, $matchs) !== FALSE){
            foreach ($matchs[0] as $line){
                $urllist[] = $line;
            }
            return $urllist[0];
        }
    }

    function get_ref_site_image(){
        global $post, $posts;
        $link  = $this->get_text_in_url($post->post_content);
        $image = $this->get_post_image($post->ID,"medium");
        if ($imges == "") $image = $this->get_text_in_img($text);
        $html = '<a href="' . $link . '">'. $image . '</a>';
        return $html;
    }

    function get_base_path(){
        return str_replace("index.php","",$_SERVER['PHP_SELF']);
    }

    function get_path(){
        $reqUri = $_SERVER['REQUEST_URI'];
        $basePath = $this->get_base_path();
        return str_replace($basePath,"",$reqUri);
    }

    function get_page_id(){
        $path = $this->get_path();
        $pid = reset(explode('/', $path));
        if( $pid == "" ){
          return "home";
        }else{
          return $pid;
        }
    }
}
$mySetting = new wpMySetting;