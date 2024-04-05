<?php

function festival_settings_page() {
    ?>
    <div class="wrap">
        <h2><?php _e('GoOut - Základní nastavení Festivalu', 't'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('festival_settings_group'); ?>
            <?php do_settings_sections('festival_settings_page'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function festival_settings() {

    //// festival settings sections registration

    // Section "Nastavení termínů festivalu" registration
    add_settings_section("section_festival_settings", __("Nastavení termínů festivalu", "t"), null, "festival_settings_page");

    // Start of the festival field
    add_settings_field("festival_start_date", __("Začátek festivalu", "t"), "display_festival_start_date", "festival_settings_page", "section_festival_settings");
    register_setting("festival_settings_group", "festival_start_date");

    // End of the festival filed
    add_settings_field("festival_end_date", __("Konec festivalu", "t"), "display_festival_end_date", "festival_settings_page", "section_festival_settings");
    register_setting("festival_settings_group", "festival_end_date");

    // Festival days
    add_settings_field("display_festival_days", __("Dny festivalu", "t"), "display_festival_days", "festival_settings_page", "section_festival_settings");
    register_setting("festival_settings_group", "display_festival_days");
    // Section "Zobrazení Lineupu a Harmonogramu" registration
    add_settings_section("section_display_options", __("Zobrazování prvků na webu", "t"), null, "festival_settings_page");

    // Checkbox for Zobrazit Lineup
    add_settings_field("display_lineup", __("Zobrazit Lineup", "t"), "display_lineup_checkbox", "festival_settings_page", "section_display_options");
    register_setting("festival_settings_group", "display_lineup");

    // Checkbox for Zobrazit Harmonogram
    add_settings_field("display_schedule", __("Zobrazit Harmonogram", "t"), "display_schedule_checkbox", "festival_settings_page", "section_display_options");
    register_setting("festival_settings_group", "display_schedule");

    // Checkbox for Zobrazit Adventní kalendář
    add_settings_field("display_calendar", __("Zobrazit Adventní kalendář", "t"), "display_calendar_checkbox", "festival_settings_page", "section_display_options");
    register_setting("festival_settings_group", "display_calendar");

    // Checkbox for Zobrazit Countdown
    add_settings_field("display_countdown", __("Zobrazit Countdown", "t"), "display_countdown_checkbox", "festival_settings_page", "section_display_options");
    register_setting("festival_settings_group", "display_countdown");

    // Field for Countdown Time
    add_settings_field("countdown_time", __("Čas pro Countdown", "t"), "display_countdown_time", "festival_settings_page", "section_display_options");
    register_setting("festival_settings_group", "countdown_time");


    //// Tickets settings sections registration

    // Register tickets settings group
    add_settings_section('section_tickets_info_settings', __('Nastavení informací pro vstupenky', 't'), 'section_tickets_info_settings_callback', 'tickets_settings_page');

    // Field for Tickets Info in CZ
    add_settings_field('ticket_notice_cs', __('Informace česky', 't'), 'display_ticket_notice_cs', 'tickets_settings_page', 'section_tickets_info_settings');
    register_setting('tickets_settings_group', 'ticket_notice_cs');

    // Field for Tickets Info in EN
    add_settings_field('ticket_notice_en', __('Informace anglicky', 't'), 'display_ticket_notice_en', 'tickets_settings_page', 'section_tickets_info_settings');
    register_setting('tickets_settings_group', 'ticket_notice_en');

    // Section "Sale Form Link" registration
    add_settings_section("section_sale_form_links", __("Odkazy na prodejní formuláře", "t"), 'section_sale_form_links_callback', "tickets_settings_page");

    // Field Sale Form Link CZ
    add_settings_field("sale_form_link_cs", __("Odkaz na český formulář", "t"), "display_sale_form_link_cs", "tickets_settings_page", "section_sale_form_links");
    register_setting("tickets_settings_group", "sale_form_link_cs");

    // Field Sale Form Link EN
    add_settings_field("sale_form_link_en", __("Odkaz na anglický formulář", "t"), "display_sale_form_link_en", "tickets_settings_page", "section_sale_form_links");
    register_setting("tickets_settings_group", "sale_form_link_en");

    //// Social networks sections registration

    // Section "Odkazy na sociální sítě" registration
    add_settings_section("section_socials_links", __("Odkazy na sociální sítě", "t"), null, "socials_settings_page");

    // Facebook link field
    add_settings_field("facebook_link", __("Odkaz na Facebook", "t"), "display_facebook_link", "socials_settings_page", "section_socials_links");
    register_setting("socials_settings_group", "facebook_link");

    // X link field
    add_settings_field("x_link", __("Odkaz na X", "t"), "display_x_link", "socials_settings_page", "section_socials_links");
    register_setting("socials_settings_group", "x_link");

    // Instagram link field
    add_settings_field("instagram_link", __("Odkaz na Instagram", "t"), "display_instagram_link", "socials_settings_page", "section_socials_links");
    register_setting("socials_settings_group", "instagram_link");

    // Youtube link field
    add_settings_field("youtube_link", __("Odkaz na YouTube", "t"), "display_youtube_link", "socials_settings_page", "section_socials_links");
    register_setting("socials_settings_group", "youtube_link");

    // Spotify link field
    add_settings_field("spotify_link", __("Odkaz na Spotify", "t"), "display_spotify_link", "socials_settings_page", "section_socials_links");
    register_setting("socials_settings_group", "spotify_link");
}
add_action("admin_init", "festival_settings");




// festival settings fields functions

function display_festival_start_date() {
    $festival_start_date = get_option("festival_start_date");
    ?>
    <input type="date" name="festival_start_date" value="<?php echo esc_attr($festival_start_date); ?>" />
    <p class="description"><?php _e('Vyberte datum začátku festivalu.', 't'); ?></p>
    <?php
}

function display_festival_end_date() {
    $festival_end_date = get_option("festival_end_date");
    ?>
    <input type="date" name="festival_end_date" value="<?php echo esc_attr($festival_end_date); ?>" />
    <p class="description"><?php _e('Vyberte datum konce festivalu.', 't'); ?></p>
    <?php
}

function count_festival_days() {
    $festival_start_date = get_option("festival_start_date");
    $festival_end_date = get_option("festival_end_date");
    if (!empty($festival_start_date) && !empty($festival_end_date)) {
        $start_date = new DateTime($festival_start_date);
        $end_date = new DateTime($festival_end_date);
        $days_in_czech = [
            'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota', 'neděle'
        ];
        $festival_days = [];
        while ($start_date <= $end_date) {
            $day_index = $start_date->format('N') - 1;
            $festival_days[] = $days_in_czech[$day_index];
            $start_date->modify('+1 day');
        }
        update_option('festival_days', $festival_days);
    } else {
        delete_option('festival_days');
    }
}
add_action('admin_init', 'count_festival_days');

function display_festival_days() {
    $festival_days = get_option("festival_days");

    if (!empty($festival_days)) {
        echo '<p><b>| ';
        foreach ($festival_days as $day) {
            _e(esc_html($day), 't');
            echo ' | ';
        }
        echo '</b></p>';
    }
}

function display_lineup_checkbox() {
    $display_lineup = get_option("display_lineup");
    ?>
    <input type="checkbox" name="display_lineup" <?php checked("on", $display_lineup); ?> /> <?php _e('Pro zobrazení Lineupu zaškrtněte.', 't'); ?>
    <?php
}

function display_schedule_checkbox() {
    $display_schedule = get_option("display_schedule");
    ?>
    <input type="checkbox" name="display_schedule" <?php checked("on", $display_schedule); ?> /> <?php _e('Pro zobrazení Harmonogramu zaškrtněte.', 't'); ?>
    <?php
}

function display_calendar_checkbox() {
    $display_calendar = get_option("display_calendar");
    ?>
    <input type="checkbox" name="display_calendar" <?php checked("on", $display_calendar); ?> /> <?php _e('Pro zobrazení Adventního kalendáře zaškrtněte.', 't'); ?>
    <?php
}

function display_countdown_checkbox() {
    $display_countdown = get_option("display_countdown");
    ?>
    <input type="checkbox" name="display_countdown" <?php checked("on", $display_countdown); ?> /> <?php _e('Pro zobrazení Countdown zaškrtněte.', 't'); ?>
    <?php
}

function display_countdown_time() {
    $countdown_time = get_option("countdown_time");
    ?>
    <input type="text" name="countdown_time" value="<?php echo esc_attr($countdown_time); ?>" />
    <p class="description"><?php _e('Zadejte čas pro Countdown ve formátu hh:mm:ss.', 't'); ?></p>
    <?php
}

function save_theme_settings() {
    count_festival_days();
    if (isset($_POST['countdown_time'])) {
        $countdown_time = sanitize_text_field($_POST['countdown_time']);
        update_option('countdown_time', $countdown_time);
    }
    if (isset($_POST['festival_start_date'])) {
        $festival_start_date = sanitize_text_field($_POST['festival_start_date']);
        update_option('festival_start_date', $festival_start_date);
    }
    if (isset($_POST['festival_end_date'])) {
        $festival_end_date = sanitize_text_field($_POST['festival_end_date']);
        update_option('festival_end_date', $festival_end_date);
    }
}
add_action('admin_init', 'save_theme_settings');


// Tickets settings fields functions

function section_tickets_info_settings_callback() {
    echo '<p>' . __('Zadejte informace pro vstupenky v češtině a v angličtině.', 't') . '</p>';
}

// Option for settings to edit tickets page notice message
function display_ticket_notice_cs() {
    $content_cs = get_option('ticket_notice_cs');
    wp_editor(stripslashes($content_cs), 'ticket_notice_cs');
}

function display_ticket_notice_en() {
    $content_en = get_option('ticket_notice_en');
    wp_editor(stripslashes($content_en), 'ticket_notice_en');
}


function section_sale_form_links_callback() {
    echo '<p>' . __('Zadejte odkazy na prodejní formuláře v češtině a v angličtině.', 't') . '</p>';
}


function display_sale_form_link_cs() {
    $sale_form_link_cs = get_option("sale_form_link_cs");
    ?>
    <input type="text" name="sale_form_link_cs" value="<?php echo esc_attr($sale_form_link_cs); ?>" style="width: 700px;" />
    <p class="description"><?php _e('Zadejte odkaz pro český prodejní formulář (včetně https:// na začátku.)', 't'); ?></p>
    <?php
}

function display_sale_form_link_en() {
    $sale_form_link_en = get_option("sale_form_link_en");
    ?>
    <input type="text" name="sale_form_link_en" value="<?php echo esc_attr($sale_form_link_en); ?>" style="width: 700px;" />
    <p class="description"><?php _e('Zadejte odkaz pro anglický prodejní formulář (včetně https:// na začátku.)', 't'); ?></p>
    <?php
}
