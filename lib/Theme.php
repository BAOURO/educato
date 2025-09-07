<?php

namespace Educato;

class Theme {
    
    public function __construct() {
        $this->init();
    }
    
    private function init() {
        // Theme support
        add_action('after_setup_theme', [$this, 'theme_support']);
        
        // Clean up WordPress head
        add_action('init', [$this, 'head_cleanup']);
        
        // Custom excerpt
        add_filter('excerpt_more', [$this, 'excerpt_more']);
        
        // Page title
        add_filter('wp_title', [$this, 'page_title'], 10, 3);
        
        // Body classes
        add_filter('body_class', [$this, 'body_classes']);
        
        // Hide admin bar
        add_filter('show_admin_bar', '__return_false');
    }
    
    public function theme_support() {
        // Post thumbnails
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(400, 300, true);
        
        // Additional image sizes
        add_image_size('hero', 1200, 600, true);
        add_image_size('card', 400, 250, true);
        
        // HTML5 support
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script'
        ]);
        
        // Title tag
        add_theme_support('title-tag');
        
        // RSS feeds
        add_theme_support('automatic-feed-links');
        
        // Post formats
        add_theme_support('post-formats', [
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio'
        ]);
        
        // Custom background
        add_theme_support('custom-background', [
            'default-color' => 'ffffff'
        ]);
        
        // Custom logo
        add_theme_support('custom-logo', [
            'height' => 60,
            'width' => 200,
            'flex-height' => true,
            'flex-width' => true
        ]);
        
        // Responsive embeds
        add_theme_support('responsive-embeds');
        
        // Wide alignment
        add_theme_support('align-wide');
        
        // Editor styles
        add_theme_support('editor-styles');
        add_editor_style('assets/dist/style.css');
    }
    
    public function head_cleanup() {
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wp_shortlink_wp_head');
    }
    
    public function excerpt_more($more) {
        global $post;
        return '... <a class="text-primary-600 hover:text-primary-700 font-medium" href="' . get_permalink($post->ID) . '">' . __('Lire la suite', 'educato') . '</a>';
    }
    
    public function page_title($title, $sep, $seplocation) {
        global $page, $paged;
        
        if (is_feed()) return $title;
        
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description', 'display');
        
        if ('right' == $seplocation) {
            $title .= $site_name;
        } else {
            $title = $site_name . $title;
        }
        
        if ($site_description && (is_home() || is_front_page())) {
            $title .= " {$sep} {$site_description}";
        }
        
        if ($paged >= 2 || $page >= 2) {
            $title .= " {$sep} " . sprintf(__('Page %s', 'educato'), max($paged, $page));
        }
        
        return $title;
    }
    
    public function body_classes($classes) {
        // Add mobile-first class
        $classes[] = 'mobile-first';
        
        // Add page-specific classes
        if (is_front_page()) {
            $classes[] = 'is-front-page';
        }
        
        if (is_single()) {
            $classes[] = 'is-single-post';
        }
        
        return $classes;
    }
    
    public static function breadcrumb() {
        if (is_front_page()) return;
        
        echo '<nav class="breadcrumb py-4 text-sm" aria-label="Breadcrumb">';
        echo '<div class="container-custom">';
        echo '<ol class="flex items-center space-x-2 text-gray-600">';
        
        // Home link
        echo '<li><a href="' . home_url() . '" class="hover:text-primary-600 transition-colors">';
        echo '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>';
        echo '</a></li>';
        
        if (is_single()) {
            $category = get_the_category();
            if ($category) {
                echo '<li class="flex items-center">';
                echo '<svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
                echo '<a href="' . get_category_link($category[0]->cat_ID) . '" class="hover:text-primary-600 transition-colors">' . $category[0]->cat_name . '</a>';
                echo '</li>';
            }
        }
        
        // Current page
        echo '<li class="flex items-center">';
        echo '<svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
        echo '<span class="text-gray-900 font-medium">' . get_the_title() . '</span>';
        echo '</li>';
        
        echo '</ol>';
        echo '</div>';
        echo '</nav>';
    }
    
    public static function pagination() {
        global $wp_query;
        
        if ($wp_query->max_num_pages <= 1) return;
        
        echo '<nav class="pagination flex justify-center mt-12" aria-label="Pagination">';
        echo '<div class="flex items-center space-x-2">';
        
        $pagination = paginate_links([
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format' => '',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages,
            'prev_text' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>',
            'next_text' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>',
            'type' => 'array',
            'end_size' => 2,
            'mid_size' => 2
        ]);
        
        if ($pagination) {
            foreach ($pagination as $page) {
                if (strpos($page, 'current') !== false) {
                    echo '<span class="px-4 py-2 bg-primary-600 text-white rounded-lg font-medium">' . strip_tags($page) . '</span>';
                } else {
                    echo '<a class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">' . $page . '</a>';
                }
            }
        }
        
        echo '</div>';
        echo '</nav>';
    }
}