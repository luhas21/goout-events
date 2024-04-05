<?php 
/**
 * Registrace Custom Post Type files
 */
function register_files_cpt() {
    $labels = [
        'name'               => _x('Soubory', 'post type general name', 'your-textdomain'),
        'singular_name'      => _x('Soubor', 'post type singular name', 'your-textdomain'),
        'menu_name'          => _x('Soubory', 'admin menu', 'your-textdomain'),
        'name_admin_bar'     => _x('Soubor', 'add new on admin bar', 'your-textdomain'),
        'add_new'            => _x('Přidat nový', 'soubor', 'your-textdomain'),
        'add_new_item'       => __('Přidat nový soubor', 'your-textdomain'),
        'new_item'           => __('Nový soubor', 'your-textdomain'),
        'edit_item'          => __('Upravit soubor', 'your-textdomain'),
        'view_item'          => __('Zobrazit soubor', 'your-textdomain'),
        'all_items'          => __('Všechny soubory', 'your-textdomain'),
        'search_items'       => __('Hledat soubory', 'your-textdomain'),
        'not_found'          => __('Žádné soubory nenalezeny', 'your-textdomain'),
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'files'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 41,
        'menu_icon'           => 'dashicons-media-document',
        'supports'            => ['title', 'editor', 'author', 'thumbnail', 'revisions'],
    ];
    register_post_type('files', $args);
}
add_action('init', 'register_files_cpt');
