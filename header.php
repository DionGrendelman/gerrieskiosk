<?php
$custom_logo_id = get_theme_mod( 'custom_logo' );
$image          = wp_get_attachment_image_src( $custom_logo_id, 'full' );
?>
<!DOCTYPE html>
<html>
<head>

    <title><?PHP bloginfo( 'name' ); ?><?PHP wp_title( '|' ); ?></title>
    <meta name="copyright" content="<?php date( 'Y' ); ?> - <?PHP bloginfo( 'name' ); ?>">
    <meta name="author" content="<?PHP bloginfo( 'name' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="<?php echo get_template_directory_uri() ?>/assets/fontawesome/css/all.css" rel="stylesheet">
    <!--load all styles --> <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/css/ol.css"
          type="text/css">
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="<?php echo get_template_directory_uri() ?>/assets/js/script.js"></script>
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div class="container p-0">
    <nav class="navbar navbar-expand-md navbar-light bg-primary py-0 " role="navigation">
        <div class="container justify-content-center py-2">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="row w-100 justify-content-center d-flex d-md-none">
                <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#main-menu-header-sub"
                        aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon text-white"></span>
                </button>
            </div>
            <?php
            wp_nav_menu( array(
                'theme_location'  => 'primary',
                'depth'           => 3,
                'container'       => 'div',
                'container_class' => 'd-none d-md-flex justify-content-center text-white',
                'container_id'    => 'main-menu-header',
                'menu_class'      => 'nav navbar-nav',
                'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                'walker'          => new WP_Bootstrap_Navwalker(),
            ) );
            ?>
        </div>
    </nav>
    <div class="navbar-light bg-white text-black">
        <?php
        wp_nav_menu( array(
            'theme_location'  => 'primary',
            'depth'           => 2,
            'container'       => 'div',
            'container_class' => 'collapse navbar-collapse justify-content-center text-center bg-tertiary text-dark mobile_nav',
            'container_id'    => 'main-menu-header-sub',
            'menu_class'      => 'nav navbar-nav',
            'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
            'walker'          => new WP_Bootstrap_Navwalker(),
        ) );
        ?>
    </div>
    <?php echo do_shortcode( '[rev_slider alias="homepage"]' ); ?>
