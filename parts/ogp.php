	<meta property="fb:admins" content="235217929870618" />
	<meta property="og:type" content="website" />
<?php
if (is_single()){//投稿ページの場合
    if(have_posts()): while(have_posts()): the_post();
         echo '	<meta property="og:description" content="'.mb_substr(get_the_excerpt(), 0, 100).'" />';echo "\n";//抜粋を表示
     endwhile; endif;
} else {//投稿ページ以外の場合（アーカイブページやホームなど）
     echo '	<meta property="og:description" content="'; bloginfo('description'); echo '" />';echo "\n";//「一般設定」管理画面で指定したブログの説明文を表示
}
?>
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:url" content="<?php echo "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" />
	<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
<?php
$str = $post->post_content;
$searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i'; // 投稿にイメージがあるか調べる
if (has_post_thumbnail() && !is_archive()){ // 投稿にサムネイルがある場合の処理
     $image_id = get_post_thumbnail_id();
     $image = wp_get_attachment_image_src( $image_id, 'full');
     echo '	<meta property="og:image" content="'.$image[0].'" />';echo "\n";
} else if ( preg_match( $searchPattern, $str, $imgurl ) && !is_archive()) { // 投稿にサムネイルは無いが画像がある場合の処理
     echo '	<meta property="og:image" content="'.$imgurl[2].'" />';echo "\n";
} else { // 投稿にサムネイルも画像も無い場合、もしくはアーカイブページの処理
     echo '	<meta property="og:image" content="" />';echo "\n"; // ***** はデフォルト画像のURL
}
?>
