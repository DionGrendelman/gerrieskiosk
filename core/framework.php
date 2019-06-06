<?php
include 'customposttype.php';
include 'customposttype_1.php';
class theme_setup
{
    //Variables
    private $logo_height = "100";
    private $logo_width = "150";
    private $prefix = '[Error] ';
    private $called_add_custom_logo = false;
    public $theme_title = '';
    public $theme_name = '';
    public $theme_link = '';
    public $basecolor = '#363b3f';
    public $primarycolor = '#4f5daa';
    public $primarycolor_1 = '##4957a0';
    public $secondary_color = '#ff9800';
    public $pt_prefix;
    public $pt_postname;
    public $pt_postname_slug;
    public $pt_single;
    public $pt_single_plural;
    public $pt_icon;


    //Constructor
    function __construct($themename, $themelink)
    {
        $this->theme_title = $themename;
        $this->theme_name = strtolower($themename);
        $this->theme_link = strtolower($themelink);
        add_filter('login_headerurl', array($this, '_add_home_url'));
    }

    function _add_home_url()
    {
        return home_url();
    }

    //-Post Thumnails Support
    function add_post_thumbnails_support()
    {
        add_theme_support('post-thumbnails');
    }

    //-Header
    function _themename_custom_logo_setup()
    {
        $defaults = array(
            'height' => $this->logo_height,
            'width' => $this->logo_width,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => array('site-title', 'site-description'),
        );
        add_theme_support('custom-logo', $defaults);
    }

    function add_header_support($placeholder)
    {
        if (!empty($placeholder)) {
            $args = array(
                'default-image' => get_template_directory_uri() . '/assets/media/' . $placeholder,
                'uploads' => true,
            );
            add_theme_support('custom-header', $args);
        } else {
            return exit($this->prefix . "You need to fill in a valid string argument at: 'function add_header_support' and make sure the format is a file and that it is inside the /images/placeholders/");
        }
    }

    function add_custom_logo_support($width, $height)
    {
        if ($this->called_add_custom_logo == false) {
            if (!empty($width) && !empty($height)) {
                $this->logo_height = $height;
                $this->logo_width = $width;
                add_action('after_setup_theme', array($this, '_themename_custom_logo_setup'));
                $this->add_custom_logo_called = true;
            } else {
                return exit($this->prefix . "You need to fill in a valid width and height argument at: 'function add_custom_logo', the width and the height can only contain numbers");
            }
        } else {
            return exit($this->prefix . "You can only use this function once at: 'function add_custom_logo'");
        }
    }

    //-Register Nav
    function add_nav($menuarray)
    {
        if (!empty($menuarray)) {
            register_nav_menus($menuarray);
        } else {
            return exit($this->prefix . "You need to fill in a valid menu array at: 'function add_nav' and make sure the format is: array('' => '','' => '');");
        }
    }

    //-Widgets
    function add_widget_area($widgetarray)
    {
        if (!empty($widgetarray)) {
            register_sidebar($widgetarray);
        } else {
            return exit($this->prefix . "You need to fill in a valid widget array at: 'function add_widget_area' and make sure the format is: array(
    'name' => '',
    'id' => '',
    'description' => '',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => '',
)");
        }
    }

    //-Woocommerce Support
    function _woocommerce_support()
    {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }

    function add_woocommerce_support()
    {
        add_action('after_setup_theme', array($this, '_woocommerce_support'));
    }
    //Style
    //Setup
    function main_css_setup($css)
    {
        wp_enqueue_style($css, get_template_directory_uri() . '/assets/css/' . $css . '.css');
    }

    function add_css($css)
    {
        if (!empty($css)) {
            if (is_admin()) return false;
            add_action('wp_enqueue_scripts', array($this, 'main_css_setup'), 10, 1);
            do_action('wp_enqueue_scripts', $css);
        } else {
            return exit($this->prefix . "You need to fill in a valid string at: 'function add_css'");
        }
    }

    //Style Adds

    function _add_login_css()
    {
        wp_enqueue_style('custom-login', get_stylesheet_directory_uri() . '/assets/css/login.css');
        wp_enqueue_script('custom-login', get_stylesheet_directory_uri() . '/assets/js/login.js');
    }

    function add_login_css()
    {
        add_action('login_enqueue_scripts', array($this, '_add_login_css'));
    }

    function _add_admin_css()
    {
        echo "<link href='" . get_bloginfo('template_url') . "/assets/css/admin.css' rel='stylesheet' type='text/css'>";
    }

