<?php get_header(); ?>
    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>
						<?php if ( have_rows( 'slides' ) ): ?>
                            <div class="carousel-inner">
								<?php $counter = 0; ?>
								<?php while ( have_rows( 'slides' ) ): the_row(); ?>
                                    <div class="item <?php if ( $counter < 1 ) {
										print 'active';
									} ?>">
										<?php $counter += 1; ?>
										<?php $slide = get_sub_field( 'slide' ); ?>
                                        <div class="col-sm-6">
                                            <h1><?php echo $slide->post_title; ?></h1>
                                            <h2><?php the_field( 'feature_title', $slide->ID ); ?></h2>
                                            <p><?php the_field( 'description', $slide->ID ); ?></p>
                                            <a href="<?php the_field( 'button', $slide->ID ); ?>">
                                                <button type="button"
                                                        class="btn btn-default get"><?php the_field( 'button_text', $slide->ID ); ?>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <img src="<?php the_field( 'first_image', $slide->ID ); ?>"
                                                 class="girl img-responsive" alt=""/>
                                            <img src="<?php the_field( 'second_image', $slide->ID ); ?>"
                                                 class="pricing" alt=""/>
                                        </div>
                                    </div>
								<?php endwhile; ?>
                            </div>
						<?php endif; ?>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </section><!--/slider-->

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
                        <h2 class="title text-center">Features Items</h2>
						<?php
						$args = array(
							'post_type'      => 'product',
							'posts_per_page' => 6,
							'orderby'        => 'rand'
						);
						$loop = new WP_Query( $args );
						if ( $loop->have_posts() ) {
							while ( $loop->have_posts() ) : $loop->the_post();
								wc_get_template_part( 'content', 'product' );
							endwhile;
						} else {
							echo __( 'No products found' );
						}
						wp_reset_postdata();
						?>

                    </div><!--features_items-->

                    <div class="category-tab"><!--category-tab-->
                        <div class="col-sm-12">
							<?php $prod_cat_slugs = array(); ?>
							<?php $categories = get_field( 'home_categories' ); ?>
							<?php if ( ! empty( $categories ) ): ?>
								<?php $counter = 0; ?>
                                <ul class="nav nav-tabs">
									<?php foreach ( $categories as $category ): ?>
										<?php $term_obj = get_term( $category ); ?>
										<?php $prod_cat_slugs[] = $term_obj->slug; ?>
                                        <li <?php if ( $counter < 1 )
											echo 'class="active"' ?>>
                                            <a href="#<?php echo $term_obj->slug; ?>"
                                               data-toggle="tab"><?php echo $term_obj->name; ?></a>
                                        </li>
										<?php $counter ++; ?>
									<?php endforeach; ?>
                                </ul>
							<?php endif; ?>
                        </div>
						<?php if ( ! empty( $prod_cat_slugs ) ) : ?>
                            <div class="tab-content">
								<?php $counter = 0 ?>
								<?php foreach ( $prod_cat_slugs as $slug ): ?>
                                    <div class="tab-pane fade<?php if ( $counter < 1 ) {
										echo ' active in';
									} ?>"
                                         id="<?php echo $slug; ?>">
										<?php $query = new WP_Query( array(
											'post_type'      => 'product',
											'posts_per_page' => 4,
											'orderby'        => 'rand',
											'tax_query'      => array(
												array(
													'taxonomy' => 'product_cat',
													'field'    => 'slug',
													'terms'    => $slug,
												),
											)
										) ); ?>
										<?php if ( $query->have_posts() ): ?>
											<?php while ( $query->have_posts() ): $query->the_post(); ?>
												<?php $product = new WC_Product( get_the_ID() ); ?>
                                                <div class="col-sm-3">
                                                    <div class="product-image-wrapper">
                                                        <div class="single-products">
                                                            <div class="productinfo text-center">
                                                                <img src="<?php bloginfo( 'template_url' ); ?>/images/home/gallery1.jpg"
                                                                     alt=""/>
                                                                <h2><?php echo $product->get_price_html(); ?></h2>
                                                                <p><?php echo $product->get_title(); ?></p>
                                                                <a href="<?php echo do_shortcode( '[add_to_cart_url id=' . get_the_id() . ']' ); ?>"
                                                                   class="btn btn-default add-to-cart"><i
                                                                            class="fa fa-shopping-cart"></i>Add to cart</a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
											<?php endwhile; ?>
										<?php endif; ?>
										<?php $counter ++; ?>
										<?php wp_reset_postdata(); ?>

                                    </div>
								<?php endforeach; ?>
                            </div>
						<?php endif; ?>
                    </div><!--/category-tab-->
					<?php if ( have_rows( 'recommended_products' ) ): ?>
						<?php $counter = 0; ?>
                        <div class="recommended_items"><!--recommended_items-->
                            <h2 class="title text-center">recommended items</h2>

                            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
									<?php while ( have_rows( 'recommended_products' ) ):
										$p_ids = array();
										$recommended_products = array();
										the_row();
										$p_ids[] = ( get_sub_field( 'recommended_product_1' ) ) ? get_sub_field( 'recommended_product_1' ) : null;
										$p_ids[] = ( get_sub_field( 'recommended_product_2' ) ) ? get_sub_field( 'recommended_product_2' ) : null;
										$p_ids[] = ( get_sub_field( 'recommended_product_3' ) ) ? get_sub_field( 'recommended_product_3' ) : null;
										foreach ( $p_ids as $id ) {
											if ( $id != null ) {
												$recommended_products[ $id ] = new WC_Product( $id );
											}

										}
									     ?>
                                        <div class="item<?php echo ( $counter < 1 ) ? ' active' : ''; ?>">
											<?php foreach ( $recommended_products as $p_id => $recommended ): ?>
                                                <div class="col-sm-4">
                                                    <div class="product-image-wrapper">
                                                        <div class="single-products">
                                                            <div class="productinfo text-center">
                                                                <img src="<?php bloginfo( 'template_url' ); ?>/images/home/recommend3.jpg"
                                                                     alt=""/>
                                                                <h2><?php echo $recommended->get_price_html(); ?></h2>
                                                                <p><?php echo $recommended->get_title(); ?></p>
                                                                <a href="<?php echo do_shortcode( '[add_to_cart_url id=' . $p_id . ']' ); ?>"
                                                                   class="btn btn-default add-to-cart"><i
                                                                            class="fa fa-shopping-cart"></i>Add to cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
											<?php endforeach; ?>
                                        </div>
										<?php $counter ++; ?>
									<?php endwhile; ?>
                                </div>
                                <a class="left recommended-item-control" href="#recommended-item-carousel"
                                   data-slide="prev">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                                <a class="right recommended-item-control" href="#recommended-item-carousel"
                                   data-slide="next">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div><!--/recommended_items-->
					<?php endif; ?>

                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>