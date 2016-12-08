<?php
// require( get_template_directory() . '/inc/set-custom-post-type.class.php' );
require( get_template_directory() . '/inc/theme-setting.class.php' );

//ドキュメントルートのパスの設定
$basePath = $themeSetting->get_base_path();
// page id
$pid = $themeSetting->get_page_id();

// 自動pタグ付加を無効
// $themeSetting->disable_content_autop();
$themeSetting->disable_excerpt_autop();

// プラグイン・テーマの自動アップデート
// add_filter( 'auto_update_plugin', '__return_true' );
// add_filter( 'auto_update_theme', '__return_true' );

// 更新通知の無効
// $themeSetting->disable_update_notice();

// アイキャッチ機能を使う
// $themeSetting->use_eyecatch();

// カスタムヘッダーの設定
// add_theme_support( 'custom-header' ,array(
// 	'default-image'          => '', //デフォルト画像
// 	'random-default'         => false, //ランダム表示
// 	'width'                  => 960, //幅
// 	'height'                 => 300, //高さ
// 	'flex-height'            => false, //フレキシブル対応（高さ）
// 	'flex-width'             => false, //フレキシブル対応（幅）
// 	'default-text-color'     => '', //デフォルトのテキストの色
// 	'header-text'            => false, //ヘッダー画像上にテキストを表示する
// 	'uploads'                => true, //ファイルアップロードを許可する
// 	'wp-head-callback'       => '',
// 	'admin-head-callback'    => '',
// 	'admin-preview-callback' => '',
// ));

// 画像を追加する場合
// add_image_size('name',70 ,70 ,true);

// wp_list_categoriesの記事数をアンカー内に入れる
$themeSetting->list_categories_ancher_in_ex();

// 抜粋文字数変更
$themeSetting->except_len = 50;
$themeSetting->change_excerpt_mblength_ex();

// 「投稿」名の変更
// $themeSetting->post_label = '投稿';
// $themeSetting->change_post_label_ex();

//固定ページのビジュアルエディタを無効
// $themeSetting->desable_visual_editor_in_page_ex();

// tinymceのメニューカスタマイズ
// $themeSetting->custom_editor_settings_ex();

// 指定管理メニューの削除
// $themeSetting->remove_admin_menus_ex();

// 一覧の項目カスタム
// $themeSetting->custom_list_post_columns_ex();

// アドミンツールバーメニュー削除
// $themeSetting->remove_toolbar_menus_ex();

// フッターテキストの削除
// $themeSetting->custom_admin_footer_text_ex();