    function add_admin_css()
    {
        add_action('admin_head', array($this, '_add_admin_css'));
    }

    // Maak een support widget aan
    function _add_support_widget()
    {
        wp_add_dashboard_widget(
            'complexpcwidget',
            'ComplexPC Support',
            array($this,'_support_widget')
        );

    }


    //Filters
    function _stay_logged_in_for_1_year($expire)
    {
        return 31556926; // 1 year in seconds
    }

    function filter_archive_title()
    {
        add_filter('get_the_archive_title', function ($title) {
            if (is_category()) {
                $title = single_cat_title('', false);
            } elseif (is_tag()) {
                $title = single_tag_title('', false);
            } elseif (is_author()) {
                $title = '<span class="vcard">' . get_the_author() . '</span>';
            }
            return $title;
        });
    }

    function filter_comment_clean_html()
    {
        add_filter('pre_comment_content', 'esc_html');
    }

    function filter_cookie_stay_logged_in()
    {
        add_filter('auth_cookie_expiration', array($this, '_stay_logged_in_for_1_year'));
    }

    //Remove Action
    function remove_action_wpgen()
    {
        remove_action('wp_head', 'wp_generator');
    }

    function remove_action_wlwmanifest_link()
    {
        remove_action('wp_head', 'wlwmanifest_link');
    }

    function remove_action_rsd_link()
    {
        remove_action('wp_head', 'rsd_link');
    }

    function remove_action_feed_links()
    {
        remove_action('wp_head', 'feed_links', 2);
    }

    function remove_action_feed_links_extra()
    {
        remove_action('wp_head', 'feed_links_extra', 3);
    }

