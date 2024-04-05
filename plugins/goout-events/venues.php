<?php
/**
 * Registration Custom Post Type venue
 */
function register_venue_cpt() {
    $labels = [
        'name'               => _x('Místa', 'post type general name', 'your-textdomain'),
        'singular_name'      => _x('Místo', 'post type singular name', 'your-textdomain'),
        'menu_name'          => _x('Místa', 'admin menu', 'your-textdomain'),
        'name_admin_bar'     => _x('Místo', 'add new on admin bar', 'your-textdomain'),
        'add_new'            => _x('Přidat nové', 'venue', 'your-textdomain'),
        'add_new_item'       => __('Přidat nové místo', 'your-textdomain'),
        'new_item'           => __('Nové místo', 'your-textdomain'),
        'edit_item'          => __('Upravit místo', 'your-textdomain'),
        'view_item'          => __('Zobrazit místo', 'your-textdomain'),
        'all_items'          => __('Všechna místa', 'your-textdomain'),
        'search_items'       => __('Hledat místa', 'your-textdomain'),
        'not_found'          => __('Žádná místa nenalezena', 'your-textdomain'),
    ];
    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'venues'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_icon'           => 'dashicons-location',
        'menu_position'       => 33,
        'supports'            => ['title', 'editor', 'thumbnail'],
    ];
    register_post_type('venues', $args);

    register_taxonomy('venue_type', 'venues', [
        'labels'            => [
            'name'              => _x( 'Typy míst', 'taxonomy general name', 'your-textdomain' ),
            'singular_name'     => _x( 'Typ místa', 'taxonomy singular name', 'your-textdomain' ),
            'search_items'      => __( 'Hledat typy', 'your-textdomain' ),
            'all_items'         => __( 'Všechny typy', 'your-textdomain' ),
            'parent_item'       => __( 'Nadřazený typ', 'your-textdomain' ),
            'parent_item_colon' => __( 'Nadřazený typ:', 'your-textdomain' ),
            'edit_item'         => __( 'Upravit typ', 'your-textdomain' ),
            'update_item'       => __( 'Aktualizovat typ', 'your-textdomain' ),
            'add_new_item'      => __( 'Přidat nový typ', 'your-textdomain' ),
            'new_item_name'     => __( 'Nový název typu', 'your-textdomain' ),
            'menu_name'         => __( 'Typy míst', 'your-textdomain' ),
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'venue-type' ),
    ]);
}
add_action('init', 'register_venue_cpt');
