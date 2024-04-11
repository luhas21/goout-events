<?php

function plugin_welcome_message() {
    echo '<p>Hello, welcome to GoOut Events WordPress plugin!</p>';
}
add_shortcode('welcome_message', 'plugin_welcome_message');


add_action('admin_menu', 'goout_custom_menu');

function goout_custom_menu() {
    add_menu_page(__("Základní nastavení stránek", "t"), __("GoOut", "t"), "manage_options", "basic_settings_page", "basic_settings_page", "dashicons-admin-generic", 73);
    add_submenu_page("basic_settings_page", __("Základní nastavení", "t"), __("Základní nastavení", "t"), "manage_options", "basic_settings_page");
    if (get_option('basic_website_type') == 'hall') {
        add_submenu_page('basic_settings_page', __("Nastavení sálu", "t"), __("Nastavení sálu", "t"), "manage_options",
        'hall_settings_page', 'hall_settings_page');
    } else if (get_option('basic_website_type') == 'festival') {
        add_submenu_page('basic_settings_page', __("Nastavení fesstivalu", "t"), __("Nastavení festivalu", "t"), "manage_options", 'festival_settings_page', 'festival_settings_page');
    } else if (get_option('basic_website_type') == 'exhibition') {
        add_submenu_page('basic_settings_page', __("Nastavení výstavy", "t"), __("Nastavení výstavy", "t"), "manage_options", 'exhibition_settings_page', 'exhibition_settings_page');
    } else if (get_option('basic_website_type') == 'goout-feed') {
        add_submenu_page('basic_settings_page', __("GoOut Feed", "t"), __("GoOut Feed", "t"), "manage_options", 'goout-feed_settings_page', 'goout-feed_settings_page');
    }
    add_submenu_page('basic_settings_page', __("Sociální sítě", "t"), __("Sociální sítě", "t"), "manage_options", 'socials_settings_page', 'socials_settings_page');
    add_submenu_page('basic_settings_page', __("Cookies", "t"), __("Nastavení Cookies", "t"), "manage_options", 'cookies_settings_page', 'cookies_settings_page');
}

function custom_menu_styles() {
    echo '<style>
        #toplevel_page_basic_settings_page .wp-menu-name {
            color: #00b6eb !important;
            font-weight: bold !important;
        }
        #toplevel_page_basic_settings_page .dashicons-admin-generic:before {
            color: #00b6eb !important;
        }
    </style>';
}
add_action('admin_head', 'custom_menu_styles');

