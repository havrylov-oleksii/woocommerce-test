<?php wp_footer() ?>
<footer id="footer"><!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
				<?php $company_name = get_field( 'company_name', 'option' ) ?>
				<?php $company_info = get_field( 'company_info', 'option' ) ?>
                <div class="col-sm-2">
                    <div class="companyinfo">
						<?php if ( isset( $company_name ) ) : ?>
                            <h2><?php echo $company_name ?></h2>
						<?php endif; ?>
						<?php if ( isset( $company_info ) ) : ?>
                            <p><?php echo $company_info ?></p>
						<?php endif; ?>
                    </div>
                </div>
				<?php if ( have_rows( 'videos', 'option' ) ) : ?>
                    <div class="col-sm-7">
						<?php while ( have_rows( 'videos', 'option' ) ) : the_row(); ?>
                            <div class="col-sm-3">
                                <div class="video-gallery text-center">
                                    <a href="#">
                                        <div class="iframe-img">
                                            <img src="<?php the_sub_field( 'preview' ) ?>"
                                                 alt=""/>
                                        </div>
                                        <div class="overlay-icon">
                                            <i class="fa fa-play-circle-o"></i>
                                        </div>
                                    </a>
                                    <p><?php the_sub_field( 'title' ) ?></p>
                                    <h2><?php the_sub_field( 'date' ) ?></h2>
                                </div>
                            </div>
						<?php endwhile; ?>
                    </div>
				<?php endif; ?>
				<?php $map_img = get_field( 'map_image', 'option' ) ?>
				<?php $address = get_field( 'address', 'option' ) ?>
                <div class="col-sm-3">
                    <div class="address">
						<?php if ( isset( $map_img ) ): ?>
                            <img src="<?php echo $map_img ?>" alt=""/>
						<?php endif; ?>
						<?php if ( isset( $address ) ): ?>
                            <p><?php echo $address ?></p>
						<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Service</h2>
						<?php wp_nav_menu( array(
							'theme_location'  => 'footer-services',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'nav nav-pills nav-stacked',
							'menu_id'         => '',
							'echo'            => true,
						) ); ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Quock Shop</h2>
						<?php wp_nav_menu( array(
							'theme_location'  => 'footer-quick',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'nav nav-pills nav-stacked',
							'menu_id'         => '',
							'echo'            => true,
						) ); ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Policies</h2>
						<?php wp_nav_menu( array(
							'theme_location'  => 'footer-policies',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'nav nav-pills nav-stacked',
							'menu_id'         => '',
							'echo'            => true,
						) ); ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
						<?php wp_nav_menu( array(
							'theme_location'  => 'footer-about',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'nav nav-pills nav-stacked',
							'menu_id'         => '',
							'echo'            => true,
						) ); ?>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
						<?php echo do_shortcode( '[newsletter_form form="1"]' ) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
                <p class="pull-right">Designed by <span><a target="_blank"
                                                           href="http://www.themeum.com">Themeum</a></span></p>
            </div>
        </div>
    </div>

</footer><!--/Footer-->


</body>
</html>