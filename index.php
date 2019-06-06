<?php get_header(); ?>
    <div class="px-5 py-3 bg-white">
        <?php while ( have_posts() ) : the_post(); ?>

            <h2 class="font-weight-bold"><?php the_title(); ?></h2>
            <?php the_content(); ?>

        <?php endwhile; ?>
    </div>
<?php get_footer();  ?>