<?php get_header(); ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
						<?php get_sidebar( 'shop' ) ?>
                    </div>
                </div>
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ): the_post(); ?>
                        <div class="col-sm-9">
                            <div class="blog-post-area">

                                <div class="single-blog-post">

                                    <h3><?php the_title(); ?></h3>
                                    <div class="post-meta">
                                        <ul>
                                            <li><i class="fa fa-user"></i> <?php echo get_the_author(); ?></li>
                                            <li><i class="fa fa-clock-o"></i> <?php echo get_the_date( 'h:i' ); ?></li>
                                            <li><i class="fa fa-calendar"></i> <?php echo get_the_date( 'M j, Y' ); ?>
                                            </li>
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
                                    <p>
										<?php the_content(); ?></p>
                                    <br>
                                    <div class="pager-area">
                                        <ul class="pager pull-right">
                                            <li><?php previous_post_link( '%link', 'PRE', true ); ?></li>
                                            <li><?php next_post_link( '%link', 'NEXT', true ); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!--/blog-post-area-->

                            <div class="rating-area">
                                <ul class="ratings">
                                    <li class="rate-this">Rate this item:</li>
                                    <li>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </li>
                                    <li class="color">(6 votes)</li>
                                </ul>
								<?php $tag_list = get_the_tag_list( '<li>', '</li><li>', '</li>' ); ?>
								<?php if ( isset( $tag_list ) ): ?>
                                    <ul class="tag">
                                        <li>TAGS:</li>
										<?php echo $tag_list; ?>
                                    </ul>
								<?php endif; ?>
                            </div><!--/rating-area-->
							<?php get_template_part( 'templates/tpl', 'share' ); ?>
                        </div>
					<?php endwhile; ?>
				<?php endif; ?>
            </div>
        </div>
    </section>

<?php get_footer(); ?>