function basic_settings_page() {
    ?>
    <div class="wrap">
        <h2><?php _e('GoOut - Základní nastavení stránek', 't'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('basic_settings_group'); ?>
            <?php do_settings_sections('basic_settings_page'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function socials_settings_page() {
    ?>
    <div class="wrap">
        <h2><?php _e('GoOut - Nastavení sociálních sítí a mobilních aplikací', 't'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('socials_settings_group'); ?>
            <?php do_settings_sections('socials_settings_page'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function cookies_settings_page() {
    ?>
    <div class="wrap">
        <h2><?php _e('GoOut - Nastavení cookies', 't'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('cookies_settings_group'); ?>
            <?php do_settings_sections('cookies_settings_page'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function basic_settings() {
    //// Basic settings sections registration

    // Section "Základní nastavení" registration
    add_settings_section("section_basic_settings", __("Nastavení typu stránek", "t"), null, "basic_settings_page");

    // Basic plugin website type selection (hall, festival, exhibition)
    add_settings_field("basic_website_type", __("Typ stránek", "t"), "display_basic_website_type", "basic_settings_page", "section_basic_settings");
    register_setting("basic_settings_group", "basic_website_type");

    // Section "Hlavní barva stránek" registration
    add_settings_section("section_main_color", __("Nastavení barev stránek", "t"), null, "basic_settings_page");

    // Main color field
    add_settings_field("main_color", __("Hlavní barva stránek", "t"), "display_main_color", "basic_settings_page", "section_main_color");
    register_setting("basic_settings_group", "main_color");

    // Button color field
    add_settings_field("button_color", __("Barva tlačítek", "t"), "display_button_color", "basic_settings_page", "section_main_color");
    register_setting("basic_settings_group", "button_color");

    // Section "Custome post types" registration
    add_settings_section("section_cpts_settings", __("Nastavení modulů", "t"), null, "basic_settings_page");

    // People
    add_settings_field("people", __("Lidé", "t"), "display_people_checkbox", "basic_settings_page", "section_cpts_settings");
    register_setting("basic_settings_group", "people");

    // Partners
    add_settings_field("partners", __("Partneři", "t"), "display_partners_checkbox", "basic_settings_page", "section_cpts_settings");
    register_setting("basic_settings_group", "partners");

    // Tickets
    add_settings_field("tickets", __("Vstupenky", "t"), "display_tickets_checkbox", "basic_settings_page", "section_cpts_settings");
    register_setting("basic_settings_group", "tickets");

    // Files
    add_settings_field("files", __("Soubory", "t"), "display_files_checkbox", "basic_settings_page", "section_cpts_settings");
    register_setting("basic_settings_group", "files");

    // Questions and Answers
    add_settings_field("q_and_a", __("Nejčastější otázky", "t"), "display_q_and_a_checkbox", "basic_settings_page", "section_cpts_settings");
    register_setting("basic_settings_group", "q_and_a");

    // Section "Doplňky" registration
    add_settings_section("section_add-ons_settings", __("Další nastavení", "t"), null, "basic_settings_page");

    // Edit on title Add on
    add_settings_field("edit_on_title", __("Editační tlačítka", "t"), "display_edit_on_title_checkbox", "basic_settings_page", "section_add-ons_settings");
    register_setting("basic_settings_group", "edit_on_title");

    // Disable admin bar on frontend
    add_settings_field("disable_admin_bar", __("Navigační lišta na frontendu", "t"), "display_disable_admin_bar_checkbox", "basic_settings_page", "section_add-ons_settings");
    register_setting("basic_settings_group", "disable_admin_bar");

    // Disable unwanted_boxes WordPress features Add on
    add_settings_field("disable_unwanted_boxes", __("Boxy v administraci", "t"), "display_disable_unwanted_boxes_checkbox", "basic_settings_page", "section_add-ons_settings");
    register_setting("basic_settings_group", "disable_unwanted_boxes");

    // Edit on title Add on
    add_settings_field("disable_editor", __("HTML editor", "t"), "display_disable_editor_checkbox", "basic_settings_page", "section_add-ons_settings");
    register_setting("basic_settings_group", "disable_editor");
}
add_action("admin_init", "basic_settings");

function socials_settings() {

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


    // Section "Odkazy na aplikace" registration
    add_settings_section("section_app_links", __("Odkazy na mobilní aplikace a úvodní video", "t"), null, "socials_settings_page");

    // Android app field
    add_settings_field("android_app_link", __("Odkaz na Android aplikaci", "t"), "display_android_app_link", "socials_settings_page", "section_app_links");
    register_setting("socials_settings_group", "android_app_link");

    // iOS app field
    add_settings_field("ios_app_link", __("Odkaz na iOS aplikaci", "t"), "display_ios_app_link", "socials_settings_page", "section_app_links");
    register_setting("socials_settings_group", "ios_app_link");

    // HomePage video field
    add_settings_field("video_link", __("Odkaz na úvodní youtube video", "t"), "display_video_link", "socials_settings_page", "section_app_links");
    register_setting("socials_settings_group", "video_link");
}
add_action("admin_init", "socials_settings");


function cookies_settings() {

    //// cookie networks sections registration

    // Section "Základní nastavení Cookies" registration
    add_settings_section("section_cookies_usage", __("Základní nastavení Cookies", "t"), null, "cookies_settings_page");

    // Cookie usage turn on/field
    add_settings_field("use_cookies", __("Podpora Cookies", "t"), "display_use_cookies", "cookies_settings_page", "section_cookies_usage");
    register_setting("cookies_settings_group", "use_cookies");


    // Section "Kódy pro Cookies" registration
    add_settings_section("section_cookies_codes", __("Kódy pro Cookies", "t"), null, "cookies_settings_page");

    // Sklick ID field
    add_settings_field("sklick_code", __("Sklik ID", "t"), "display_sklick_id", "cookies_settings_page", "section_cookies_codes");
    register_setting("cookies_settings_group", "sklick_code");

    // Facebook Pixel ID field
    add_settings_field("facebook_pixel_id", __("Kód Facebook", "t"), "display_facebook_pixel_id", "cookies_settings_page", "section_cookies_codes");
    register_setting("cookies_settings_group", "facebook_pixel_id");

    // Google Analytics ID field
    add_settings_field("google_analytics_id", __("Google Analytics ID", "t"), "display_google_analytics_id", "cookies_settings_page", "section_cookies_codes");
    register_setting("cookies_settings_group", "google_analytics_id");

    // Google Ads ID field
    add_settings_field("google_ads_id", __("Kód Instagram", "t"), "display_google_ads_id", "cookies_settings_page", "section_cookies_codes");
    register_setting("cookies_settings_group", "google_ads_id");
}
add_action("admin_init", "cookies_settings");


// Basic website type settings fields functions

function display_basic_website_type() {
    $basic_website_type = get_option("basic_website_type");
    ?>
    <select name="basic_website_type">
        <option value="no-type" selected="<?php selected("no-type", $basic_website_type); ?>">Bez nastavení</option>
        <option value="hall" <?php selected("hall", $basic_website_type); ?>>Divadlo/Kino</option>
        <option value="festival" <?php selected("festival", $basic_website_type); ?>>Festival</option>
        <option value="exhibition" <?php selected("exhibition", $basic_website_type); ?>>Výstava</option>
    </select>
    <?php
}

function display_main_color() {
    $main_color = get_option("main_color");
    ?>
    <div style="margin-top: -25px; display: inline-block;">
        <div class="color-preview" style="background-color: <?php echo esc_attr($main_color); ?>; color: #fff; border: 1px solid #000; width: 90px; height: 28px; margin-bottom: -10px; display: inline-flex; justify-content: center; align-items: center;"><?php echo $main_color; ?></div>
        <input type="text" id="main_color" name="main_color" value="<?php echo esc_attr($main_color); ?>" style="display: inline-block; width: 90px; margin: 0 10px
" />
        <p class="description" style="display: inline-block;"><?php _e('Nastavte hlavní barvu webu ve formátu #FFFFFF.', 't'); ?></p>
    </div>
    <?php
}
function display_button_color() {
    $button_color = get_option("button_color");
    ?>
    <div style="margin-top: -25px; display: inline-block;">
        <div class="color-preview" style="background-color: <?php echo esc_attr($button_color); ?>; color: #fff; border: 1px solid #000; width: 90px; height: 28px; margin-bottom: -10px; display: inline-flex; justify-content: center; align-items: center;"><?php echo $button_color; ?></div>
        <input type="text" id="button_color" name="button_color" value="<?php echo esc_attr($button_color); ?>" style="display: inline-block; width: 90px; margin: 0 10px
" />
        <p class="description" style="display: inline-block;"><?php _e('Nastavte barvu tlacítka ve formátu #FFFFFF.', 't'); ?></p>
    </div>
    <?php
}

// Modules settings fields functions
function display_people_checkbox() {
    $people = get_option("people");
    ?>
    <input type="checkbox" name="people" <?php echo checked('on', $people, false); ?> /> <?php _e('Pro zapnutí modulu "Lidé" zaškrtněte.', 't'); ?>
    <?php
}

function display_partners_checkbox() {
    $partners = get_option("partners");
    ?>
    <input type="checkbox" name="partners" <?php echo checked('on', $partners, false); ?> /> <?php _e('Pro zapnutí modulu "Partneři" zaškrtněte.', 't'); ?>
    <?php
}

function display_files_checkbox() {
    $files = get_option("files");
    ?>
    <input type="checkbox" name="files" <?php echo checked('on', $files, false); ?> /> <?php _e('Pro zapnutí modulu "Soubory" zaškrtněte.', 't'); ?>
    <?php
}

function display_tickets_checkbox() {
    $tickets = get_option("tickets");
    ?>
    <input type="checkbox" name="tickets" <?php echo checked('on', $tickets, false); ?> /> <?php _e('Pro zapnutí modulu "Vstupenky" zaškrtněte.', 't'); ?>
    <?php
}

function display_q_and_a_checkbox() {
    $q_and_a = get_option("q_and_a");
    ?>
    <input type="checkbox" name="q_and_a" <?php echo checked('on', $q_and_a, false); ?> /> <?php _e('Pro zapnutí modulu "Nejčastější dotazy (Q&A)" zaškrtněte.', 't'); ?>
    <?php
}

// Add on settings fields functions

function display_edit_on_title_checkbox() {
    $edit_on_title = get_option("edit_on_title");
    ?>
    <input type="checkbox" name="edit_on_title" <?php echo checked('on', $edit_on_title, false); ?> /> <?php _e('Pro zapnutí Editačních tlačítek zaškrtněte.', 't'); ?>
    <?php
}

function display_disable_admin_bar_checkbox() {
    $disable_admin_bar = get_option("disable_admin_bar");
    ?>
    <input type="checkbox" name="disable_admin_bar" <?php echo checked('on', $disable_admin_bar, false); ?> /> <?php _e('Pro vypnutí navigační lišty na frontendu zaškrtněte.', 't'); ?>
    <?php
}

function display_disable_unwanted_boxes_checkbox() {
    $disable_unwanted_boxes = get_option("disable_unwanted_boxes");
    ?>
    <input type="checkbox" name="disable_unwanted_boxes" <?php echo checked('on', $disable_unwanted_boxes, false); ?> /> <?php _e('Pro vypnutí nepotřebných boxů v administraci zaškrtněte.', 't'); ?>
    <?php
}

function display_disable_editor_checkbox() {
    $disable_editor = get_option("disable_editor");
    ?>
    <input type="checkbox" name="disable_editor" <?php echo checked('on', $disable_editor, false); ?> /> <?php _e('Pro zapnutí HTML módu jako výchozí pro editor příspěvků zaškrtněte.', 't'); ?>
    <?php
}

// Socials settings fields functions

function display_facebook_link() {
    $facebook_link = get_option("facebook_link");
    ?>
    <input type="text" name="facebook_link" value="<?php echo esc_attr($facebook_link); ?>" style="width: 700px;" />
    <p class="description"><?php _e('Zadejte odkaz pro Facebook včetně https:// na začátku.', 't'); ?></p>
    <?php
}

function display_instagram_link() {
    $instagram_link = get_option("instagram_link");
    ?>
    <input type="text" name="instagram_link" value="<?php echo esc_attr($instagram_link); ?>" style="width: 700px;" />
    <p class="description"><?php _e('Zadejte odkaz pro Instagram včetně https:// na začátku.', 't'); ?></p>
    <?php
}

function display_x_link() {
    $x_link = get_option("x_link");
    ?>
    <input type="text" name="x_link" value="<?php echo esc_attr($x_link); ?>" style="width: 700px;" />
    <p class="description"><?php _e('Zadejte odkaz pro X včetně https:// na začátku.', 't'); ?></p>
    <?php
}

function display_youtube_link() {
    $youtube_link = get_option("youtube_link");
    ?>
    <input type="text" name="youtube_link" value="<?php echo esc_attr($youtube_link); ?>" style="width: 700px;" />
    <p class="description"><?php _e('Zadejte odkaz pro YouTube včetně https:// na začátku.', 't'); ?></p>
    <?php
}

function display_spotify_link() {
    $spotify_link = get_option("spotify_link");
    ?>
    <input type="text" name="spotify_link" value="<?php echo esc_attr($spotify_link); ?>" style="width: 700px;" />
    <p class="description"><?php _e('Zadejte odkaz pro Spotify včetně https:// na začátku.', 't'); ?></p>
    <?php
}

function display_android_app_link() {
    $android_app_link = get_option("android_app_link");
    ?>
    <input type="text" name="android_app_link" value="<?php echo esc_attr($android_app_link); ?>" style="width: 700px;" />
    <p class="description"><?php _e('Zadejte odkaz pro Android aplikaci včetně https:// na začátku.', 't'); ?></p>
    <?php
}

function display_ios_app_link() {
    $ios_app_link = get_option("ios_app_link");
    ?>
    <input type="text" name="ios_app_link" value="<?php echo esc_attr($ios_app_link); ?>" style="width: 700px;" />
    <p class="description"><?php _e('Zadejte odkaz pro iOS aplikaci včetně https:// na začátku.', 't'); ?></p>
    <?php
}

function display_video_link() {
    $video_link = get_option("video_link");
    ?>
    <input type="text" name="video_link" value="<?php echo esc_attr($video_link); ?>" style="width: 700px;" />
    <p class="description"><?php _e('Zadejte odkaz pro youtube video na úvodní stránce včetně https:// na začátku.', 't'); ?></p>
    <?php
}

function display_use_cookies() {
    $use_cookies = get_option("use_cookies");
    ?>
    <input type="checkbox" name="use_cookies" <?php echo checked('on', $use_cookies, false); ?> /> <?php _e('Pro zapnutí podpory Cookies zaškrtněte.', 't'); ?>
    <?php
}

function display_sklick_id() {
    $sklick_id = get_option("sklick_id");
    ?>
    <input type="text" name="sklick_id" value="<?php echo esc_attr($sklick_id); ?>" style="width: 300px;" />
    <p class="description"><?php _e('Zadejte ID pro Sklick.', 't'); ?></p>
    <?php
}

function display_facebook_pixel_id() {
    $facebook_pixel_id = get_option("facebook_pixel_id");
    ?>
    <input type="text" name="facebook_pixel_id" value="<?php echo esc_attr($facebook_pixel_id); ?>" style="width: 300px;" />
    <p class="description"><?php _e('Zadejte ID pro Facebook Pixel.', 't'); ?></p>
    <?php
}

function display_google_analytics_id() {
    $google_analytics_id = get_option("google_analytics_id");
    ?>
    <input type="text" name="google_analytics_id" value="<?php echo esc_attr($google_analytics_id); ?>" style="width: 300px;" />
    <p class="description"><?php _e('Zadejte ID pro Google Analytics', 't'); ?></p>
    <?php
}

function display_google_ads_id() {
    $google_ads_id = get_option("google_ads_id");
    ?>
    <input type="text" name="google_ads_id" value="<?php echo esc_attr($google_ads_id); ?>" style="width: 300px;" />
    <p class="description"><?php _e('Zadejte ID pro Google Ads.', 't'); ?></p>
    <?php
}

?>
