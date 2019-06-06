
<?php
if(get_post_meta( get_the_ID(), 'personal_page_second', true ) == '1'){
	wp_safe_redirect( wp_get_referer() );
}
get_header();
$featured_img_url = get_the_post_thumbnail_url( $post->ID, 'full' );

?>

    <div class="container my-3">
        <a href="<?php echo wp_get_referer(); ?>"><h5><- Terug</h5></a>
		<?php while ( have_posts() ) : the_post(); ?>
            <h2 class="font-weight-bold"><?php the_title(); ?></h2>

			<?php the_content(); ?>
		<?php endwhile; ?>
        <div class="row">
            <div class="col-12">
	            <?php if ( has_post_thumbnail() ) { ?>
                    <img style="width: 50%" src="<?php echo $featured_img_url; ?>"/>
	            <?php } ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>