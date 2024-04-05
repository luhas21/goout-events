<?php

// Registration of custom post type "dates"
function create_dates_cpt() {
    $labels = [
        'name'                  => _x('Termíny', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Termín', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Termíny', 'text_domain'),
        'name_admin_bar'        => __('Termín', 'text_domain'),
        'archives'              => __('Archiv termínů', 'text_domain'),
        'attributes'            => __('Atributy termínu', 'text_domain'),
        'parent_item_colon'     => __('Nadřazený termín:', 'text_domain'),
        'all_items'             => __('Všechny termíny', 'text_domain'),
        'add_new_item'          => __('Přidat nový termín', 'text_domain'),
        'add_new'               => __('Přidat nový termín', 'text_domain'),
        'new_item'              => __('Nový termín', 'text_domain'),
        'edit_item'             => __('Upravit termín', 'text_domain'),
        'update_item'           => __('Aktualizovat termín', 'text_domain'),
        'view_item'             => __('Zobrazit termín', 'text_domain'),
        'view_items'            => __('Zobrazit termíny', 'text_domain'),
        'search_items'          => __('Hledat termín', 'text_domain'),
        'not_found'             => __('Nenalezeno', 'text_domain'),
        'not_found_in_trash'    => __('V koši nenalezeno', 'text_domain'),
        'insert_into_item'      => __('Vložit k termínu', 'text_domain'),
        'uploaded_to_this_item' => __('Nahráno k tomuto termínu', 'text_domain'),
        'items_list'            => __('Seznam termínů', 'text_domain'),
        'items_list_navigation' => __('Navigace seznamem termínů', 'text_domain'),
        'filter_items_list'     => __('Filtrovat seznam termínů', 'text_domain'),
    ];
    $args = [
        'label'                 => __('Termín', 'text_domain'),
        'description'           => __('Post Type pro termíny', 'text_domain'),
        'labels'                => $labels,
        'supports'              => ['custom-fields'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 31,
        'menu_icon'             => 'dashicons-calendar',
        'rewrite'               => ['slug' => 'program'],
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    ];
    register_post_type('dates', $args);
}
add_action('init', 'create_dates_cpt', 0);

function update_dates_title($post_id) {
    if(get_post_type($post_id) == 'dates') {
        $date_time = get_field('date_time', $post_id);
        $date_title = get_the_title($post_id);

        // Porovnejte původní název s novým datem a časem
        $new_date_title = date('Y-m-d H:i', strtotime($date_time));
        if($date_title !== $new_date_title) {
            $post_data = array(
                'ID' => $post_id,
                'post_title' => $new_date_title
            );
            wp_update_post($post_data);
        }
    }
}
add_action('save_post', 'update_dates_title');

// Add the column as sortable
function dates_sortable_columns($columns) {
    $columns['date_time'] = 'date_time';
    return $columns;
}
add_filter('manage_edit-dates_sortable_columns', 'dates_sortable_columns');

function set_default_sort_order($query) {
    if (is_admin() && $query->is_main_query() && $query->get('post_type') === 'dates' && !isset($_GET['orderby'])) {
        $query->set('meta_key', 'date_time');
        $query->set('orderby', 'meta_value');
        $query->set('order', 'DESC');
    }
    if (isset($_GET['order'])) {
        $query->set('order', $_GET['order']);
    }
}
add_action('parse_query', 'set_default_sort_order');

function dates_custom_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    if ($query->get('post_type') === 'dates') {
        $orderby = $query->get('orderby');
        if ($orderby === 'date_time') {
            $query->set('meta_key', 'date_time');
            $query->set('orderby', 'meta_value');
            $order = $query->get('order');
            if (empty($order) || strtoupper($order) === 'ASC') {
                $query->set('order', 'DESC');
            } else {
                $query->set('order', 'ASC');
            }
        }
    }
}
add_action('pre_get_posts', 'dates_custom_orderby');

// Hide Event title in admin area
function hide_title_column($columns) {
    unset($columns['title']);
    return $columns;
}
add_filter('manage_dates_posts_columns', 'hide_title_column');

function add_dates_columns($columns) {
    $new_columns = [
        'date_time' => __('Datum a čas akce'),
        'event_id' => __('Název akce'),
    ];
    return array_slice($columns, 0, 1) + $new_columns + array_slice($columns, 1);
}
add_filter('manage_dates_posts_columns', 'add_dates_columns');

