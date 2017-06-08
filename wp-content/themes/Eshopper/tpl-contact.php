<?php
/*
	Template name: Contact
 */
?>

<?php get_header() ?>

<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
			<?php $map = get_field( 'map' ); ?>
			<?php if ( isset( $map ) ): ?>
                <div class="col-sm-12">
                    <h2 class="title text-center">Contact <strong>Us</strong></h2>

                    <div id="gmap" class="contact-map" data-lat="<?php echo $map['lat']; ?>"
                         data-lng="<?php echo $map['lng']; ?>">
                    </div>
                </div>
			<?php endif; ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
				<?php $form_id = get_field( 'contact_form' ); ?>
				<?php if ( isset( $form_id ) ) : ?>
                    <div class="contact-form">
                        <h2 class="title text-center">Get In Touch</h2>
                        <div class="status alert alert-success" style="display: none"></div>
						<?php echo do_shortcode( "[contact-form-7 id=$form_id title='Contact form 1']" ); ?>
                    </div>
				<?php endif; ?>
            </div>
            <div class="col-sm-4">
                <div class="contact-info">
                    <h2 class="title text-center">Contact Info</h2>
                    <address>
						<?php $company_name = get_field( 'company_name' ); ?>
						<?php if ( isset( $company_name ) ) : ?>
                            <p>Company name: <?php echo $company_name ?></p>
						<?php endif; ?>
						<?php $address = get_field( 'address' ); ?>
						<?php if ( isset( $address ) ) : ?>
                            <p>Address: <?php echo $address ?></p>
						<?php endif; ?>
						<?php $mobile = get_field( 'mobile' ); ?>
						<?php if ( isset( $mobile ) ) : ?>
                            <p>Mobile: <?php echo $mobile ?></p>
						<?php endif; ?>
						<?php $fax = get_field( 'fax' ); ?>
						<?php if ( isset( $fax ) ) : ?>
                            <p>Fax: <?php echo $fax ?></p>
						<?php endif; ?>
						<?php $email = get_field( 'email' ); ?>
						<?php if ( isset( $email ) ) : ?>
                            <p>Email: <?php echo $email ?></p>
						<?php endif; ?>
                    </address>
                    <div class="social-networks">
                        <h2 class="title text-center">Social Networking</h2>
                        <ul>
							<?php $facebook = get_field( 'facebook' ); ?>
							<?php if ( isset( $company_name ) ) : ?>
                                <li>
                                    <a href="<?php echo $facebook ?>"><i class="fa fa-facebook"></i></a>
                                </li>
							<?php endif; ?>
							<?php $twitter = get_field( 'twitter' ); ?>
							<?php if ( isset( $company_name ) ) : ?>
                                <li>
                                    <a href="<?php echo $twitter ?>"><i class="fa fa-twitter"></i></a>
                                </li>
							<?php endif; ?>
							<?php $google = get_field( 'google_plus' ); ?>
							<?php if ( isset( $company_name ) ) : ?>
                                <li>
                                    <a href="<?php echo $google ?>"><i class="fa fa-google-plus"></i></a>
                                </li>
							<?php endif; ?>
							<?php $youtube = get_field( 'youtube' ); ?>
							<?php if ( isset( $company_name ) ) : ?>
                                <li>
                                    <a href="<?php echo $youtube ?>"><i class="fa fa-youtube"></i></a>
                                </li>
							<?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--/#contact-page-->

<?php get_footer() ?>
