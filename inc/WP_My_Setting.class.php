<?php
class WP_My_Setting{

    public $except_len = 50;

    /**
     * コンストラクタ
     */
    public function __construct(){
        //ドキュメントルートのパスの設定
        define('BASE_PATH',$this->get_base_path());
        // page id
        define('PAGE_ID',$this->get_page_id());

        // 不要なhead出力削除
        $this->remove_head();

        // moreの...を削除
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

    function change_excerpt_more($more) {
        return '';
    }

    function disable_content_autop(){
        remove_filter('the_content',  'wpautop');
    }
    function disable_excerpt_autop(){
        remove_filter('the_excerpt',  'wpautop');
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

    /*
     * サムネイルを呼ぶ関数　ちょいと不完全!?
     *
     *  $post_id 画像を取得したい記事のID
     *  $size 取得したい画像のサイズ（thumbnail, medium, large, full ）
     *  $order　ギャラリーでの順序で入れてる数字。2にしたら2番目の画像
     *  $max $orderで入れた数字から何枚目の画像まで取得するか指定
     * */
    function get_the_post_image($postid,$size="thumbnail",$order=0,$max=null) {
        $attachments = get_children(array('post_parent' => $postid, 'post_type' => 'attachment', 'post_mime_type' => 'image'));
        if ( is_array($attachments) ){
            foreach ($attachments as $key => $row) {
                $mo[$key]  = $row->menu_order;
                $aid[] = $row->ID;
            }
            // array_multisort($mo, SORT_ASC, $aid, SORT_DESC, $attachments , SORT_ASC);
            $max = empty($max)? $order+1 :$max;
            array_multisort($aid);
            for($i=$order;$i<$max;$i++){
                $img_tag = wp_get_attachment_image( $aid[$i], $size );
                if ($img_tag != ""){
                    return $img_tag;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * 記事内のリンクを取得
     * @return [type] [description]
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

    function get_text_in_img($text){
        $urllist = array();
        if( preg_match_all('/<img(.+?)>/', $text, $matchs) !== FALSE){
            foreach ($matchs[0] as $line){
                $urllist[] = $line;
            }
            return $urllist[0];
        }
    }

    // 記事内の画像を取ってくる
    function get_content_image_url() {
        global $post, $posts;
        $first_img = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $first_img = $matches [1] [0];

        if(empty($first_img)){ //Defines a default image
            $first_img = "/no-image.gif";
        }
        return $first_img;
    }

    function get_ref_site_image($postid ,$text){
        $link  = $this->get_text_in_url($text);
        $image = $this->get_the_post_image($postid,"medium");
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