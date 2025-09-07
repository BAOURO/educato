<?php

namespace Educato;

class Customizer {
    
    public function __construct() {
        add_action('customize_register', [$this, 'register_customizer']);
    }
    
    public function register_customizer($wp_customize) {
        // Header section
        $wp_customize->add_section('educato_header', [
            'title' => __('En-tête', 'educato'),
            'priority' => 30
        ]);
        
        // Contact info
        $wp_customize->add_setting('educato_phone', [
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        
        $wp_customize->add_control('educato_phone', [
            'label' => __('Téléphone', 'educato'),
            'section' => 'educato_header',
            'type' => 'text'
        ]);
        
        $wp_customize->add_setting('educato_email', [
            'default' => '',
            'sanitize_callback' => 'sanitize_email'
        ]);
        
        $wp_customize->add_control('educato_email', [
            'label' => __('Email', 'educato'),
            'section' => 'educato_header',
            'type' => 'email'
        ]);
        
        // Social media section
        $wp_customize->add_section('educato_social', [
            'title' => __('Réseaux Sociaux', 'educato'),
            'priority' => 35
        ]);
        
        $social_networks = [
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'instagram' => 'Instagram',
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube'
        ];
        
        foreach ($social_networks as $network => $label) {
            $wp_customize->add_setting("educato_social_{$network}", [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw'
            ]);
            
            $wp_customize->add_control("educato_social_{$network}", [
                'label' => $label,
                'section' => 'educato_social',
                'type' => 'url'
            ]);
        }
    }
}