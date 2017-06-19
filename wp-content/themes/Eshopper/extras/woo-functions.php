<?php


//Removing default styles
//add_filter('woocommerce_enqueue_styles', '__return_empty_array');


/**
 * Adding sidebar
 */
function register_shop_sidebars() {
	register_sidebar( array(
		'name'         => 'Shop',
		'id'           => 'shop-sidebar',
		'description'  => 'Shop widgets',
		'before_title' => '<h1>',
		'after_title'  => '</h1>'
	) );
}

add_action( 'widgets_init', 'register_shop_sidebars' );

/**
 * Registering custom product taxonomy
 */
function register_brands_taxonomy() {
	$labels = array(
		'name'                       => _x( 'Brands', 'taxonomy general name' ),
		'singular_name'              => _x( 'Brand', 'taxonomy singular name' ),
		'all_items'                  => __( 'Brands' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Brand' ),
		'update_item'                => __( 'Update Brand' ),
		'add_new_item'               => __( 'Add New Brand' ),
		'new_item_name'              => __( 'New Brand Name' ),
		'separate_items_with_commas' => __( 'Separate brands with commas' ),
		'add_or_remove_items'        => __( 'Add or remove brands' ),
		'choose_from_most_used'      => __( 'Choose from the most used brands' ),
		'menu_name'                  => __( 'Brands' ),
	);
	register_taxonomy( 'brand', [ 'product' ], array(
		'labels'       => $labels,
		'hierarchical' => true,
	) );
}

add_action( 'init', 'register_brands_taxonomy' );

// Display 24 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 6;' ), 20 );

/**
 * Actions applied on shop template
 */
function archive_product_actions() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	remove_action( 'woocommerce_before_main_content', 'generate_website_data' );


//remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description');
//remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description');


//remove_action('woocommerce_before_shop_loop', 'wc_print_notices');
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


//remove_action('woocommerce_shop_loop', array('WC_Structured_Data', 'generate_product_data'));


//remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination');


//remove_action('woocommerce_no_products_found', 'wc_no_products_found');


//remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end');


	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );

	//before and after shop list content
	add_action( 'woocommerce_before_shop_loop', 'before_products_list_output', 10 );
	add_action( 'woocommerce_before_shop_loop', 'before_products_list_title', 20 );
	add_action( 'woocommerce_after_shop_loop', 'after_products_list_output' );
	add_action( 'woocommerce_before_single_product', 'before_products_list_output' );
	add_action( 'woocommerce_after_single_product', 'after_products_list_output' );
}

add_action( 'init', 'archive_product_actions' );


/**
 * Actions applied on single product template
 */
function content_product_actions() {
	add_action( 'woocommerce_after_shop_loop_item', 'after_list_item_output', 40 );


	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	add_action( 'woocommerce_before_shop_loop_item', 'content_product_start' );
	//add_action('woocommerce_after_shop_loop_item', 'content_product_end', 11);


	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	add_action( 'woocommerce_shop_loop_item_title', 'product_title' );

	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	add_action( 'sale_flag', 'woocommerce_show_product_loop_sale_flash', 10 );
}

add_action( 'init', 'content_product_actions' );


/**
 * Single product list item start
 */
function content_product_start() {
	echo '<div class="col-sm-4">
			<div class="product-image-wrapper">
				<div class="single-products">
				    <div class="productinfo text-center">';
}

/**
 * Single product list item content and markup
 */
function product_title() {
	echo '<p>' . get_the_title() . '</p>';
}

/**
 * After single product list item content
 */
function after_list_item_output() {
	global $product;
	?>
    </div>
    <div class="product-overlay">
        <div class="overlay-content">
            <h2><?php echo $product->get_price_html(); ?></h2>
            <p><?php echo $product->get_name(); ?></p>
			<?php get_template_part( 'woocommerce/loop/add-to-cart' ); ?>
        </div>
    </div>
	<?php if ( 604800 > ( time() - get_post_time( 'U', true, get_the_ID() ) ) ): ?>
        <img src="<?php bloginfo( 'template_url' ) ?>/assets/images/home/new.png" class="new" alt=""/>
	<?php else: ?>
		<?php do_action( 'sale_flag' ); ?>
	<?php endif; ?>
    </div>
    <div class="choose">
        <ul class="nav nav-pills nav-justified">
            <li>
				<?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
            </li>
            <li><?php echo do_shortcode( '[yith_compare_button]' ); ?>
            </li>
        </ul>
    </div>
    </div>
    </div>

	<?php
}


/**
 * Before product list output
 */
function before_products_list_output() { ?>
    <section>
    <div class="container">
    <div class="row">
    <div class="col-sm-3">
        <div class="left-sidebar">
			<?php get_sidebar( 'shop' ) ?>
        </div>
    </div>

    <div class="col-sm-9 padding-right">
    <div class="features_items"><!--features_items-->
	<?php
}

function before_products_list_title()
{
	?>
    <h2 class="title text-center">Features Items</h2>
    <div class="items-container">
	<?php
}


/**
 * After product list output
 */
function after_products_list_output() { ?>
    </div>
    </div><!--features_items-->
    </div>
    </div>
    </div>
    </section>
	<?php
}


/*************************CART****************************/


function before_cart_contents() {
	?>

    <section id="cart_items">
    <div class="container">
    <div class="breadcrumbs">
		<?php
		$args = array(
			'delimiter'   => '',
			'wrap_before' => '<ol class="breadcrumb">',
			'wrap_after'  => '</ol>',
			'before'      => '<li>',
			'after'       => '</li>'
		);
		?>
		<?php woocommerce_breadcrumb( $args ); ?>
    </div>

	<?php
}

