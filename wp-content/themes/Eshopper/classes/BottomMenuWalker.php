<?php

/**
 * Bottom menu output
 */
class BottomMenuWalker extends Walker_Nav_Menu
{

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        // build html
        if ($depth == 0) {
            $output .= '<ul class="sub-menu">';
        }
        if ($depth > 0) {
            $output .= '<ul>';
        }
    }


    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        if ($depth == 0) {
            $output .= "$indent</ul>\n";
        }
        if ($depth > 0) {
            $output .= '</ul>';
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query;
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="' . esc_attr($class_names) . '"';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . '>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $angle_down = (in_array('dropdown', $classes)) ? '<i class="fa fa-angle-down"></i>' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . $class_names . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $angle_down . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }
}