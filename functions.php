<?php
// require( get_template_directory() . '/inc/setCustomPostType.class.php' );
require( get_template_directory() . '/inc/wpMySetting.class.php' );

//ドキュメントルートのパスの設定
define('BASE_PATH',$mySetting->get_base_path());
// page id
define('PAGE_ID',$mySetting->get_page_id());

// 自動pタグ付加を無効
// $mySetting->disable_content_autop();
$mySetting->disable_excerpt_autop();

// 更新通知の無効
$mySetting->disable_update_notice();

// アイキャッチ機能を使う
// $mySetting->use_eyecatch();

// 画像を追加する場合
// add_image_size('name',70 ,70 ,true);

// wp_list_categoriesの記事数をアンカー内に入れる
$mySetting->list_categories_ancher_in_ex();

// 抜粋文字数変更
$mySetting->except_len = 50;
$mySetting->change_excerpt_mblength_ex();

//固定ページのビジュアルエディタを無効
// $mySetting->desable_visual_editor_in_page_ex();