add_action( 'woocommerce_before_cart', 'before_cart_contents' );
add_action( 'woocommerce_before_checkout_form', 'before_cart_contents' );

function after_cart_contents() {
	?>

    </div>
    </section>

	<?php
}

add_action( 'woocommerce_after_cart', 'after_cart_contents' );
add_action( 'woocommerce_after_checkout_form', 'after_cart_contents' );


/*************************CART****************************/


/************************CHECKOUT*************************/

add_filter( 'woocommerce_checkout_fields', 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
	$fields['billing']['billing_title']       = array(
		'label'       => __( 'Title', 'woocommerce' ),
		'placeholder' => _x( 'Title', 'placeholder', 'woocommerce' ),
		'required'    => false,
		'class'       => array( 'form-row-wide' ),
		'clear'       => true
	);
	$fields['billing']['billing_middle_name'] = array(
		'label'       => __( 'Middle Name', 'woocommerce' ),
		'placeholder' => _x( 'Middle Name', 'placeholder', 'woocommerce' ),
		'required'    => false,
		'class'       => array( 'form-row-wide' ),
		'clear'       => true
	);
	$fields['billing']['billing_fax']         = array(
		'label'       => __( 'Fax', 'woocommerce' ),
		'placeholder' => _x( 'Fax', 'placeholder', 'woocommerce' ),
		'required'    => false,
		'class'       => array( 'form-row-wide' ),
		'clear'       => true
	);
	$fields['billing']['billing_mobile']      = array(
		'label'       => __( 'Mobile Phone', 'woocommerce' ),
		'placeholder' => _x( 'Mobile Phone', 'placeholder', 'woocommerce' ),
		'required'    => false,
		'class'       => array( 'form-row-wide' ),
		'clear'       => true
	);
	foreach ( $fields['billing'] as $key => $field ) {
		if ( ! isset( $field['label'] ) ) {
			$fields['billing'][ $key ]['placeholder'] = 'Second Address';
		} else {
			$fields['billing'][ $key ]['placeholder'] = $fields['billing'][ $key ]['label'];
			$fields['billing'][ $key ]['class']       = array( 'form-row-wide' );
			unset( $fields['billing'][ $key ]['label'] );
		}
	}

	return $fields;
}

add_filter( 'woocommerce_checkout_fields', 'custom_override_account_fields' );

function custom_override_account_fields( $fields ) {
	$fields['account']['display_name'] = array(
		'placeholder' => _x( 'Display Name', 'placeholder', 'woocommerce' ),
		'required'    => false,
		'class'       => array( 'form-row-wide' ),
		'clear'       => true
	);
	$fields['account']['username']     = array(
		'placeholder' => _x( 'username', 'placeholder', 'woocommerce' ),
		'required'    => false,
		'class'       => array( 'form-row-wide' ),
		'clear'       => true
	);

	return $fields;
}

/**
 * Display field value on the order edit page
 */


function my_custom_checkout_field_display_admin_order_meta( $order ) {
	echo '<p><strong>' . __( 'Mobile Phone' ) . ':</strong> ' . get_post_meta( $order->id, '_billing_mobile', true ) . '</p>';
	echo '<p><strong>' . __( 'Title' ) . ':</strong> ' . get_post_meta( $order->id, '_billing_title', true ) . '</p>';
	echo '<p><strong>' . __( 'Middle Name' ) . ':</strong> ' . get_post_meta( $order->id, '_billing_middle_name', true ) . '</p>';
	echo '<p><strong>' . __( 'Fax' ) . ':</strong> ' . get_post_meta( $order->id, '_billing_fax', true ) . '</p>';
}

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

/**
 * Altering default fields
 */
function default_fields_view( $fields ) {
	$fields['order']['order_comments']['label'] = null;

	return $fields;
}

add_filter( 'woocommerce_checkout_fields', 'default_fields_view' );

/************************CHECKOUT*************************/


/**********************SINGLE PRODUCT***********************/


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

function similar_products() {
	?>
	<?php echo do_shortcode( "[wpcs id='181']" ); ?>

	<?php
}

//add_action( 'woocommerce_product_thumbnails', 'similar_products' );


function single_web_id() {
	?>
    <p>Web ID: <?php echo get_the_ID(); ?></p>
	<?php
}

add_action( 'woocommerce_single_product_summary', 'single_web_id', 7 );

function single_availability() {
	global $product;
	?>
    <p>
        <b>Availability:</b> <?php echo ( $product->get_stock_status() == 'instock' ) ? 'In Stock' : 'Not Available'; ?>
    </p>
	<?php
}

add_action( 'woocommerce_single_product_summary', 'single_availability', 31 );

function single_brand() {
	?>
    <p>
        <b>Brand:</b> <?php echo wp_get_post_terms( get_the_ID(), 'brand' )[0]->name; ?>
    </p>
	<?php
}

add_action( 'woocommerce_single_product_summary', 'single_brand', 31 );
/**********************SINGLE PRODUCT***********************/

/************************WISHLIST***************************/

function wishlist_wrapper_start() {
	?>
    <section id="wishlist">
    <div class="container">
    <div class="row">
	<?php
}

add_action( 'yith_wcwl_before_wishlist_form', 'wishlist_wrapper_start' );

function wishlist_wrapper_end() {
	?>
    </div>
    </div>
    </section>
	<?php
}

add_action( 'yith_wcwl_after_wishlist_form', 'wishlist_wrapper_end' );

/************************WISHLIST***************************/
