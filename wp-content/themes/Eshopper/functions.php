<?php
include_once 'extras/woo-functions.php';
include_once 'classes/categories-list-widget.php';
include_once 'classes/brands-list-widget.php';
include_once 'classes/BottomMenuWalker.php';

add_theme_support( 'woocommerce' );
//define( 'WOOCOMMERCE_USE_CSS', false );


/**
 * @param $sorted_menu_items
 * @param $args
 *
 * @return mixed
 * Setting class attr to dropdown for menu item ehich has children
 */
function menu_set_dropdown( $sorted_menu_items, $args ) {
	$last_top = 0;
	foreach ( $sorted_menu_items as $key => $obj ) {
		// is it a top lv item?
		if ( 0 == $obj->menu_item_parent ) {
			// set the key of the parent
			$last_top = $key;
		} else {
			$sorted_menu_items[ $last_top ]->classes['dropdown'] = 'dropdown';
		}
	}

	return $sorted_menu_items;
}

add_filter( 'wp_nav_menu_objects', 'menu_set_dropdown', 10, 2 );

/**
 * Adding menu locations
 */
function theme_register_nav_menu() {
	register_nav_menus( array(
		'header-middle'   => 'Middle Menu',
		'header-bottom'   => 'Bottom Menu',
		'footer-services' => 'Service',
		'footer-quick'    => 'Quick Shop',
		'footer-policies' => 'Policies',
		'footer-about'    => 'About Shopper',
	) );
}

add_action( 'after_setup_theme', 'theme_register_nav_menu' );

/**
 * Registering custom post types
 */
function create_eshop_post_types() {
	register_post_type( 'slide', array(
		'labels'      => array(
			'name'          => __( 'Slide', 'shop' ),
			'singular_name' => __( 'Slide', 'shop' ),
			'add_new'       => __( 'Add Slide', 'shop' ),
			'add_new_item'  => __( 'Add New Slide', 'shop' )
		),
		'show_ui'     => true,
		'public'      => false,
		'has_archive' => false,
		'supports'    => array( 'title' )
	) );
}

add_action( 'init', 'create_eshop_post_types' );


/**
 * Registering 404 options page
 */
add_action( 'acf/init', 'page_404_settings_init' );

function page_404_settings_init() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		$option_page = acf_add_options_page( array(
			'page_title' => __( '404 Settings', 'shop' ),
			'menu_title' => __( '404 Settings', 'shop' ),
			'menu_slug'  => 'error-settings',
		) );
	}
}

/**
 * Registering footer options page
 */
add_action( 'acf/init', 'footer_settings_init' );

function footer_settings_init() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		$option_page = acf_add_options_page( array(
			'page_title' => __( 'Footer Settings', 'shop' ),
			'menu_title' => __( 'Footer Settings', 'shop' ),
			'menu_slug'  => 'footer-settings',
		) );
	}
}

/**
 * Registering header options page
 */
add_action( 'acf/init', 'header_settings_init' );

function header_settings_init() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		$option_page = acf_add_options_page( array(
			'page_title' => __( 'Header Settings', 'shop' ),
			'menu_title' => __( 'Header Settings', 'shop' ),
			'menu_slug'  => 'header-settings',
		) );
	}
}


function session_init() {
	if ( ! session_id() ) {
		session_start();
	}
}

add_action( 'init', 'session_init' );


function session_destruct() {
	session_destroy();
}

add_action( 'wp_logout', 'session_destruct' );
add_action( 'wp_login', 'session_destruct' );


function before_product_update( $pid ) {
	if ( get_post_type( $pid ) == 'product' ) {
		global $wpdb;
		$first_term  = wp_get_post_terms( $pid, 'product_cat' )[0];
		$second_term = wp_get_post_terms( $pid, 'brand' )[0];
		if ( isset( $first_term ) && isset( $second_term ) ) {
			$_SESSION['terms'] = array( 'product_cat' => $first_term, 'brand' => $second_term );
		}
	}
}

add_action( 'pre_post_update', 'before_product_update' );


