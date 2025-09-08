<?php

namespace Educato;

class Navigation {
    
    public function __construct() {
        add_action('after_setup_theme', [$this, 'register_menus']);
        add_action('widgets_init', [$this, 'register_sidebars']);
    }
    
    public function register_menus() {
        register_nav_menus([
            'primary' => __('Menu Principal', 'educato'),
            'footer' => __('Menu Pied de page', 'educato')
        ]);
    }
    
    public function register_sidebars() {
        // Sidebar principal (non utilisé sur la home)
        register_sidebar([
            'name' => __('Sidebar Principal', 'educato'),
            'id' => 'sidebar-main',
            'description' => __('Sidebar principal du site', 'educato'),
            'before_widget' => '<div id="%1$s" class="widget mb-8 %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title text-lg font-semibold mb-4 text-gray-900">',
            'after_title' => '</h3>'
        ]);
        
        // Sidebar gauche pour la home page
        register_sidebar([
            'name' => __('Widget Gauche Accueil', 'educato'),
            'id' => 'sidebar-left-left',
            'description' => __('Widget affiché à gauche sur la page d\'accueil', 'educato'),
            'before_widget' => '<div id="%1$s" class="widget mb-6 %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title text-lg font-semibold mb-3 text-gray-900">',
            'after_title' => '</h3>'
        ]);
        
        // Footer widgets
        for ($i = 1; $i <= 4; $i++) {
            register_sidebar([
                'name' => sprintf(__('Footer %d', 'educato'), $i),
                'id' => "footer-{$i}",
                'description' => sprintf(__('Zone de widget pour le footer %d', 'educato'), $i),
                'before_widget' => '<div id="%1$s" class="widget mb-6 %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="widget-title text-base font-semibold mb-4 text-white">',
                'after_title' => '</h4>'
            ]);
        }
    }
}