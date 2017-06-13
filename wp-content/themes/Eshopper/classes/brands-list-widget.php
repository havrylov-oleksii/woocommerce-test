<?php

/**
 * Class which implements brands list widget
 */
class Brands_List extends WP_Widget
{
    /**
     * Basic widget constructor
     */
    public function __construct()
    {
        parent::__construct('brands_list',

            __('Brands list', 'shop'),

            array('description' => __('Outputs brands list', 'shop'),));
    }

    /**
     * Front-end display of the widget
     */
    public function widget($args, $instance)
    {
        $product_brands_list = get_terms(array(
            'taxonomy'   => 'brand',
            'hide_empty' => false,
        ));
        ?>
        <?php if (!empty($product_brands_list)): ?>
        <div class="brands_products">
            <h2>Brands</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                    <?php foreach ($product_brands_list as $brand) : ?>
                        <li><a href="<?php echo get_term_link($brand->term_id); ?>">
                                <span class="pull-right"><?php echo $brand->count; ?></span><?php echo $brand->name; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
        <?php

    }

    public function form($instance)
    {
    }
}

/**
 * Registering widget
 */
function brands_list_widget()
{
    register_widget('Brands_List');
}

add_action('widgets_init', 'brands_list_widget');
