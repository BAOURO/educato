<?php

namespace Educato;

class Walker_Nav_Menu extends \Walker_Nav_Menu {
    
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        
        // Mobile menu classes
        if (isset($args->mobile) && $args->mobile) {
            $class_names = 'block px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-primary-600 transition-colors';
            if ($depth > 0) {
                $class_names .= ' pl-8 text-sm';
            }
        } else {
            // Desktop menu classes
            $class_names = 'relative group';
        }
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . ' class="' . esc_attr($class_names) . '">';
        
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        
        // Link classes
        if (isset($args->mobile) && $args->mobile) {
            $link_class = 'block w-full text-left';
        } else {
            $link_class = 'block px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors font-medium';
        }
        
        $item_output = '<a class="' . $link_class . '"' . $attributes . '>';
        $item_output .= $title;
        
        // Add dropdown indicator for desktop
        if (!isset($args->mobile) && in_array('menu-item-has-children', $classes)) {
            $item_output .= '<svg class="w-4 h-4 ml-1 inline-block group-hover:rotate-180 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
        }
        
        $item_output .= '</a>';
        
        $output .= $item_output;
    }
    
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        
        if (isset($args->mobile) && $args->mobile) {
            $output .= "\n$indent<ul class=\"ml-4\">\n";
        } else {
            $output .= "\n$indent<ul class=\"absolute left-0 top-full mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50\">\n";
        }
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}