<?php

/**
 * Class which implements ad widget
 */
class Ad_Widget extends WP_Widget
{
    /**
     * Basic widget constructor
     */
    public function __construct()
    {
        parent::__construct(
            'ad_widget',

            __('Ad Widget', 'shop'),

            array('description' => __('Ad block goes here', 'shop'),)
        );
    }

    /**
     * Front-end display of the widget
     */
    public function widget($args, $instance)
    {
        ?>
        <div class="shipping text-center"><!--shipping-->
            <img src="<?php bloginfo('template_url'); ?>/images/home/shipping.jpg" alt=""/>
        </div><!--/shipping-->

        <?php
    }

    public function form($instance)
    {
    }
}

/**
 * Registering widget
 */
function ad_widget()
{
    register_widget('Ad_Widget');
}

add_action('widgets_init', 'ad_widget');