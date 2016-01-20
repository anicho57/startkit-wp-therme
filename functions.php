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

// プラグイン・テーマの自動アップデート
// add_filter( 'auto_update_plugin', '__return_true' );
// add_filter( 'auto_update_theme', '__return_true' );

// 更新通知の無効
// $mySetting->disable_update_notice();

// アイキャッチ機能を使う
// $mySetting->use_eyecatch();

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
$mySetting->list_categories_ancher_in_ex();

// 抜粋文字数変更
$mySetting->except_len = 50;
$mySetting->change_excerpt_mblength_ex();

// 「投稿」名の変更
// $mySetting->post_label = '投稿';
// $mySetting->change_post_label_ex();

//固定ページのビジュアルエディタを無効
// $mySetting->desable_visual_editor_in_page_ex();

// tinymceのメニューカスタマイズ
// $mySetting->custom_editor_settings_ex();

// 指定管理メニューの削除
// $mySetting->remove_admin_menus_ex();

// 一覧の項目カスタム
// $mySetting->custom_list_post_columns_ex();

// ユーザー権限の変更
// $mySetting->edit_theme_caps_ex();
// アドミンツールバーメニュー削除
// $mySetting->remove_toolbar_menus_ex();

// フッターテキストの削除
// $mySetting->custom_admin_footer_text_ex();