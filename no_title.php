<?php /* Template Name: Geen Title Template */ ?>

<?php get_header(); ?>
    <div class="p-3  bg-white" >
        <?php while ( have_posts() ) : the_post(); ?>

            <?php the_content(); ?>

        <?php endwhile; ?>
    </div>
<?php get_footer();  ?>