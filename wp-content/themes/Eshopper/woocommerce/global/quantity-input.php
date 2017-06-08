<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.5.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if ($max_value && $min_value === $max_value) {
    ?>
    <div class="quantity hidden">
        <input type="hidden" class="qty" name="<?php echo esc_attr($input_name); ?>"
               value="<?php echo esc_attr($min_value); ?>"/>
    </div>
    <?php
} else {
    ?>
    <div class="cart_quantity_button">
        <a class="cart_quantity_up js-qty-changer"> + </a>
        <input type="text" class="input-text qty text cart_quantity_input"
               name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr($input_value); ?>"
               title="<?php echo esc_attr_x('Qty', 'Product quantity input tooltip', 'woocommerce') ?>"
               pattern="<?php echo esc_attr($pattern); ?>" inputmode="<?php echo esc_attr($inputmode); ?>"
               size="2"
               autocomplete="off"/>
        <a class="cart_quantity_down js-qty-changer"> - </a>
    </div>
    <?php
}
