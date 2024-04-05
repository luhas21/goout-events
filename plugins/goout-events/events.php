<?php

// Registration of custom post type "Akce"
/**
 * Registrace Custom Post Type Akce
 */
function register_events_cpt() {
    $labels = [
        'name'               => _x('Akce', 'post type general name', 'textdomain'),
        'singular_name'      => _x('Akce', 'post type singular name', 'textdomain'),
        'menu_name'          => _x('Akce', 'admin menu', 'textdomain'),
        'name_admin_bar'     => _x('Akce', 'add new on admin bar', 'textdomain'),
        'add_new'            => __('Přidat novou', 'textdomain'),
        'add_new_item'       => __('Přidat novou akci', 'textdomain'),
        'new_item'           => __('Nová akce', 'textdomain'),
        'edit_item'          => __('Upravit akci', 'textdomain'),
        'view_item'          => __('Zobrazit akci', 'textdomain'),
        'all_items'          => __('Všechny akce', 'textdomain'),
        'search_items'       => __('Hledat akce', 'textdomain'),
        'parent_item_colon'  => __('Nadřazená akce:', 'textdomain'),
        'not_found'          => __('Žádná akce nenalezena.', 'textdomain'),
        'not_found_in_trash' => __('Žádná akce v koši.', 'textdomain'),
    ];
    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 29,
        'menu_icon'           => 'dashicons-list-view',
        'query_var'           => true,
        'rewrite'             => ['slug' => 'events'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'supports'            => ['title', 'editor', 'author', 'thumbnail', 'custom-fields'],
        'show_in_rest'        => true,
    ];
    register_post_type('events', $args);

    // Registration taxonomie Žánry pro CPT Akce
    register_taxonomy('genres', 'events', [
        'labels'            => [
            'name'              => _x('Žánry', 'taxonomy general name', 'textdomain'),
            'singular_name'     => _x('Žánr', 'taxonomy singular name', 'textdomain'),
            'search_items'      => __('Hledat žánry', 'textdomain'),
            'all_items'         => __('Všechny žánry', 'textdomain'),
            'parent_item'       => __('Nadřazený žánr', 'textdomain'),
            'parent_item_colon' => __('Nadřazený žánr:', 'textdomain'),
            'edit_item'         => __('Upravit žánr', 'textdomain'),
            'update_item'       => __('Aktualizovat žánr', 'textdomain'),
            'add_new_item'      => __('Přidat nový žánr', 'textdomain'),
            'new_item_name'     => __('Název nového žánru', 'textdomain'),
            'menu_name'         => __('Žánry', 'textdomain'),
        ],
        'hierarchical'      => true,
        'show_in_rest'      => true,
    ]);
}
add_action('init', 'register_events_cpt');

function displayRepertoar() { ?>
    <h2>Repertoar</h2>
    <hr class="event-hr">
    <hr class="event-hr">
    <?php
    $args = [
        'post_type' => 'events',
        'posts_per_page' => -1,
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $eventId = get_the_ID();
            ?>
            <h2 <?php postEditButton(); ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <p>Nejbližší termín: <?php echo futureEventDates($eventId, true); ?></p>
            <hr class="event-hr">
            <?php
        }
    }
    wp_reset_postdata();
}


