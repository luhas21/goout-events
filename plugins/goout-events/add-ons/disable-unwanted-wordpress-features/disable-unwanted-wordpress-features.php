<?php
/*
Plugin Name: GoOut\Disable Unwanted Wordpress Features
Plugin URI: https://gitlab.com/GoOutNet/Developers/Widgets/WordpressPlugins
Description:
    - Disables the WP Admin Bar on the frontend
    - Removes useless boxes in Admin editor
    - Disables emoji handling for old browsers
Version: 1.0
Author: GoOut
*/
if (get_option('disable_admin_bar') == "on") {
    # remove admin bar to prevent caching it for non-admins
    add_filter('show_admin_bar', '__return_false', 999);
}

if (get_option('disable_editor') == "on") {
    # set html editor as default
    add_filter('wp_default_editor', function() { return "html"; });
}

if (get_option('disable_unwanted_boxes') == "on") {
    # remove unwanted boxes for all post types
    function remove_meta_boxes_globally() {
        $post_types = get_post_types(array('_builtin' => false));
        $post_types[] = ['post', 'page'];
        foreach ($post_types as $post_type) {
            remove_meta_box('postcustom', $post_type, 'normal');
            remove_meta_box('commentsdiv', $post_type, 'normal');
            remove_meta_box('commentstatusdiv', $post_type, 'normal');
            remove_meta_box('trackbacksdiv', $post_type, 'normal');
            remove_meta_box('authordiv', $post_type, 'normal');
            remove_meta_box('postexcerpt', $post_type, 'normal');
        }
    }
    add_action('admin_menu', 'remove_meta_boxes_globally');
}
