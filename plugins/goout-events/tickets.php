<?php

/**
 * Registrace Custom Post Type Vstupenky
 */
function register_tickets_cpt() {
    $labels = [
        'name'               => _x('Vstupenky', 'post type general name', 'your-textdomain'),
        'singular_name'      => _x('Vstupenka', 'post type singular name', 'your-textdomain'),
        'menu_name'          => _x('Vstupenky', 'admin menu', 'your-textdomain'),
        'name_admin_bar'     => _x('Vstupenka', 'add new on admin bar', 'your-textdomain'),
        'add_new'            => _x('Přidat novou', 'vstupenka', 'your-textdomain'),
        'add_new_item'       => __('Přidat novou vstupenku', 'your-textdomain'),
        'new_item'           => __('Nová vstupenka', 'your-textdomain'),
        'edit_item'          => __('Upravit vstupenku', 'your-textdomain'),
        'view_item'          => __('Zobrazit vstupenku', 'your-textdomain'),
        'all_items'          => __('Všechny vstupenky', 'your-textdomain'),
        'search_items'       => __('Hledat vstupenky', 'your-textdomain'),
        'not_found'          => __('Žádné vstupenky nenalezeny', 'your-textdomain'),
    ];
    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'tickets'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 39,
        'menu_icon'           => 'dashicons-tickets-alt',
        'supports'            => ['title', 'editor', 'author', 'thumbnail'],
        ];
    register_post_type('tickets', $args);
}
add_action('init', 'register_tickets_cpt');
