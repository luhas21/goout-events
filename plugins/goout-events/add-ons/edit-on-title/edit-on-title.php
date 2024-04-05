<?php
/**
 * Plugin Name: GoOut\Edit on Title
 * Plugin URI: https://goout.net/
 * Description: Plugins which appends "edit" button next to post title
 * Version: 1.1
 * Author: GoOut
 */

function the_editable_post($id = null) {
    echo 'data-edit-on-title-id="' . ($id ?: get_the_id()) . '"';
}

// ajax query to check if user is logged in
add_action('wp_ajax_is_user_logged_in', 'ajax_is_user_logged_in');
add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_is_user_logged_in');

function ajax_is_user_logged_in() {
    echo is_user_logged_in() ? '1' : '0';
    wp_die();
}

add_action('init', function() {
    wp_enqueue_style('edit-on-title', plugin_dir_url(__FILE__) . 'edit-on-title.css');
    wp_register_script('edit-on-title', plugin_dir_url(__FILE__) . 'edit-on-title.js', ['jquery']);
    wp_localize_script('edit-on-title', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_script('edit-on-title');
});