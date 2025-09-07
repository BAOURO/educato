<?php

namespace Educato;

class Assets {
    
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }
    
    public function enqueue_scripts() {
        // Main stylesheet
        wp_enqueue_style(
            'educato-style',
            get_template_directory_uri() . '/assets/dist/style.css',
            [],
            EDUCATO_THEME_VERSION
        );
        
        // Main JavaScript
        wp_enqueue_script(
            'educato-script',
            get_template_directory_uri() . '/assets/dist/main.js',
            [],
            EDUCATO_THEME_VERSION,
            true
        );
        
        // Google Fonts
        wp_enqueue_style(
            'educato-fonts',
            'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@300;400;700&display=swap',
            [],
            null
        );
        
        // Comment reply script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
        
        // Localize script
        wp_localize_script('educato-script', 'educato_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('educato_nonce')
        ]);
    }
    
    public function enqueue_admin_scripts() {
        wp_enqueue_style(
            'educato-admin',
            get_template_directory_uri() . '/assets/css/admin.css',
            [],
            EDUCATO_THEME_VERSION
        );
    }
}