function categories_brands_data( $post_ID, $post, $update ) {
	if ( $update == true ) {
		global $wpdb;
		$first_term  = wp_get_post_terms( $post_ID, 'product_cat' )[0];
		$second_term = wp_get_post_terms( $post_ID, 'brand' )[0];
		$first_old   = $_SESSION['terms']['product_cat'];
		$second_old  = $_SESSION['terms']['brand'];
		if ( $first_old != $first_term || $second_old != $second_term ) {
			$query      = "SELECT COUNT(*) FROM wp_term_relationships JOIN (SELECT DISTINCT object_id FROM wp_term_relationships WHERE term_taxonomy_id=$first_old->term_id) as terms on terms.object_id=wp_term_relationships.object_id where term_taxonomy_id=$second_old->term_id";
			$prod_count = $wpdb->get_results( $query, ARRAY_N )[0][0];
			if ( $prod_count >= 1 ) {
				$wpdb->query( "update wp_categories_brands set products_count=$prod_count where cat_id=$first_old->term_id and brand_id=$second_old->term_id" );
			} else {
				$wpdb->query( "delete from wp_categories_brands where cat_id=$first_old->term_id and brand_id=$second_old->term_id" );
			}
		}
		$query        = "SELECT COUNT(*) FROM wp_term_relationships JOIN (SELECT DISTINCT object_id FROM wp_term_relationships WHERE term_taxonomy_id=$first_term->term_id) as terms on terms.object_id=wp_term_relationships.object_id where term_taxonomy_id=$second_term->term_id";
		$prod_count   = $wpdb->get_results( $query, ARRAY_N )[0][0];
		$relationship = $wpdb->get_results( "select products_count from wp_categories_brands where cat_id=$first_term->term_id and brand_id=$second_term->term_id", ARRAY_N );
		if ( empty( $relationship ) ) {
			$wpdb->query( "insert into wp_categories_brands set cat_id=$first_term->term_id, brand_id=$second_term->term_id, products_count='1'" );
		} else {
			$wpdb->query( "update wp_categories_brands set products_count=$prod_count where cat_id=$first_term->term_id and brand_id=$second_term->term_id" );
		}
	} else {
		return;
	}
}

add_action( 'save_post_product', 'categories_brands_data', 10, 3 );


function update_categories_brand_data( $pid ) {
	if ( get_post_type( $pid ) == 'product' ) {
		global $wpdb;
		$first_term  = wp_get_post_terms( $pid, 'product_cat' )[0];
		$second_term = wp_get_post_terms( $pid, 'brand' )[0];
		$query       = "SELECT COUNT(*) FROM wp_term_relationships JOIN (SELECT DISTINCT object_id FROM wp_term_relationships WHERE term_taxonomy_id=$first_term->term_id) as terms on terms.object_id=wp_term_relationships.object_id where term_taxonomy_id=$second_term->term_id";
		$prod_count  = (int) $wpdb->get_results( $query, ARRAY_N )[0][0] - 1;
		if ( $prod_count > 0 ) {
			$wpdb->query( "update wp_categories_brands set products_count=$prod_count where cat_id=$first_term->term_id and brand_id=$second_term->term_id" );
		} else {
			$wpdb->query( "delete from wp_categories_brands where cat_id=$first_term->term_id and brand_id=$second_term->term_id" );
		}
	}
}

add_action( 'before_delete_post', 'update_categories_brand_data', 10, 1 );


function double_term_tree(
	$post_types = array(
		'post',
		'page'
	), $first = 'category', $second = 'post_tag'
) {
	$query = new WP_Query( array(
		'numberposts'      => - 1,
		'suppress_filters' => true,
		'posts_per_page'   => - 1,
		'post_type'        => $post_types,
		'tax_query'        => array(
			'relation' => 'AND',
			array(
				'taxonomy' => $first,
				'field'    => 'id',
				'terms'    => get_terms( $first, array( 'fields' => 'ids' ) )
			),
			array(
				'taxonomy' => $second,
				'field'    => 'id',
				'terms'    => get_terms( $second, array( 'fields' => 'ids' ) )
			),
		),
	) );

	if ( empty( $query->posts ) ) {
		return;
	}

	$result_list = array();

	foreach ( $query->posts as $post ) {
		$first_terms  = wp_get_post_terms( $post->ID, $first );
		$second_terms = wp_get_post_terms( $post->ID, $second );


		foreach ( $first_terms as $f_term ) {
			if ( ! isset( $result_list[ $f_term->name ] ) ) {
				$result_list[ $f_term->name ] = array();
			}

			$result_list[ $f_term->name ] = array_merge( $result_list[ $f_term->name ], $second_terms );
		}
	}
	foreach ( $result_list as $k => $v ) {
		$result_list[ $k ] = $v;
		$brands            = $v;
		$plus              = ( ! empty( $v ) ) ? '<span class="badge pull-right"><i class="fa fa-plus"></i></span>' : ''; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordian"
                       href="#<?php echo strtolower( $k ); ?>"><?php echo $plus;
						echo $k; ?>
                    </a>
                </h4>
            </div>
			<?php if ( ! empty( $brands ) ): ?>
                <div id="<?php echo strtolower( $k ); ?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
							<?php foreach ( $brands as $brand ): ?>
                                <li><a><?php echo $brand->name; ?></a></li>
							<?php endforeach; ?>
                        </ul>
                    </div>
                </div>
			<?php endif; ?>
        </div>
		<?php

	}

	//return $output;
}

