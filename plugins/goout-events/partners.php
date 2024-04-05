<?php

/**
 * Registrace Custom Post Type Partneři
 */
function register_partners_cpt() {
    $labels = [
        'name'               => _x('Partneři', 'post type general name', 'your-textdomain'),
        'singular_name'      => _x('Partner', 'post type singular name', 'your-textdomain'),
        'menu_name'          => _x('Partneři', 'admin menu', 'your-textdomain'),
        'name_admin_bar'     => _x('Partner', 'add new on admin bar', 'your-textdomain'),
        'add_new'            => _x('Přidat nového', 'partner', 'your-textdomain'),
        'add_new_item'       => __('Přidat nového partnera', 'your-textdomain'),
        'new_item'           => __('Nový partner', 'your-textdomain'),
        'edit_item'          => __('Upravit partnera', 'your-textdomain'),
        'view_item'          => __('Zobrazit partnera', 'your-textdomain'),
        'all_items'          => __('Všichni partneři', 'your-textdomain'),
        'search_items'       => __('Hledat partnery', 'your-textdomain'),
        'not_found'          => __('Žádní partneři nenalezeni', 'your-textdomain'),
    ];
    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'partners'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 37,
        'menu_icon'           => 'dashicons-admin-users',
        'supports'            => ['title', 'editor', 'author', 'thumbnail'],
        ];
    register_post_type('partners', $args);
}
add_action('init', 'register_partners_cpt');
