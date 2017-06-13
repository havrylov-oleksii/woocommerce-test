<?php

/**
 * Class which implements price range widget
 */
class Price_Range_Widget extends WP_Widget
{
    /**
     * Basic widget constructor
     */
    public function __construct()
    {
        parent::__construct(
            'price_widget',

            __('Price range', 'shop'),

            array('description' => __('Allows to view items in current price range', 'shop'),)
        );
    }

    /**
     * Front-end display of the widget
     */
    public function widget($args, $instance)
    {
        ?>
        <div class="price-range">
            <h2>Price Range</h2>
            <div class="well">
                <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
                       data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br/>
                <b>$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div>


        <?php

    }

    public function form($instance)
    {
    }
}

/**
 * Registering widget
 */
function price_range_widget()
{
    register_widget('Price_Range_Widget');
}

add_action('widgets_init', 'price_range_widget');
