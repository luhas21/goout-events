<?php

function hall_settings_page() {
    ?>
    <div class="wrap">
        <h2><?php _e('GoOut - Nastavení webu pro divadla a kina', 't'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('hall_settings_group'); ?>
            <?php do_settings_sections('hall_settings_page'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


function goout_cinema_settings() {
    //// Basic settings sections registration

    // Section "Základní nastavení" registration
    add_settings_section("section_hall_settings", __("Základní nastavení", "t"), null, "hall_settings_page");

    add_settings_field("hall_repertoar", __("Zapnout zobrazení repertoáru", "t"), "display_hall_repertoar_checkbox", "hall_settings_page", "section_hall_settings");
    register_setting("hall_settings_group", "display_repertoar");

}
add_action("admin_init", "goout_cinema_settings");

function display_hall_repertoar_checkbox() {
    $display_repertoar = get_option("display_repertoar");
    ?>
    <input type="checkbox" name="display_repertoar" <?php echo checked('on', $display_repertoar, false); ?> /><?php _e('Pro zobrazení repertoáru zaškrtněte.', 't'); ?>
    <?php
}

function filter_menu_items_based_on_option($items, $args) {
    $display_repertoar = get_option("display_repertoar");

    if ($display_repertoar === 'on') {
        return $items;
    }

    foreach ($items as $key => $item) {
        if ($item->title === 'Repertoár') {
            unset($items[$key]);
        }
    }

    return $items;
}
add_filter('wp_nav_menu_objects', 'filter_menu_items_based_on_option', 10, 2);
