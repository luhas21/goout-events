<?php get_header(); ?>

<main>
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            ?>
            <h2 <?php postEditButton(); ?>><?php the_title(); ?></h2>
            <hr class="event-hr">
            <hr class="event-hr">
            <?php the_content(); ?>
            <?php
        }
        echo futureEventDates(get_the_ID());
    }
    ?>
</main>

<?php get_footer(); ?>
