<?php
/*
 Template name: Blog
 */
?>
<?php get_header() ?>


<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
					<?php get_sidebar( 'shop' ) ?>
                </div>
            </div>
			<?php
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args  = array(
				'paged'          => $paged,
				'posts_per_page' => 3,
				'post_type'      => 'post',
				'orderby'        => 'post_date',
				'order'          => 'DESC'
			);
			$posts = new WP_Query( $args );
			?>
            <div class="col-sm-9">
				<?php if ( $posts->have_posts() ) : ?>
                    <div class="blog-post-area">
                        <h2 class="title text-center"><?php _e( 'Latest from our blog', 'shop' ) ?></h2>
						<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
                            <div class="single-blog-post">
                                <h3><?php the_title(); ?></h3>
                                <div class="post-meta">
                                    <ul>
                                        <li><i class="fa fa-user"></i> <?php echo get_the_author(); ?></li>
                                        <li><i class="fa fa-clock-o"></i> <?php echo get_the_date( 'h:i' ); ?> </li>
                                        <li><i class="fa fa-calendar"></i> <?php echo get_the_date( 'M j, Y' ); ?> </li>
                                    </ul>
                                    <span>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-half-o"></i>
								</span>
                                </div>
                                <a href="">
                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
                                </a>
                                <p><?php the_content(); ?></p>
                                <a class="btn btn-primary" href="<?php echo get_the_permalink(); ?>">Read More</a>
                            </div>
						<?php endwhile; ?>

                        <div class="pagination-area">
                            <ul class="pagination">
								<?php
								$pagination = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
									'base'      => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
									'format'    => '',
									'add_args'  => false,
									'current'   => max( 1, get_query_var( 'paged' ) ),
									'total'     => $posts->max_num_pages,
									'prev_text' => '&laquo;',
									'next_text' => '&raquo;',
									'type'      => 'array',
									'end_size'  => 3,
									'mid_size'  => 3,
								) ) );
								foreach ( $pagination as $link ):
									?>
                                    <li><?php echo $link; ?></li>
								<?php endforeach; ?>
								<?php wp_reset_postdata(); ?>
                            </ul>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</section>


<?php get_footer() ?>
