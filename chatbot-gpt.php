<?php
/**
 * Plugin Name: Chatbot for GPT
 * Plugin URI: https://github.com/midrocket/chatbot-gpt
 * Description: Chatbot for GPT integration for WP.
 * Version: 1.0.0
 * Author: Midrocket
 * Author URI: https://www.midrocket.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function get_cgpt_plugin_version(){
    $plugin_file = plugin_dir_path( __FILE__ ). 'chatbot-gpt.php';
    $plugin_data = get_file_data($plugin_file, array('Version' => 'Version'), 'plugin');
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/prompt-setup.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/openai-api.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/chatbot-html.php';

if ( is_admin() ) {
    require_once plugin_dir_path( __FILE__ ) . 'admin/admin-settings.php';
}

function chatbotgpt_enqueue_scripts() {
    // Styles
    $style = plugins_url( 'assets/css/style.css', __FILE__ );
    wp_enqueue_style( 'chatbotgpt-style', $style, array(), get_cgpt_plugin_version(), 'all' );
    // Scripts
    wp_enqueue_script('chatbotgpt-ajax-script', plugins_url('assets/js/chatbot.js', __FILE__), array('jquery'), get_cgpt_plugin_version(), true);
    wp_localize_script('chatbotgpt-ajax-script', 'chatbotAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action( 'wp_enqueue_scripts', 'chatbotgpt_enqueue_scripts' );

function chatbotgpt_enqueue_admin_style() {
    // Styles
    $style = plugins_url( 'assets/css/admin.css', __FILE__ );
    wp_enqueue_style( 'chatbotgpt-admin-style', $style, array(), get_cgpt_plugin_version(), 'all' );
    // Scripts
    wp_enqueue_script('chatbotgpt-admin-script', plugins_url('assets/js/admin.js', __FILE__), array('jquery'), get_cgpt_plugin_version(), true);
}
add_action('admin_enqueue_scripts', 'chatbotgpt_enqueue_admin_style');