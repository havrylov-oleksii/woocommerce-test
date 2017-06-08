<?php get_header(); ?>
<div class="container text-center">
    <div class="logo-404">
        <a href="index.html"><img src="<?php the_field( 'top_image', 'option' ); ?>" alt=""/></a>
    </div>
    <div class="content-404">
        <img src="<?php the_field( 'bottom_image', 'option' ); ?>" class="img-responsive" alt=""/>
        <h1><b>OPPS!</b> We Couldn’t Find this Page</h1>
        <p>Uh... So it looks like you brock something. The page you are looking for has up and Vanished.</p>
        <h2><a href="<?php echo home_url(); ?>">Bring me back Home</a></h2>
    </div>
</div>
<?php get_footer(); ?>