function display_dates_columns($column, $post_id) {
    switch ($column) {
        case 'date_time':
            $date_time = get_field('date_time', $post_id);
            echo '<a class="row-title" href="post.php?post=' . $post_id . '&action=edit">' . htmlDate($date_time) . '</a>';
            break;
        case 'event_id':
            $event_title = get_the_title(get_field('event_id', $post_id));
            echo '<strong style="color: var(--gooutColor);">' . $event_title . '</strong>';
            break;
    }
}
add_action('manage_dates_posts_custom_column', 'display_dates_columns', 10, 2);

/**
 * Generates a custom column width CSS style and echoes it to the page.
 *
 * @throws Exception If the CSS style cannot be echoed.
 */
function custom_column_width_css() {
    echo '<style type="text/css">';
    echo '.column-date_time {width: 300px;}';
    echo '</style>';
}
add_action('admin_head', 'custom_column_width_css');

/**
 * Generate a list of future dates for a specific event.
 *
 * @param int $eventId The ID of the event.
 * @param bool $justOne Whether to return just one future date.
 * @return string|int The html-readable date or list of dates.
 */
function futureEventDates($eventId, $justOne = false) {
    $args = [
        'post_type' => 'dates',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'event_id',
                'value' => $eventId,
                'compare' => '=',
            ],
            [
                'key' => 'date_time',
                'value' => current_time('Y-m-d'),
                'compare' => '>=',
                'type' => 'DATE'
            ]
        ],
        'meta_key' => 'date_time',
        'orderby' => 'meta_value',
        'order' => 'ASC'
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        $dates = [];
        $dates[] = '<ul class="dates-list">';
        if ($justOne) {
            $query->the_post();
            $dateTime = get_field('date_time');
            if (!empty($dateTime)) {
                $date = htmlDate($dateTime);
                wp_reset_postdata();
                return $date;
            }
        } else {
            while ($query->have_posts()) {
                $query->the_post();
                $dateTime = get_field('date_time');
                if (!empty($dateTime)) {
                    $date = htmlDate($dateTime);
                    ob_start();
                    postEditButton();
                    $editOnTitle = ob_get_clean();
                    $dates[] = '<li class="date-item" ' . $editOnTitle . '>' . $date . '<button class="buy-button">Koupit</button></li>';
                }
            }
            wp_reset_postdata();

            $dates[] = '</ul>';
            return implode('', $dates);
        }
    }
    return 'žádný';
}


function displayProgram() {
    $eventGenreParameter = is_tax('genres') ? get_queried_object()->slug : null; ?>
    <h2>Program<?php if ($eventGenreParameter) echo ' - ' . strtoupper($eventGenreParameter); ?></h2>
    <hr class="event-hr">
    <hr class="event-hr">
    <?php
    $args = [
        'post_type' => 'dates',
        'posts_per_page' => -1,
        'meta_key' => 'date_time',
        'meta_value' => date('Y-m-d'),
        'meta_compare' => '>=',
        'orderby' => 'meta_value',
        'order' => 'ASC'
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); 
            $eventId = get_field('event_id');
            $eventTitle = get_the_title($eventId);
            $eventLink = get_the_permalink($eventId);
            $eventGenre = strtolower(get_the_terms($eventId, 'genres')[0]->name);
            if ($eventGenreParameter && $eventGenre !== $eventGenreParameter) {
                continue;
            } ?>
            <h3 <?php postEditButton(); ?>><?php echo htmlDate(get_field('date_time')); ?></h3>
            <h2><a href="<?php echo $eventLink; ?>"><?php echo $eventTitle; ?></a></h2>
            <hr class="event-hr">
        <?php }
    }
    wp_reset_postdata(); 
}

// Endpoint Registration
add_action('rest_api_init', function() {
    register_rest_route('goout-events', '/program', [
        'methods' => 'GET',
        'callback' => 'json_goout_program',
    ]);
});

function json_goout_program($request) {
    $events = [];
    $args = [
        'post_type' => 'dates',
        'posts_per_page' => -1,
        'meta_key' => 'date_time',
        'meta_value' => date('Y-m-d'),
        'meta_compare' => '>=',
        'orderby' => 'meta_value',
        'order' => 'ASC'
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); 
            $eventId = get_field('event_id');
            $events[] = [
                "event_start_timestamp" => get_field('date_time'),
                "event_title" => get_the_title($eventId),
                "event_url" => get_the_permalink($eventId),
            ];
        }
    }
    wp_reset_postdata(); 

    return json_encode($events, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);;
}
