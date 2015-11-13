<?php
// require( get_template_directory() . '/inc/set-custom-post-type.class.php' );
require( get_template_directory() . '/inc/wp-my-setting.class.php' );

//ドキュメントルートのパスの設定
define('BASE_PATH',$mySetting->get_base_path());
// page id
define('PAGE_ID',$mySetting->get_page_id());

// 自動pタグ付加を無効
// $mySetting->disable_content_autop();
$mySetting->disable_excerpt_autop();

// 更新通知の無効
// $mySetting->disable_update_notice();

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

// tinymceのメニューカスタマイズ
// $mySetting->custom_editor_settings_ex();

// 指定管理メニューの削除
// $mySetting->remove_admin_menus_ex();

// ユーザー権限の変更
// $mySetting->edit_theme_caps_ex();
// アドミンツールバーメニュー削除
// $mySetting->remove_toolbar_menus_ex();