/**
 * Enqueue scripts and styles
 */
function register_shop_styles() {
	// Register styles
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '1.0', 'all' );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '1.0', 'all' );
	wp_register_style( 'prettyphoto', get_template_directory_uri() . '/assets/css/prettyPhoto.css', array(), '1.0', 'all' );
	wp_register_style( 'price-range', get_template_directory_uri() . '/assets/css/price-range.css', array(), '1.0', 'all' );
	wp_register_style( 'animate', get_template_directory_uri() . '/assets/css/animate.css', array(), '1.0', 'all' );
	wp_register_style( 'main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0', 'all' );
	wp_register_style( 'responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), '1.0', 'all' );


	// enqueue styles
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'prettyphoto' );
	wp_enqueue_style( 'price-range' );
	wp_enqueue_style( 'animate' );
	wp_enqueue_style( 'main' );
	wp_enqueue_style( 'responsive' );

	// enqueue scripts
	//wp_enqueue_script('newjquery', get_template_directory_uri() . '/assets/js/jquery.js', array(), '1.0', true);
	wp_enqueue_script( 'mainscript', get_template_directory_uri() . '/assets/js/main.js', array(), false, true );
	if ( is_page( 'contact' ) ) {
		wp_enqueue_script( 'maps', get_template_directory_uri() . '/assets/js/map.js', array(), false, true );
	}
	wp_enqueue_script( 'bootstrapjs', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), false, true );
	//wp_enqueue_script('contact', get_template_directory_uri() . '/assets/js/contact.js', array('newjquery'), false, true);
	//wp_enqueue_script('gmaps', get_template_directory_uri() . '/assets/js/gmaps.js', array('newjquery'), '1.0', true);
	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/assets/js/html5shiv.js', array(), false, true );
	wp_enqueue_script( 'prettyPhoto', get_template_directory_uri() . '/assets/js/jquery.prettyPhoto.js', array(), false, true );
	wp_enqueue_script( 'scrollup', get_template_directory_uri() . '/assets/js/jquery.scrollUp.min.js', array(), false, true );
	wp_enqueue_script( 'price-range', get_template_directory_uri() . '/assets/js/price-range.js', array(), false, true );
	wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCPENg6rZHoaxzRkyD7pFc-iP5-bzAx_bA', array(), '3', true );
}

add_action( 'wp_enqueue_scripts', 'register_shop_styles' );

function shop_acf_google_map_api( $api ) {
	$api['key'] = 'AIzaSyCPENg6rZHoaxzRkyD7pFc-iP5-bzAx_bA';

	return $api;
}

add_filter( 'acf/fields/google_map/api', 'shop_acf_google_map_api' );


/**
 * Ajax filter
 */
function filter_products() {
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 6,
	);

	if ( isset( $_POST['brand'] ) && isset( $_POST['productCat'] ) ) {
		$args['tax_query'] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $_POST['productCat']
			),
			array(
				'taxonomy' => 'brand',
				'field'    => 'slug',
				'terms'    => $_POST['brand']
			)
		);
	}
	if ( isset( $_POST['page'] ) ) {
		$args['offset'] = $_POST['page'] * 6;
	}

	$args['post_status'] = 'publish';
	$loop                = new WP_Query( $args );
	ob_start();
	if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post();
			wc_get_template_part( 'content', 'product' );
		endwhile;
		wp_reset_postdata();
	} else {
		echo __( 'No products found', 'shop' );
	}
	$html          = ob_get_clean();
	$max_num_pages = $loop->max_num_pages;
	$data          = array( 'html' => $html, 'max_num_pages' => $max_num_pages );
	wp_send_json( $data );
	wp_die();
}

add_action( 'wp_ajax_filterproducts', 'filter_products' );
add_action( 'wp_ajax_nopriv_filterproducts', 'filter_products' );


function ajax_data() {
	wp_localize_script( 'mainscript', 'ajaxReq', array(
		'url'     => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'zornsejcfs' ),
		'cartUrl' => wc_get_cart_url()
	) );
}

add_action( 'wp_enqueue_scripts', 'ajax_data', 99 );
