<?php
//--------------------------------------------------
//ページのURLを取得・変数に格納
//--------------------------------------------------
$url = esc_url( apply_filters( 'the_permalink', get_permalink() ) );

//--------------------------------------------------
//SNSシェア数を取得・変数に格納
//--------------------------------------------------

// Twitter -------------------------

//JSONデータを取得
$json = @file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . $url . '');

//JSONデータを連想配列に直す
$array = json_decode($json,true);

//$twitter_countという変数に格納
$twitter_count = $array['count'];

// Facebook -------------------------

//JSONデータを取得
$json = @file_get_contents('http://graph.facebook.com/?id=' . $url . '');

//JSONデータを連想配列に直す
$array = json_decode($json,true);

//データが存在しない場合は0を返す
if(!isset($array['shares'])){
	$count = 0;
}else{
	$count = $array['shares'];
}
//$facebook_countという変数に格納
$facebook_count = $count;

// Google+ -------------------------
// 公式の+1ボタンからカウント数だけ取得
function getGooglePlusCount( $url ) {
	$plus = file_get_contents( 'https://apis.google.com/_/+1/fastbutton?url=' . urlencode( $url ) );
	// 正規表現でカウント数のみを抽出
	preg_match( '/\[2,([0-9.]+),\[/', $plus, $count );
	return $count[1];
}
$count = getGooglePlusCount( $url );

//$gplus_countという変数に格納
$gplus_count = $count;

// hatena -------------------------

//APIではてブ数を取得
$count = @file_get_contents('http://api.b.st-hatena.com/entry.count?url=' . $url . '');

//カウントが0の場合
if(!isset($count) || !$count){
	$count = 0;
}

//$hatena_countという変数に格納
$hatena_count = $count;

?>

<!-- オリジナルボタンのところでSNSシェア数を出力 -->
<ul id="share">
	<li class="twitter"><a href="http://twitter.com/share?url=<?php echo $url; ?>&text=<?php the_title(); ?>" target="_blank"><span><?php echo $twitter_count; ?></span></a></li>
	<li class="facebook"><a href="http://www.facebook.com/share.php?u=<?php echo $url; ?>" onclick="window.open(this.href, 'FBwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;"><span><?php echo $facebook_count; ?></span></a></li>
	<li class="gplus"><a href="https://plus.google.com/share?url=<?php echo $url; ?>" onclick="window.open(this.href, 'Gwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;"><span><?php echo $gplus_count; ?></span></a></li>
	<li class="hatebu"><a href="http://b.hatena.ne.jp/entry/<?php echo $url; ?>" class="hatena-bookmark-button" data-hatena-bookmark-layout="simple" title="<?php the_title(); ?>"><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script><span><?php echo $hatena_count; ?></span></a></li>
</ul>
