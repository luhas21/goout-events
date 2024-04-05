<?php
/**
 * Registrace Custom Post Type Lidé
 */
function register_people_cpt() {
    $labels = [
        'name'               => _x('Lidé', 'post type general name', 'your-textdomain'),
        'singular_name'      => _x('Osoba', 'post type singular name', 'your-textdomain'),
        'menu_name'          => _x('Lidé', 'admin menu', 'your-textdomain'),
        'name_admin_bar'     => _x('Osoba', 'add new on admin bar', 'your-textdomain'),
        'add_new'            => __('Přidat novou', 'your-textdomain'),
        'add_new_item'       => __('Přidat novou osobu', 'your-textdomain'),
        'new_item'           => __('Nová osoba', 'your-textdomain'),
        'edit_item'          => __('Upravit osobu', 'your-textdomain'),
        'view_item'          => __('Zobrazit osobu', 'your-textdomain'),
        'all_items'          => __('Všichni lidé', 'your-textdomain'),
        'search_items'       => __('Hledat lidi', 'your-textdomain'),
        'not_found'          => __('Žádní lidé nenalezeni', 'your-textdomain'),
    ];
    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'people'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 35,
        'menu_icon'           => 'dashicons-groups',
        'supports'            => ['title', 'editor', 'thumbnail'],
    ];
    register_post_type('people', $args);

    // Registrace taxonomie Role pro CPT Lidé
    register_taxonomy('roles', 'people', [
        'labels'            => [
            'name'              => _x('Role', 'taxonomy general name', 'your-textdomain'),
            'singular_name'     => _x('Role', 'taxonomy singular name', 'your-textdomain'),
            'search_items'      => __('Hledat role', 'your-textdomain'),
            'all_items'         => __('Všechny role', 'your-textdomain'),
            'parent_item'       => __('Nadřízená role', 'your-textdomain'),
            'parent_item_colon' => __('Nadřízená role:', 'your-textdomain'),
            'edit_item'         => __('Upravit roli', 'your-textdomain'),
            'update_item'       => __('Aktualizovat roli', 'your-textdomain'),
            'add_new_item'      => __('Přidat novou roli', 'your-textdomain'),
            'new_item_name'     => __('Nový název role', 'your-textdomain'),
            'menu_name'         => __('Role', 'your-textdomain'),
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'role'],
    ]);
}
add_action('init', 'register_people_cpt');
