<?php get_header(); ?>

<main>
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            ?>
            <h2 <?php postEditButton(); ?>><?php the_title(); ?>bla bla bla</h2>
            <?php the_content(); ?>
            <?php
        }
    } ?>
    <?php listPosts('post'); ?>
    <?php displayProgram(); ?>
    <?php wp_reset_query(); ?>
    <?php displayRepertoar(); ?>
    <?php wp_reset_query(); ?>
</main>

<?php get_footer(); ?>
