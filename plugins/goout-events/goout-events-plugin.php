<?php
/*
* Plugin Name: GoOut Events plugin
* Plugin URI: https://example.com/my-first-plugin
* Description: A plugin to support GoOut ticketing system.
* Version: 1.0.0
* Author: Petr Pedro Sahula
* Author URI: https://example.com
* License: GPLv2 or later
*/

// Insert plugin files

// Insert CSS files
function add_custom_css() {
    wp_enqueue_style('custom-style', plugins_url('css/styles.css', __FILE__));
    if (get_option('use_cookies') == 'on') {
        wp_enqueue_style('goout-events-cookies-styles', plugins_url('css/cookies.css', __FILE__));
    }
}
add_action('wp_enqueue_scripts', 'add_custom_css');
function add_custom_admin_css() {
    wp_enqueue_style('custom-admin-style', plugins_url('css/styles.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'add_custom_admin_css');

// Insert JS files
// Register scripts for admin pages
function goout_events_load_admin_scripts() {
    wp_enqueue_script('goout-events-scripts', plugin_dir_url(__FILE__) . '/js/goout-admin.js', array('jquery'), '1.0', true);
}
add_action('admin_head', 'goout_events_load_admin_scripts');

// Register scripts for front end
function enqueue_goout_events_load_scripts() {
    wp_enqueue_script('goout-events-scripts', plugins_url('/js/goout-scripts.js', __FILE__));
    if (get_option('use_cookies') == 'on') {
        wp_enqueue_script('cookies-script', 'https://static.goout.net/cookie-plugin/goout-cookie.umd.js', array(), null, false);
        wp_enqueue_script('goout-events-cookies-scripts', plugins_url('js/goout-cookies.js', __FILE__));
    }
}
add_action('wp_enqueue_scripts','enqueue_goout_events_load_scripts');

require_once(plugin_dir_path(__FILE__) . 'options-basic.php');
require_once(plugin_dir_path(__FILE__) . 'events.php');
require_once(plugin_dir_path(__FILE__) . 'dates.php');
require_once(plugin_dir_path(__FILE__) . 'venues.php');
if (get_option('people') == 'on') {
    require_once(plugin_dir_path(__FILE__) . 'people.php');
}
if (get_option('partners') == 'on') {
    require_once(plugin_dir_path(__FILE__) . 'partners.php');
}
if (get_option('q_and_a') == 'on') {
    require_once(plugin_dir_path(__FILE__) . 'q-and-a.php');
}
if (get_option('files') == 'on') {
    require_once(plugin_dir_path(__FILE__) . 'files.php');
}
if (get_option('tickets') == 'on') {
    require_once(plugin_dir_path(__FILE__) . 'tickets.php');
}

if (get_option('basic_website_type') == 'hall') {
    require_once(plugin_dir_path(__FILE__) . 'options-hall.php');
} else if (get_option('basic_website_type') == 'festival') {
    require_once(plugin_dir_path(__FILE__) . 'options-festival.php');
} else if (get_option('basic_website_type') == 'exhibition') {
    require_once(plugin_dir_path(__FILE__) . 'options-exhibition.php');
}

if (get_option('edit_on_title') == 'on') {
    require_once(plugin_dir_path(__FILE__) . 'add-ons/edit-on-title/edit-on-title.php');
}

if (get_option('disable_admin_bar') == 'on' || get_option('disable_unwanted_boxes') == 'on' || get_option('disable_editor') == 'on') {
    require_once(plugin_dir_path(__FILE__) . 'add-ons/disable-unwanted-wordpress-features/disable-unwanted-wordpress-features.php');
}

/**
 * Generate dynamic CSS based on the plugin option.
 *
 * @return string The CSS generated based on the plugin option.
 */
function generate_dynamic_css() {
    $css = '
    :root {
        --mainColor: ' . get_option('main_color', '#FF8800') . ';
        --buttonColor: ' . get_option('button_color', '#000000') . ';
        --gooutColor: #00B6EB;
    }';
    return $css;
}

/**
 * Function to insert dynamic CSS into the page.
 */
function insert_dynamic_css() {
    $css = generate_dynamic_css();
    echo '<style type="text/css">' . esc_html($css) . '</style>';
}
add_action('wp_head', 'insert_dynamic_css');
add_action('admin_head', 'insert_dynamic_css');


function listPosts($postType) { ?>
    <hr class="event-hr">
    <hr class="event-hr">
    <h2>Novinky</h2>
    <hr class="event-hr">
    <hr class="event-hr">
    <?php
    $args = [
        'post_type' => $postType,
        'posts_per_page' => -1,
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <h2 class="post-title" <?php postEditButton(); ?>><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
            <hr class="event-hr">
            <?php } ?>
            <hr class="event-hr">
    <?php }
    wp_reset_postdata(); 
}


// Register menus
function custom_theme_menus() {
    register_nav_menus([
        'main-menu-location' => __('Main Menu'), // Main menu Location
        'footer-menu-location' => __('Footer Menu'), // Footer Menu Lucation
    ]);
}
add_action('init', 'custom_theme_menus');


// Add featured images for the eventspost type
add_theme_support('post-thumbnails', ['post', 'page', 'events', 'dates', 'venues', 'people', 'partners', 'q-and-a', 'files', 'tickets']);

function change_post_type_labels( $args, $post_type ) {
    if ( $post_type === 'post' ) {
        $args['labels']['name'] = 'Novinky';
        $args['labels']['singular_name'] = 'Novinka';
        $args['labels']['menu_name'] = 'Novinky';
        $args['labels']['name_admin_bar'] = 'Novinka';
        $args['labels']['add_new'] = 'Přidat novinku';
        $args['labels']['add_new_item'] = 'Přidat novinku';
        $args['labels']['edit_item'] = 'Upravit novinku';
        $args['labels']['new_item'] = 'Nová novinka';
        $args['labels']['view_item'] = 'Zobrazit novinku';
        $args['labels']['search_items'] = 'Hledat novinky';
        $args['labels']['not_found'] = 'Žádné novinky nenalezeny';
        $args['labels']['not_found_in_trash'] = 'Žádné novinky v koši';
        $args['labels']['all_items'] = 'Všechny novinky';
        $args['labels']['archives'] = 'Archivy novinek';
    }
    return $args;
}
add_filter( 'register_post_type_args', 'change_post_type_labels', 10, 2 );


function change_post_menu_icon() {
    global $menu;
    $menu[5][6] = 'dashicons-pressthis';
}
add_action( 'admin_menu', 'change_post_menu_icon' );

function custom_admin_menu_separator() {
    global $menu;
    $menu[26] = ['', 'read', 'separator', '', 'wp-menu-separator'];
    ksort($menu);
}
add_action('admin_menu', 'custom_admin_menu_separator');

function change_post_menu_position() {
    global $menu;
    $post_menu_index = null;
    foreach ($menu as $index => $item) {
        if (!empty($item[2]) && $item[2] === 'edit.php') {
            $post_menu_index = $index;
            break;
        }
    }
    if ($post_menu_index !== null) {
        $menu[27] = $menu[$post_menu_index];
        unset($menu[$post_menu_index]);
    }
}
add_action('admin_menu', 'change_post_menu_position');


/**
 * Convert a given date and time to a human-readable format.
 *
 * @param string $date_time The date and time to be converted
 * @return string The formatted date and time
 */
function humanDate($date_time) {
    $timestamp = strtotime($date_time);
    return date('j.n.Y | H:i', $timestamp);
}

/**
 * Formats the given date and time into HTML format.
 *
 * @param string $dateTime The date and time to be formatted.
 * @return string The HTML formatted date and time.
 */
function htmlDate($dateTime) {
    $timestamp = strtotime($dateTime);
    return '<span class="date">' . date('j.n.Y', $timestamp) . '</span><span class="time">' . date('H:i', $timestamp) . '</span>';
}

function postEditButton() {
    if (get_option('edit_on_title') === 'on') the_editable_post();
}

?>
