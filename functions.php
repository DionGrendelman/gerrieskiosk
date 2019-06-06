<?php
if (is_user_logged_in()) {
	show_admin_bar(true);
}
$templatename = 'Vakantiehuisvlagtwedde';

require_once('assets/class-wp-bootstrap-navwalker.php');
require_once(__DIR__ . '/core/framework.php');
$menu = array(
    'primary' => 'Primary Menu',
    'sidebar' => 'Sociaal Menu',
);
$widget1 = array(
    'name' => 'Footer',
    'id' => 'footer',
    'description' => 'Geeft widgets weer in de footer (onderaan de pagina).',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="widget-title">',
    'after_title' => '</h2>',
);
$theme_setup = new theme_setup($templatename, 'https://'.$templatename.'.nl');
$customizer = new customizer($templatename, 'https://'.$templatename.'.nl');
//$cpt = new customposttype(
//    $templatename,
//    'Postname',
//    'Single',
//    'Singles',
//    'dashicons-media-spreadsheet',
//    1
//);


//$theme_setup->add_woocommerce_support();
$theme_setup->add_post_thumbnails_support();

$theme_setup->add_header_support('banner.png');
$theme_setup->add_custom_logo_support(250, 80);

$theme_setup->add_nav($menu);
$theme_setup->add_widget_area($widget1);


$theme_setup->add_css('main.min');
$theme_setup->add_login_css();
$theme_setup->add_admin_css();



$theme_setup->remove_action_welcome_panel();
$theme_setup->remove_action_dashboard_logo();

$theme_setup->enable_thumnail_size();

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/media/loginlogo.png);
            background-size: contain;
            width:auto
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );


// Add the URL Metabox


?>