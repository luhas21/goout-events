<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/styles.css">

    <?php wp_head(); ?>
</head>
<body>

    <nav id="main-menu">
        <?php wp_nav_menu(['theme_location' => 'main-menu-location']); ?>
    </nav>

    <hr width="100%" size="1" color="grey" noshade>
