<?php /* Template Name: Side Image Template */ ?>

<?php get_header(); ?>
    <div class="container px-5 py-3 bg-white">
        <h2 class="font-weight-bold"><?php the_title(); ?></h2>

        <div class="row">
            <div class="col-12 col-md-6">
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php the_content(); ?>

                <?php endwhile; ?>
            </div>
            <div class="col-12 col-md-6">
             <img src="<?php echo get_the_post_thumbnail_url();?>" class="w-100"/>
            </div>
        </div>
    </div>
<?php get_footer(); ?>