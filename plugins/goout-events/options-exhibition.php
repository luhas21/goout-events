<?php

function exhibition_settings_page() {
    ?>
    <div class="wrap">
        <h2><?php _e('GoOut - Nastavení webu pro výstavy, muzea a galerie', 't'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('exhibition_settings_group'); ?>
            <?php do_settings_sections('exhibition_settings_page'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


function goout_cinema_settings() {
    //// Basic settings sections registration

    // Section "Základní nastavení" registration
    add_settings_section("section_exhibition_settings", __("Základní nastavení", "t"), null, "exhibition_settings_page");

    add_settings_field("exhibition_logo", __("Zapnout zobrazení loga", "t"), "display_exhibition_logo_checkbox", "exhibition_settings_page", "section_exhibition_settings");
    register_setting("exhibition_settings_group", "display_logo");

}
add_action("admin_init", "goout_cinema_settings");

function display_exhibition_logo_checkbox() {
    $display_logo = get_option("display_logo");
    ?>
    <input type="checkbox" name="display_logo" <?php echo checked('on', $display_logo, false); ?> /> <?php _e('Pro zobrazení loga zaškrtněte.', 't'); ?>
    <?php
}
