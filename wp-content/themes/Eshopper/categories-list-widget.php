<?php


/**
 * Class which implements categories list widget
 */
class Categories_List extends WP_Widget
{
    /**
     * Basic widget constructor
     */
    public function __construct()
    {
        parent::__construct(
            'categories_list',

            __('Categories list', 'shop'),

            array('description' => __('Outputs categories list', 'shop'),)
        );
    }

    /**
     * Front-end display of the widget
     */
    public function widget($args, $instance)
    {
        $product_cats_list = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        )); ?>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            <h2>Category</h2>
            <?php //echo double_term_tree('product', 'product_cat', 'brand');
            ?>
            <?php foreach ($product_cats_list as $cat): ?>
                <div class="panel panel-default">
                    <?php global $wpdb;
                    $brands_id_list = $wpdb->get_results("select brand_id from wp_categories_brands where cat_id=$cat->term_id", ARRAY_A);
                    $brands = array();
                    foreach ($brands_id_list as $brand) {
                        $brands[] = get_term($brand['brand_id']);
                    } ?>
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <?php $plus = (!empty($brands)) ? '<span class="badge pull-right"><i class="fa fa-plus"></i></span>' : ''; ?>
                            <a data-toggle="collapse" data-parent="#accordian" href="#<?php echo $cat->slug; ?>">
                                <?php echo $plus; ?>
                                <?php echo $cat->name; ?>
                            </a>
                        </h4>
                    </div>
                    <?php if (!empty($brands)): ?>
                        <div id="<?php echo $cat->slug; ?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul>
                                    <?php foreach ($brands as $brand) : ?>
                                        <li><a href=""><?php echo $brand->name; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
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
function categories_list_widget()
{
    register_widget('Categories_List');
}

add_action('widgets_init', 'categories_list_widget');
