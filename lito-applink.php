<?php

/**
 * Plugin Name:       LitoBlocks Applink
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Takashi Fujiskai
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       lito-applink
 *
 * @package           lito-applink
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

include_once plugin_dir_path(__FILE__) . 'inc/define.php';
include plugin_dir_path(__FILE__) . 'inc/admin-page.php';


function litoal_init() {
	register_block_type(__DIR__ . '/build');
}
add_action('init', 'litoal_init');

/**
 * Categories
 *
 * @param array $categories Categories.
 * @param array $post Post.
 */
if (!function_exists('litob_categories')) {
	function litob_categories($categories, $post) {
		return array_merge($categories, [
			[
				'slug' => 'lito-blocks', // ブロックカテゴリーのスラッグ.
				'title' => 'LitoBlocks', // ブロックカテゴリーの表示名.
				// 'icon'  => 'wordpress',    //アイコンの指定（Dashicons名）.
			],
		]);
	}
	add_filter('block_categories_all', 'litob_categories', 10, 2);
}

// フロントとエディターに読み込み
if (!function_exists('litob_variables_enqueue')) {
	function litob_variables_enqueue() {
		wp_enqueue_style(
			'litob-variables',
			plugins_url('/css/variables.css', __FILE__),
			[],
			filemtime(plugin_dir_path(__FILE__) . '/css/variables.css')
		);
	}
	add_action('enqueue_block_assets', 'litob_variables_enqueue', 11);
}

// プラグイン有効時に実行
if (function_exists('litoal_register_activation')) {
	register_activation_hook(__FILE__, 'litoal_register_activation');
}

// オプション値の初期化
function litoal_register_activation() {
	$options = get_option('litoal-setting');

	if (!$options) {
		$default = [
			'token' => '11l64V',
			'country' => 'JP',
			'lang' => 'ja_jp'
		];

		update_option('litoal-setting', $default);
	}
}

// ブロックのカテゴリー登録
if (!function_exists('litoal_su_categories')) {
	function litoal_su_categories($categories, $post) {
		return array_merge(
			$categories,
			[
				[
					'slug'  => 'su',   // ブロックカテゴリーのスラッグ.
					'title' => 'su blocks'  // ブロックカテゴリーの表示名.
				],
			]
		);
	}
	add_filter('block_categories_all', 'litoal_su_categories', 10, 2);
}


function litoal_admin_enqueue_scripts() {
	/**
	 * PHPで生成した値をJavaScriptに渡す
	 *
	 * 第1引数: 渡したいJavaScriptの名前（wp_enqueue_scriptの第1引数に書いたもの）
	 * 第2引数: JavaScript内でのオブジェクト名
	 * 第3引数: 渡したい値の配列
	 */
	wp_localize_script(
		'lito-applink-editor-script',
		'litoalAjaxValues',
		[
			'api' => admin_url('admin-ajax.php'),
			'action' => 'litoal-action',
			'nonce' => wp_create_nonce('litoal-ajax'),
			'optionsPageUrl' => admin_url('options-general.php?page=litoal-setting'),
			'options' => get_option('litoal-setting'),
			'limitValues' => LITOAL_LIMIT_VALUES,
			'countryValues' => LITOAL_COUNTRY_VALUES,
			'langValues' => LITOAL_LANG_VALUES
		]
	);
}
add_action('admin_enqueue_scripts', 'litoal_admin_enqueue_scripts');


// Ajaxで返す値
function litoal_ajax() {
	if (wp_verify_nonce($_POST['nonce'], 'litoal-ajax')) {

		$URL = $_POST['url']; //取得したいサイトのURL
		echo file_get_contents($URL);
		die();
	}
}
add_action('wp_ajax_litoal-action', 'litoal_ajax');
