<?php

class customposttype {
	public $pt_prefix;
	public $pt_postname;
	public $pt_postname_slug;
	public $pt_single;
	public $pt_single_plural;
	public $pt_icon;

	public function __construct( $prefix, $postname, $single, $single_plural, $icon, $meta ) {

		$this->setPtPrefix( $prefix );
		$this->setPtPostname( $postname );
		$this->setPtSingle( $single );
		$this->setPtSinglePlural( $single_plural );
		$this->setPtIcon( $icon );
		$this->register_post_type();
		$this->register_shortcode();
		$this->register_metabox();

		add_action( 'admin_head', array( $this, '_remove_meta_boxes' ) );
	}


	/**
	 * @return mixed
	 */
	public function getPtPrefix() {
		return $this->pt_prefix;
	}

	/**
	 * @param mixed $pt_prefix
	 */
	public function setPtPrefix( $pt_prefix ) {
		$this->pt_prefix = $pt_prefix;
	}

	/**
	 * @return mixed
	 */
	public function getPtPostname() {
		return $this->pt_postname;
	}

	/**
	 * @param mixed $pt_postname
	 */
	public function setPtPostname( $pt_postname ) {
		$this->pt_postname      = $pt_postname;
		$this->pt_postname_slug = strtolower( ( $pt_postname ) );
	}

	/**
	 * @return mixed
	 */
	public function getPtPostnameSlug() {
		return $this->pt_postname_slug;
	}

	/**
	 * @return mixed
	 */
	public function getPtSingle() {
		return $this->pt_single;
	}

	/**
	 * @param mixed $pt_single
	 */
	public function setPtSingle( $pt_single ) {
		$this->pt_single = $pt_single;
	}

	/**
	 * @return mixed
	 */
	public function getPtSinglePlural() {
		return $this->pt_single_plural;
	}

	/**
	 * @param mixed $pt_single_plural
	 */
	public function setPtSinglePlural( $pt_single_plural ) {
		$this->pt_single_plural = $pt_single_plural;
	}

	/**
	 * @return mixed
	 */
	public function getPtIcon() {
		return $this->pt_icon;
	}

	/**
	 * @param mixed $pt_icon
	 */
	public function setPtIcon( $pt_icon ) {
		$this->pt_icon = $pt_icon;
	}

	/**
	 * Create the postype
	 */

