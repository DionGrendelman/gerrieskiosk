<?php get_header(); ?>
    <div class="px-5 py-3  bg-white">

        <h1 class="text-center font-weight-bold">Welkom</h1>
        <h3 class="text-center text-muted font-italic">Telefoon: 0523-250390</h3>
        <?php while (have_posts()) : the_post(); ?>

            <?php the_content(); ?>

        <?php endwhile; ?>
    </div>
    <div class="px-5 bg-light">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-12 col-md-6 py-3">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-6">
                            <img class="w-100 bordered" style="height:150px;object-fit: cover;"
                                 src="<?php echo get_template_directory_uri(); ?>/assets/media/speeltuin.jpg">
                        </div>
                        <div class="col-12">Een grote speeltuin</div>
                    </div>
                </div>
                <div class="col-12 col-md-6 py-3">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-6">
                            <img class="w-100 bordered" style="height:150px;object-fit: cover;"
                                 src="<?php echo get_template_directory_uri(); ?>/assets/media/snackbar.jpg">
                        </div>
                        <div class="col-12">Gezellig sfeer en goed eten!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-3 bg-white">
        <div class="row justify-content-center">
            <div class="col-12 w-100 row justify-content-center">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/media/wifi.png" style="width: 40%;height:80px;object-fit:contain;"/>
            </div>
<!--            <div class="col-12 h-100">-->
<!--             <div class="row justify-content-center align-items-center h-100">-->
<!--                 <a class="btn btn-primary col-6" href="https://boeken.vakantiegevoel.nl/hogenboom/object/resourceid/12540033/objectid/1920016/dc/DBEI/rc/aanbeig/lan/nl/ownerid/92749190/myenv/true">Direct reserveren!</a>-->
<!--             </div>-->
<!--            </div>-->
        </div>
    </div>
    <div class="px-5 py-3  bg-white">

    </div>
<?php get_footer(); ?>