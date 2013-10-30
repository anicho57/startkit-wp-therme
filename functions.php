<?php
// require( get_template_directory() . '/inc/custom-post-type.php' );
require( get_template_directory() . '/inc/WP_My_Setting.class.php' );
$setting = new WP_My_Setting;

// 自動pタグ付加を無効
$setting->disable_content_autop();
$setting->disable_excerpt_autop();

// アイキャッチ機能を使う
$setting->use_eyecatch();


// 抜粋文字数変更
$setting->except_len = 50;
$setting->change_excerpt_mblength_ex();