    function remove_action_print_emoji()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
    }

    function remove_action_rel_canonical()
    {
        remove_action('wp_head', 'rel_canonical');
    }

    function remove_action_color_scheme()
    {
        remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
    }

    function _remove_dashboard_widgets()
    {
        global $wp_meta_boxes;

        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

    }

    function remove_action_dashboard_widgets()
    {
        add_action('wp_dashboard_setup', array($this, '_remove_dashboard_widgets'));
    }

    function remove_action_welcome_panel()
    {
        remove_action('welcome_panel', 'wp_welcome_panel');
    }

    function _remove_action_dashboard_logo($wp_admin_bar)
    {
        $wp_admin_bar->remove_node('wp-logo');
    }

    function remove_action_dashboard_logo()
    {
        add_action('admin_bar_menu', array($this, '_remove_action_dashboard_logo'), 999);
    }

    //Remove Filter
    function _remove_script_version($src)
    {
        $parts = explode('?ver', $src);
        return $parts[0];
    }

    function remove_filter_print_emoji()
    {
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    }

    function remove_filter_script_version()
    {
        add_filter('script_loader_src', array($this, '_remove_script_version'), 15, 1);
        add_filter('style_loader_src', array($this, '_remove_script_version'), 15, 1);
    }

    //Disable
    function _stop_guessing($url)
    {
        if (is_404()) {
            return false;
        }
        return $url;
    }

    function disable_quessing()
    {
        add_filter('redirect_canonical', array($this, '_stop_guessing'));
    }

    function _Disable_Comments()
    {
        wp_deregister_script('comment-reply');
    }

    function disable_comments()
    {
        add_action('init', array($this, '_Disable_Comments'));
    }

    function disable_admin_bar()
    {
        add_filter('show_admin_bar', '__return_false');
    }

    function show_admin_bar()
    {
        add_filter('show_admin_bar', '__return_true');
    }

    //enable
    function enable_thumnail_size()
    {
        set_post_thumbnail_size(300, 300);
    }

    function _custom_pt()
    {

        register_post_type($this->getPtPostnameSlug(),
            array(
                'labels' => array(
                    'name' => __($this->getPtPostname(), $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                    'singular_name' => __($this->getPtPostname(), $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                    'add_new' => __('Nieuw '.$this->getPtSingle(), $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                    'add_new_item' => __('Voeg nieuw '.$this->getPtSingle().' toe', $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                    'new_item' => __('Nieuw '.$this->getPtSingle(), $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                    'all_items' => __('Alle '.$this->getPtSinglePlural(), $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                    'search_items' => __('Zoek '.$this->getPtSingle(), $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                    'not_found' => __('Geen '.$this->getPtSinglePlural().' gevonden', $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                    'not_found_in_trash' => __('Geen '.$this->getPtSinglePlural().' gevonden in prullenbak', $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                    'edit_item' => __($this->getPtSingle().' aanpassen', $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                    'view_item' => __($this->getPtSingle().'Item weergeven', $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                ),
                'description' => __('Maak '.$this->getPtPostnameSlug().' '.$this->getPtSinglePlural(), $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
                'public' => true,
                'has_archive' => false, // "Archive" is loaded by shortcode
                'menu_position' => 5, // Below comments
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'excerpt',
                    'comments'
                ),
                'menu_icon' => $this->getPtIcon(),
            )
        );
    }

    function _register_custom_taxonomies()
    {

        register_taxonomy($this->getPtPostnameSlug().'_cat', $this->getPtPostnameSlug(), array(
            "hierarchical" => true,
            "label" => __('Categorieën', $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
            "singular_label" => __('Categorieën', $this->getPtPrefix().'-'.$this->getPtPostnameSlug()),
            'query_var' => true,
            'rewrite' => array('slug' => $this->getPtPostnameSlug().'_cat', 'with_front' => false),
            'public' => true,
            'show_ui' => true,
            'show_tagcloud' => false,
            '_builtin' => false,
            'show_in_nav_menus' => false,
              'show_admin_column' => true
        ));

    }

    function add_custom_pt()
    {
        add_action('init', array($this,'_custom_pt'), 1);
        add_action('init', array($this,'_register_custom_taxonomies'), 2);

    }


    function _add_shortcode($attributes)
    {

        $conf = shortcode_atts(array(
            'limit' => '-1',
            'sortby' => 'name',
            'columns' => '2',
            'order' => 'ASC',
            'cat' => '',
        ), $attributes);


        if ($conf['cat'] != '') {

            $args = array(
                'post_type' => $this->getPtPostnameSlug(),
                'post_status' => 'publish',
                'orderby' => $conf['sortby'],
                'posts_per_page' => $conf['limit'],
                'order' => $conf['order'],
                'tax_query' => array(
                    array(
                        'taxonomy' => $this->getPtPostnameSlug().'_cat',
                        'field' => 'name',
                        'terms' => $conf['cat'],
                    ),
                ),
            );


        } else {

            $args = array(
                'post_type' => $this->getPtPostnameSlug(),
                'post_status' => 'publish',
                'orderby' => $conf['sortby'],
                'posts_per_page' => $conf['limit'],
                'order' => $conf['order'],
            );
        }

        $wp_query = new WP_Query($args);


        $return = '<div id="" class="row">';

        if ($wp_query->have_posts()) {
            while ($wp_query->have_posts()) : $wp_query->the_post();

                $featured_img_url = get_the_post_thumbnail_url('full');

                $return .= '<div class="col-lg-4 col-md-6 col-sm-12 pb-5">';
                $return .= '<a href="' . get_the_permalink() . '"  alt="Portfolio item: ' . get_the_title() . '">';
                $return .= '<h3>' . get_the_title() . '</h3>';

                $return .= '<img src="' .  get_the_post_thumbnail_url(get_the_ID(), 'full'). '" style="width:100%; height:150px;"/></a>';
                $return .= '<p style="font-size:15px;" class="pt-4 pb-2">' . get_the_content() . '</p>';
                $return .= '<a class="btn btn-primary text-white" href="' . get_the_permalink() . '">Lees meer</a>';

                $return .= '</div>';


            endwhile;


        } else {
            echo 'Niks gevonden';
        }

        $return .= '</div>';

        return $return;

    }

    function add_shortcode_pt(){
        add_shortcode($this->getPtPrefix().'-'.$this->getPtPostnameSlug(), array($this,'_add_shortcode'));
    }

    function _pt_person_page()
    {
        global $post;
        $custom = get_post_custom($post->ID);
        $personal_page = $custom["personal_page"][0];
        if (checked('1', $personal_page, false)) {
            $active = checked('1', $personal_page, false);
            $text = 'Aanzetten';
        } else {
            $active = '';
            $text = 'Uitzetten';

        }
        ?>
        <input name="personal_page" id='personal_page' type="checkbox" class="" value="1" <?php echo $active ?>/>
        <label for="personal_page">Schakel aparte pagina uit</label>
        <?php
    }

    function _add_metabox()
    {
        add_meta_box('pt_side_personal_page', 'Aparte pagina?', array($this,'_pt_person_page'), $this->getPtPostnameSlug(), 'side', 'low');
    }

    function _save_meta_box()
    {
        global $post;
        if (get_post_type(get_the_ID()) == $this->getPtPostnameSlug()) {

            update_post_meta($post->ID, "personal_page", $_POST["personal_page"]);

        }
    }

    function _set_custom_edit_pt_columns($columns) {
        $columns_old = $columns;
        $columns = array(
            "cb" => "<input type='checkbox' />",
            "title" => "Bedrijfs Titel",
            "taxonomy-".$this->getPtPostnameSlug()."_cat" => "Categorieen",
            "personal_page" => "Aparte pagina",
        );


        return $columns;
    }

    function _custom_pt_column( $column, $post_id ) {
        switch ( $column ) {
            case 'personal_page' :
                if(get_post_meta( $post_id , 'personal_page' , true )){
                    echo 'Nee';
                } else{
                    echo 'Ja';
                };
                break;

        }
    }

    function _single_page_pt($content)
    {
        $posttype = get_post_type();
        if ($posttype === $this->getPtPostnameSlug()) {
            if (is_single() && !empty($GLOBALS['post'])) {
                if ($GLOBALS['post']->ID == get_the_ID()) {
                    $personal_page = get_post_meta(get_the_ID(), 'personal_page', true);
                    if (checked('1', $personal_page, false)) {
                        wp_safe_redirect(wp_get_referer());
                    }
                }
            }
        }

        return $content;
    }

    function add_metabox(){
        add_action("admin_init", array($this,"_add_metabox"));
        add_action('save_post', array($this,'_save_meta_box'));
        add_filter( 'manage_'.$this->getPtPostnameSlug().'_posts_columns', array($this,'_set_custom_edit_pt_columns') );
        add_action( 'manage_'.$this->getPtPostnameSlug().'_posts_custom_column' , array($this,'_custom_pt_column'), 10, 2 );
        add_filter('the_content', array($this,'_single_page_pt'));
    }

    /**
     * @return mixed
     */
    public function getPtPrefix()
    {
        return $this->pt_prefix;
    }

    /**
     * @param mixed $pt_prefix
     */
    public function setPtPrefix($pt_prefix)
    {
        $this->pt_prefix = $pt_prefix;
    }

    /**
     * @return mixed
     */
    public function getPtPostname()
    {
        return $this->pt_postname;
    }

    /**
     * @param mixed $pt_postname
     */
    public function setPtPostname($variable)
    {
        $this->pt_postname = $variable;
        $this->pt_postname_slug = strtolower($variable);
    }

    /**
     * @return mixed
     */
    public function getPtPostnameSlug()
    {
        return $this->pt_postname_slug;
    }

    /**
     * @return mixed
     */
    public function getPtSingle()
    {
        return $this->pt_single;
    }

    /**
     * @param mixed $pt_single
     */
    public function setPtSingle($pt_single)
    {
        $this->pt_single = $pt_single;
    }

    /**
     * @return mixed
     */
    public function getPtSinglePlural()
    {
        return $this->pt_single_plural;
    }

    /**
     * @param mixed $pt_single_plural
     */
    public function setPtSinglePlural($pt_single_plural)
    {
        $this->pt_single_plural = $pt_single_plural;
    }

    /**
     * @return mixed
     */
    public function getPtIcon()
    {
        return $this->pt_icon;
    }

    /**
     * @param mixed $pt_icon
     */
    public function setPtIcon($pt_icon)
    {
        $this->pt_icon = $pt_icon;
    }


}

class customizer
{

    public $theme_title = '';
    public $theme_name = '';
    public $theme_link = '';

    function __construct($themename, $themelink)
    {
        $this->theme_title = $themename;
        $this->theme_name = strtolower($themename);
        $this->theme_link = strtolower($themelink);
        add_action('customize_register', array($this, 'customizations'));
    }


    // Create custom settings
    function customizations($wp_customize)
    {
        //Remove the Color Section
        function remove_sections($wp_customize)
        {
            $wp_customize->remove_section("colors");
        }

        function add_panel($wp_customize)
        {
            $customizer = new customizer('Stalhouderij Nieuw-Moscou', 'https://stalhouderijnieuwmoscou.nl');
            $wp_customize->add_panel('panel_id', array(
                'priority' => 2,
                'capability' => 'edit_theme_options',
                'theme_supports' => '',
                'title' => $customizer->theme_title,
                'description' => $customizer->theme_title . 'Configuration.',
            ));
        }

        function add_header($wp_customize)
        {
            $section = 'Header';
            $section_desc = 'Hier kan je de header "aanpasingen" geven.';


            // Main code
            $wp_customize->add_section($section, array(
                'title' => $section,
                'priority' => 2,
                'description' => $section_desc,
                'panel' => 'panel_id'
            ));
            function create_control($wp_customize, $sort, $section, $name, $label, $desc, $type, $default)
            {
                if ($type == '') {
                    $type = 'text';
                }
                $wp_customize->add_setting($name, array(
                    'default' => '' . $default,
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                ));
                if ($sort == 0) {
                    // Add the control
                    $wp_customize->add_control($name, array(
                        'label' => $label,
                        'section' => $section,
                        'settings' => $name,
                        'description' => $desc,
                        'type' => $type,
                        'priority' => 0
                    ));
                } elseif ($sort == 1) {
                    $wp_customize->add_control(
                        new WP_Customize_Color_Control(
                            $wp_customize,
                            $name,
                            array(
                                'label' => $label,
                                'section' => $section,
                                'settings' => $name,
                                'description' => $desc,
                                'priority' => 0
                            )));
                }
            }

            //


            create_control($wp_customize, 0, $section, 'header_text', 'Header vraag tekst', '', '', '');
            create_control($wp_customize, 0, $section, 'header_phone', 'Header vraag telefoonnummer', '', '', '');
        }
        function add_icons($wp_customize)
        {
            $section = 'Icoontjes';
            $section_desc = 'Hier kan je de icoontjes "aanpasingen" geven.';


            // Main code
            $wp_customize->add_section($section, array(
                'title' => $section,
                'priority' => 2,
                'description' => $section_desc,
                'panel' => 'panel_id'
            ));
            function create_control_1($wp_customize, $sort, $section, $name, $label, $desc, $type, $default)
            {
                if ($type == '') {
                    $type = 'text';
                }
                $wp_customize->add_setting($name, array(
                    'default' => '' . $default,
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                ));
                if ($sort == 0) {
                    // Add the control
                    $wp_customize->add_control($name, array(
                        'label' => $label,
                        'section' => $section,
                        'settings' => $name,
                        'description' => $desc,
                        'type' => $type,
                        'priority' => 0
                    ));
                } elseif ($sort == 1) {
                    $wp_customize->add_control(
                        new WP_Customize_Color_Control(
                            $wp_customize,
                            $name,
                            array(
                                'label' => $label,
                                'section' => $section,
                                'settings' => $name,
                                'description' => $desc,
                                'priority' => 0
                            )));
                }
            }

            //


            create_control_1($wp_customize, 0, $section, 'icon_1', 'Fontawesome Icoon [1]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_text_1', 'Icoon text [1]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_url_1', 'Link [1]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_2', 'Fontawesome Icoon [2]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_text_2', 'Icoon text [2]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_url_2', 'Link [2]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_3', 'Fontawesome Icoon [3]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_text_3', 'Icoon text [3]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_url_3', 'Link [3]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_4', 'Fontawesome Icoon [4]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_text_4', 'Icoon text [4]', '', '', '');
            create_control_1($wp_customize, 0, $section, 'icon_url_4', 'Link [4]', '', '', '');

        }
        function add_footer($wp_customize)
        {
            $section = 'Footer';
            $section_desc = 'Hier kan je de footer "aanpasingen" geven.';


            // Main code
            $wp_customize->add_section($section, array(
                'title' => $section,
                'priority' => 2,
                'description' => $section_desc,
                'panel' => 'panel_id'
            ));
            function create_control_2($wp_customize, $sort, $section, $name, $label, $desc, $type, $default)
            {
                if ($type == '') {
                    $type = 'text';
                }
                $wp_customize->add_setting($name, array(
                    'default' => '' . $default,
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                ));
                if ($sort == 0) {
                    // Add the control
                    $wp_customize->add_control($name, array(
                        'label' => $label,
                        'section' => $section,
                        'settings' => $name,
                        'description' => $desc,
                        'type' => $type,
                        'priority' => 0
                    ));
                } elseif ($sort == 1) {
                    $wp_customize->add_control(
                        new WP_Customize_Color_Control(
                            $wp_customize,
                            $name,
                            array(
                                'label' => $label,
                                'section' => $section,
                                'settings' => $name,
                                'description' => $desc,
                                'priority' => 0
                            )));
                }
            }

            //


            create_control_2($wp_customize, 0, $section, 'footer_copyright', 'Footer copyright', '', '', '');
        }


        remove_sections($wp_customize);
        add_panel($wp_customize);
        add_header($wp_customize);
        add_icons($wp_customize);
        add_footer($wp_customize);

    }
}

?>


