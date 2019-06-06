<?php /* Template Name: Contact Template */ ?>

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
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2428.0485921676645!2d6.575860815807269!3d52.514459679813214!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c7ffd382141d05%3A0x4f8c2dd7b2606b10!2sGerrie&#39;s+Kiosk!5e0!3m2!1snl!2snl!4v1559834440813!5m2!1snl!2snl" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
<?php get_footer(); ?>