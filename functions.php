<?php
// require( get_template_directory() . '/inc/setCustomPostType.class.php' );
require( get_template_directory() . '/inc/wpMySetting.class.php' );

// 自動pタグ付加を無効
$mySetting->disable_content_autop();
$mySetting->disable_excerpt_autop();

// アイキャッチ機能を使う
$mySetting->use_eyecatch();


// 抜粋文字数変更
$mySetting->except_len = 50;
$mySetting->change_excerpt_mblength_ex();
