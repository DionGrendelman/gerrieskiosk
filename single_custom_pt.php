
<?php
get_header();
$featured_img_url = get_the_post_thumbnail_url( $post->ID, 'full' );
?>
<?php if ( has_post_thumbnail() ) { ?>

    <div class="featured w-100 position-relative" style="height:450px;">

            <img class="w-100" src="<?php echo $featured_img_url; ?>"
                 style="height:450px;object-fit: cover"/>
            <div class="w-100 text-white position-absolute" style="top:0;height:450px;">
                <div class="row justify-content-end h-100 align-items-end">
                    <div class="col-12 col-md-8 h-100 pr-2" style="  background-image: -webkit-linear-gradient(150deg, rgba(40, 128, 50, 0.8) 65%, transparent 65%);">
                        <div class="row h-100  align-items-end justify-content-center">
                            <div class="col-10 col-md-6 pl-4">
                                <h1><?php the_title(); ?> </h1>
                                <p><b>Bouwjaar: </b><?php echo get_post_meta( get_the_ID(), 'build_year', true )?><br>
                                    <?php echo get_post_meta( get_the_ID(), 'tractor_info', true )?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } ?>


    </div>
    <div class="container my-3">
        <a href="<?php echo wp_get_referer(); ?>" class="ml-2"><h5><- Terug</h5></a>

        <?php while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>
		<?php endwhile; ?>

    </div>
<?php get_footer(); ?>