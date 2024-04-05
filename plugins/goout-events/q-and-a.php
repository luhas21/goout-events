<?php
/**
 * Registrace Custom Post Type q-and-a
 */
function register_qanda_cpt() {
    $labels = [
        'name'               => _x('Q&A', 'post type general name', 'your-textdomain'),
        'singular_name'      => _x('Q&A', 'post type singular name', 'your-textdomain'),
        'menu_name'          => _x('Q&A', 'admin menu', 'your-textdomain'),
        'name_admin_bar'     => _x('Q&A', 'add new on admin bar', 'your-textdomain'),
        'add_new'            => _x('Přidat novou', 'q-and-a', 'your-textdomain'),
        'add_new_item'       => __('Přidat novou položku Q&A', 'your-textdomain'),
        'new_item'           => __('Nová položka Q&A', 'your-textdomain'),
        'edit_item'          => __('Upravit položku Q&A', 'your-textdomain'),
        'view_item'          => __('Zobrazit položku Q&A', 'your-textdomain'),
        'all_items'          => __('Všechny položky Q&A', 'your-textdomain'),
        'search_items'       => __('Hledat položky Q&A', 'your-textdomain'),
        'not_found'          => __('Žádné položky Q&A nenalezeny', 'your-textdomain'),
    ];
    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'q-and-a'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_icon'           => 'dashicons-format-status',
        'menu_position'       => 43,
        'supports'            => ['title', 'editor'],
    ];
    register_post_type('q-and-a', $args);
}
add_action('init', 'register_qanda_cpt');