	function _custom_pt() {

		register_post_type( $this->getPtPostnameSlug(),
			array(
				'labels'        => array(
					'name'               => __( $this->getPtPostname(), $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
					'singular_name'      => __( $this->getPtPostname(), $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
					'add_new'            => __( 'Nieuw ' . $this->getPtSingle(), $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
					'add_new_item'       => __( 'Voeg nieuw ' . $this->getPtSingle() . ' toe', $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
					'new_item'           => __( 'Nieuw ' . $this->getPtSingle(), $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
					'all_items'          => __( 'Alle ' . $this->getPtSinglePlural(), $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
					'search_items'       => __( 'Zoek ' . $this->getPtSingle(), $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
					'not_found'          => __( 'Geen ' . $this->getPtSinglePlural() . ' gevonden', $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
					'not_found_in_trash' => __( 'Geen ' . $this->getPtSinglePlural() . ' gevonden in prullenbak', $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
					'edit_item'          => __( $this->getPtSingle() . ' aanpassen', $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
					'view_item'          => __( $this->getPtSingle() . 'Item weergeven', $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
				),
				'description'   => __( 'Maak ' . $this->getPtPostnameSlug() . ' ' . $this->getPtSinglePlural(), $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
				'public'        => true,
				'has_archive'   => false, // "Archive" is loaded by shortcode
				'menu_position' => 5, // Below comments
				'supports'      => array(
					'title',
					'editor',
					'thumbnail',
					'excerpt',
					'comments'
				),
				'menu_icon'     => $this->getPtIcon(),
			)
		);
	}

	function _register_custom_taxonomies() {
		register_taxonomy( $this->getPtPostnameSlug() . '_cat', $this->getPtPostnameSlug(), array(
			"hierarchical"      => true,
			"label"             => __( 'Categorieën', $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
			"singular_label"    => __( 'Categorieën', $this->getPtPrefix() . '-' . $this->getPtPostnameSlug() ),
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $this->getPtPostnameSlug() . '_cat', 'with_front' => false ),
			'public'            => true,
			'show_ui'           => true,
			'show_tagcloud'     => false,
			'_builtin'          => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true
		) );
	}

	function register_post_type() {
		add_action( 'init', array( $this, '_custom_pt' ), 1 );
		add_action( 'init', array( $this, '_register_custom_taxonomies' ), 2 );
	}


	/**
	 * Create the shortcode
	 */

	function _add_shortcode( $attributes ) {

		$conf = shortcode_atts( array(
			'limit'   => '-1',
			'sortby'  => 'name',
			'columns' => '2',
			'order'   => 'ASC',
			'cat'     => '',
		), $attributes );


		if ( $conf['cat'] != '' ) {

			$args = array(
				'post_type'      => $this->getPtPostnameSlug(),
				'post_status'    => 'publish',
				'orderby'        => $conf['sortby'],
				'posts_per_page' => $conf['limit'],
				'order'          => $conf['order'],
				'tax_query'      => array(
					array(
						'taxonomy' => $this->getPtPostnameSlug() . '_cat',
						'field'    => 'name',
						'terms'    => $conf['cat'],
					),
				),
			);


		} else {

			$args = array(
				'post_type'      => $this->getPtPostnameSlug(),
				'post_status'    => 'publish',
				'orderby'        => $conf['sortby'],
				'posts_per_page' => $conf['limit'],
				'order'          => $conf['order'],
			);
		}

		$wp_query = new WP_Query( $args );


		$return = '<div id="" class="row">';

		if ( $wp_query->have_posts() ) {
			while ( $wp_query->have_posts() ) : $wp_query->the_post();

				$featured_img_url = get_the_post_thumbnail_url( 'full' );

				$return .= '<a class="col-lg-4 col-md-6 col-sm-12 pb-5" href="' . get_the_permalink() . '">';
				$return .= '<div   alt="Portfolio item:" class="position-relative h-100">';
				if ( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ) {
					$return .= '<img src="' . get_the_post_thumbnail_url( get_the_ID(), 'full' ) . '" style="width:100%; height:200px;object-fit:cover;"  class="position-relative"/>';
				} else {
					$return .= '<img src="' . get_template_directory_uri() . '/assets/media/placeholder.jpg" style="width:100%; height:200px;object-fit:cover;"  class="position-relative"/>';
				}
				$return .= "<div class='overlay position-absolute port_item ' style=''>";
				$return .= '<div class="container-fluid h-100">';
				$return .= '<div class="row justify-content-end align-items-end h-100">';
				$return .= '<h3 style="bottom:0;padding-right:10px;font-weight: bold" class="text-white">' . get_the_title() . '</h3>';
				$return .= "</div>";
				$return .= "</div>";
				$return .= "</div>";

				$return .= '</div>';
				$return .= '</a>';


			endwhile;


		} else {
			echo 'Niks gevonden';
		}

		$return .= '</div>';

		return $return;

	}

	function register_shortcode() {
		add_shortcode( $this->getPtPrefix() . '-' . $this->getPtPostnameSlug(), array( $this, '_add_shortcode' ) );
	}

	/**
	 * Custom Meta Box
	 */

	function _pt_person_page() {
		global $post;
		$custom        = get_post_custom( $post->ID );
		$personal_page = $custom["personal_page"][0];
		if ( checked( '1', $personal_page, false ) ) {
			$active = checked( '1', $personal_page, false );
			$text   = 'Aanzetten';
		} else {
			$active = '';
			$text   = 'Uitzetten';

		}
		?>
        <input name="personal_page" id='personal_page' type="checkbox" class="" value="1" <?php echo $active ?>/>
        <label for="personal_page">Schakel aparte pagina uit</label>
		<?php
	}

	function _pt_build_year() {
		global $post;
		$custom        = get_post_custom( $post->ID );
		$personal_page = $custom["build_year"][0];
		?>
        <input name="build_year" id='build_year' type="text" class="" value="<?php echo $personal_page ?>"/>

		<?php
	}

	function _pt_info() {
		global $post;
		$custom        = get_post_custom( $post->ID );
		$personal_page = $custom["tractor_info"][0];
		?>
        <textarea name="tractor_info" id='tractor_info' rows="10" class=""
                  title="Informatie"><?php echo $personal_page ?></textarea>

		<?php
	}

	function _add_metabox() {
		add_meta_box( 'pt_side_personal_page', 'Aparte pagina?', array(
			$this,
			'_pt_person_page'
		), $this->getPtPostnameSlug(), 'side', 'low' );
		add_meta_box( 'pt_normal_build_year', 'Bouw jaar?', array(
			$this,
			'_pt_build_year'
		), $this->getPtPostnameSlug(), 'normal', 'low' );
		add_meta_box( '_pt_info', 'Informatie', array(
			$this,
			'_pt_info'
		), $this->getPtPostnameSlug(), 'normal', 'low' );
	}

	function _save_meta_box() {
		global $post;
		if ( get_post_type( get_the_ID() ) == $this->getPtPostnameSlug() ) {

			update_post_meta( $post->ID, "personal_page", $_POST["personal_page"] );
			update_post_meta( $post->ID, "build_year", $_POST["build_year"] );
			update_post_meta( $post->ID, "tractor_info", $_POST["tractor_info"] );

		}
	}

	function _set_custom_edit_pt_columns( $columns ) {
		$columns_old = $columns;
		$columns     = array(
			"cb"                                              => "<input type='checkbox' />",
			"title"                                           => $this->getPtPostname() . " Titel",
			"taxonomy-" . $this->getPtPostnameSlug() . "_cat" => "Categorieen",
			"personal_page"                                   => "Aparte pagina",
		);


		return $columns;
	}

	function _custom_pt_column( $column, $post_id ) {
		switch ( $column ) {
			case 'personal_page' :
				if ( get_post_meta( $post_id, 'personal_page', true ) ) {
					echo 'Nee';
				} else {
					echo 'Ja';
				};
				break;

		}
	}

	function _single_page_pt( $content ) {
		$posttype = get_post_type();
		if ( $posttype === $this->getPtPostnameSlug() ) {
			if ( is_single() && ! empty( $GLOBALS['post'] ) ) {
				if ( $GLOBALS['post']->ID == get_the_ID() ) {
					$personal_page = get_post_meta( get_the_ID(), 'personal_page', true );
					if ( checked( '1', $personal_page, false ) ) {
						wp_safe_redirect( wp_get_referer() );
					}
				}
			}
		}

		return $content;
	}

	function register_metabox() {
		add_action( "admin_init", array( $this, "_add_metabox" ) );
		add_action( 'save_post', array( $this, '_save_meta_box' ) );
		add_filter( 'manage_' . $this->getPtPostnameSlug() . '_posts_columns', array(
			$this,
			'_set_custom_edit_pt_columns'
		) );
		add_action( 'manage_' . $this->getPtPostnameSlug() . '_posts_custom_column', array(
			$this,
			'_custom_pt_column'
		), 10, 2 );
		add_filter( 'the_content', array( $this, '_single_page_pt' ) );
	}


	function _remove_meta_boxes() {
		remove_meta_box( 'postexcerpt', $this->getPtPostnameSlug(), 'normal' );
		remove_meta_box( 'commentstatusdiv', $this->getPtPostnameSlug(), 'normal' );
		remove_meta_box( 'commentsdiv', $this->getPtPostnameSlug(), 'normal' );
		remove_meta_box( 'mymetabox_revslider_0', $this->getPtPostnameSlug(), 'normal' );
	}


}

?>