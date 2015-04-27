<?php
class WP_My_Setting{

    public $except_len = 50;

    /**
     * コンストラクタ
     */
    public function __construct(){

        date_default_timezone_set('Asia/Tokyo');

        // 不要なhead出力削除
        $this->remove_head();

        // moreの...を変更
        add_filter('excerpt_more', array($this,'change_excerpt_more'));

        // カスタムフィールドのcss/js追加
        add_action('wp_head',array($this,'add_stylesheet'));
        add_action('wp_footer',array($this,'add_javascript'));

        // エディタスタイルシートの追加 (themesdir/)editor-style.css
        add_editor_style();

        // メディアライブラリ（一覧）へURL列を追加
        $this->media_list_add_url_columns();

        // アーカイブの年月日を追加
        add_filter( 'wp_title', array($this,'jp_date_archive_wp_title'), 10 );
        add_filter( 'get_archives_link', array($this,'year_archives_link'), 10);

        // 管理画面にCSSを追加
        add_action('admin_head', array($this,'wp_custom_admin_css'), 100);
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

    function wp_custom_admin_css() {
        echo "\n" . '<link rel="stylesheet" href="' .get_bloginfo('template_directory'). '/admin.css' . '" />' . "\n";
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

    function jp_date_archive_wp_title( $title ) {
        if ( is_date() ) {
            // $title = trim( $title );
            $replaces = array(
                '/([1-9]{1}[0-9]{3})/' => '$1年',
                '/ ([0-9]{1,2}) /'     => ' $1日 ',
                '/ ([0-9]{1,2})$/'     => ' $1日',
                '/[\s]+/'              => ' '
            );
            $title = preg_replace( array_keys( $replaces ), $replaces, $title );
        }
        return $title;
    }
    function year_archives_link($html){
        if(preg_match('/[0-9]+?<\/a>/', $html))
            $html = preg_replace('/([0-9]+?)<\/a>/', '$1年</a>', $html);
        if(preg_match('/title=[\'\"][0-9]+?[\'\"]/', $html))
            $html = preg_replace('/(title=[\'\"][0-9]+?)([\'\"])/', '$1年$2', $html);
        return $html;
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
        add_theme_support('post-thumbnails', array( 'report' ));
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

    // tinymce custom
    // memo  @link http://wpengineer.com/1963/customize-wordpress-wysiwyg-editor/
    // Codex @link https://codex.wordpress.org/TinyMCE
    function custom_editor_settings( $initArray ){
        //tinymce v4
        $initArray['toolbar1'] = 'formatselect,bold,strikethrough,|,bullist,numlist,|,alignleft,aligncenter,alignright,|,link,unlink,|,table,spellchecker,fullscreen,wp_adv';
        $initArray['toolbar2'] = ',fontsizeselect,underline,forecolor,|,pastetext,pasteword,removeformat,|,media,|,outdent,indent,|,undo,redo,wp_help';
        $initArray['block_formats'] = "段落=p; 見出し=h3";
        $initArray['fontsize_formats'] = "10px 11px 12px 13px 14px 16px 20px 24px 28px 32px 36px";
        //tinymce v3
        $initArray['theme_advanced_buttons1'] = 'bold,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,|,link,unlink,|,spellchecker,fullscreen,wp_adv';
        $initArray['theme_advanced_buttons2'] = 'underline,forecolor,|,pastetext,pasteword,removeformat,|,media,|,outdent,indent,|,undo,redo,wp_help';
        return $initArray;
    }
    function custom_editor_settings_ex(){
        add_filter( 'tiny_mce_before_init', array($this,'custom_editor_settings' ));
    }

    // 指定管理メニューの削除
    function remove_admin_menus () {
        global $menu;
        $user = wp_get_current_user();
        if($user->roles != 'administrator'){
            $removeMenu = array(
                    // '固定ページ',
                    // 'コメント',
                    // 'ツール',
                    'Smart Custom Fields',
                );
            end ($menu);
            foreach ($menu as $key => $value) {
                $name = explode(' <',$value[0]);
                if (in_array(reset($name),$removeMenu))
                    unset($menu[$key]);
            }
        }
    }
    function remove_admin_menus_ex(){
        add_action( 'admin_menu', array($this,'remove_admin_menus' ));
    }

    // ユーザー権限の変更
    // @link http://wpdocs.sourceforge.jp/%E3%83%A6%E3%83%BC%E3%82%B6%E3%83%BC%E3%81%AE%E7%A8%AE%E9%A1%9E%E3%81%A8%E6%A8%A9%E9%99%90
    function edit_theme_caps(){
        $role = get_role( 'editor' );
        // *** 追加 ***
        // $role->add_cap( 'upload_files' );

        // *** 削除 ***
        $remove_caps = array(
            // 固定ページ関連
            'delete_others_pages',
            'delete_pages',
            'delete_private_pages',
            'delete_published_pages',
            'edit_others_pages',
            'edit_pages',
            'edit_private_pages',
            'edit_published_pages',
            'publish_pages',
            'read_private_pages',

            'moderate_comments',
            'manage_links',
        );
        $role->remove_cap( $remove_caps );
    }

    function edit_theme_caps_ex(){
        add_action( 'admin_init', array($this, 'edit_theme_caps') );
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


    // メディアライブラリ一覧（リスト時）にファイルのURLを表示する列を追加
    function media_list_add_url_columns(){
        add_filter('manage_media_columns', array($this,'posts_columns_attachment_id'), 1);
        add_action('manage_media_custom_column', array($this,'posts_custom_columns_attachment_id'), 1, 2);
    }
    function posts_columns_attachment_id($defaults){
        $defaults['wps_post_attachments_id'] = 'ファイルのURL';
        return $defaults;
    }
    function posts_custom_columns_attachment_id($column_name, $id){
        if($column_name === 'wps_post_attachments_id'){

            echo '<textarea readonly style="width:100%;" rows="2" onClick="this.select();">';
            // get attachment url
            echo wp_get_attachment_url( $id );
            echo '</textarea>';
        }
    }

    function change_category_posts_per_page($query) {
        if ( is_admin() || ! $query->is_main_query() )
            return;

        if($query->is_category()){
            $query->set( 'posts_per_page', '10' );//件数変更
            $query->set( 'orderby', 'post_date' );//ソート指定
            $query->set( 'order', 'DESC' );//ソート順番
        }
    }
    function change_category_posts_per_page_ex(){
        add_action( 'pre_get_posts', array($this,'change_category_posts_per_page' ));
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
     * 記事内のサムネイル画像を取得。
     * 記事に画像の登録がない場合はコンテンツ内から検索して取得する。
     * それでもない場合はダミー画像を表示(images/no_image.png)
     * @return img要素
     */
    function get_post_thumb_image(){
        global $post, $posts;
        // $image = $this->get_post_attachment_image($post->ID);
        $image = '';
        if(empty($image)){
            $image_url = $this->get_content_image_url();
            $image_id = $this->get_url_to_attachment_id($image_url);
            if ($image_id){
                $image = '<img src="'.$this->get_attachment_image($image_id).'" alt="" />';
            }else{
                $image = '<img src="'.$image_url.'" width="'.get_option('thumbnail_size_w').'" alt="" />';
            }
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
    function get_post_attachment_image($postid,$size="thumbnail",$order=0) {
        $attachments = get_children(array('post_parent' => $postid, 'post_type' => 'attachment', 'post_mime_type' => 'image'));
        // var_dump($attachments);
        if ( is_array($attachments) ){
            $keys = array_keys($attachments);
            if(!empty($keys[$order])){
                $num = $keys[$order];
                $img = wp_get_attachment_image($num,$size);
                return $img;
            }
        }
    }

    /**
     * contents内を検索して画像を取得
     * ない場合はダミー画像を返す(images/no_image.png)
     */
    function get_content_image_url() {
        global $post, $posts;
        $first_img = '';
        ob_start();
        ob_end_clean();
        if (preg_match_all("/<img[^>]+src=[\"']([\-_\.!~\*'()a-z0-9;\/\?:@&=\+\$,%#]+\.(jpg|jpeg|png|gif))[\"'][^>]+>/i", $post->post_content, $matches) ){
            $first_img = $matches [1] [0];
        }else{
            $first_img = $this->get_base_path()."images/no_image.png";
        }
        return $first_img;
    }

    /**
    * 画像のURLからattachemnt_idを取得する
    *
    * @param string $url 画像のURL
    * @return int attachment_id
    */
    function get_url_to_attachment_id($url)
    {
        global $wpdb;
        $sql = "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s";
        preg_match('/([^\/]+?)(-e\d+)?(-\d+x\d+)?(\.\w+)?$/', $url, $matches);
        $post_name = $matches[1];
        return (int)$wpdb->get_var($wpdb->prepare($sql, $post_name));
    }

    function the_attachment_image($attachment_id,$size = 'thumbnail'){
        echo '<img src="'.$this->get_attachment_image($attachment_id,$size).'" alt="" />';
    }
    function get_attachment_image($attachment_id,$size = 'thumbnail'){
        $img_src = wp_get_attachment_image_src($attachment_id,$size);
        return $img_src[0];
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
        return substr($reqUri,strlen($basePath),strlen($reqUri));
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
$mySetting = new WP_My_Setting;