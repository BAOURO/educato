<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php if (!is_admin()): ?>
    <style>
        /* Isolation des styles pour éviter les conflits */
        .site {
            isolation: isolate;
        }
        
        /* Reset spécifique pour les icônes SVG */
        .site svg {
            display: inline-block;
            vertical-align: middle;
        }
        
        /* Assurer que les grilles ne s'appliquent que dans le site */
        .site .grid {
            display: grid;
        }
    </style>
    <?php endif; ?>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site min-h-screen flex flex-col">
    
    <!-- Header -->
    <header 
        x-data="header" 
        :class="{ 'bg-white/95 backdrop-blur-sm shadow-sm': isScrolled, 'bg-transparent': !isScrolled }"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    >
        <!-- Top bar -->
        <div class="bg-primary-600 text-white py-2 hidden lg:block">
            <div class="container-custom">
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center space-x-6">
                        <?php if (get_theme_mod('educato_phone')): ?>
                        <a href="tel:<?php echo esc_attr(get_theme_mod('educato_phone')); ?>" class="flex items-center hover:text-primary-200 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                            </svg>
                            <?php echo esc_html(get_theme_mod('educato_phone')); ?>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('educato_email')): ?>
                        <a href="mailto:<?php echo esc_attr(get_theme_mod('educato_email')); ?>" class="flex items-center hover:text-primary-200 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            <?php echo esc_html(get_theme_mod('educato_email')); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Social links -->
                    <div class="flex items-center space-x-3">
                        <?php
                        $social_networks = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
                        foreach ($social_networks as $network):
                            $url = get_theme_mod("educato_social_{$network}");
                            if ($url):
                        ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="hover:text-primary-200 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <?php echo $this->get_social_icon($network); ?>
                            </svg>
                        </a>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main header -->
        <div class="py-4">
            <div class="container-custom">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <?php if (has_custom_logo()): ?>
                            <?php the_custom_logo(); ?>
                        <?php else: ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-2xl font-bold text-gray-900 hover:text-primary-600 transition-colors">
                                <?php bloginfo('name'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <nav class="hidden lg:block">
                        <div class="menu-container">
                        <?php
                        if (has_nav_menu('primary')) {
                            wp_nav_menu([
                                'theme_location' => 'primary',
                                'container' => false,
                                'menu_class' => 'menu-horizontal',
                                'walker' => new \Educato\Walker_Nav_Menu(),
                                'fallback_cb' => false
                            ]);
                        } else {
                            echo '<div class="text-gray-500 text-sm">Menu non configuré. Allez dans Apparence > Menus pour créer un menu.</div>';
                        }
                        ?>
                        </div>
                    </nav>
                    
                    <!-- Search & Mobile menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Search button -->
                        <button 
                            x-data="searchModal"
                            @click="open()"
                            class="p-2 text-gray-600 hover:text-primary-600 transition-colors"
                            aria-label="<?php esc_attr_e('Rechercher', 'educato'); ?>"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        
                        <!-- Mobile menu button -->
                        <button 
                            x-data="mobileMenu"
                            @click="toggle()"
                            class="lg:hidden p-2 text-gray-600 hover:text-primary-600 transition-colors"
                            aria-label="<?php esc_attr_e('Menu', 'educato'); ?>"
                        >
                            <svg x-show="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <svg x-show="isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div 
            x-data="mobileMenu"
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="lg:hidden bg-white border-t border-gray-200"
        >
            <nav class="py-4">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'menu-mobile',
                    'walker' => new \Educato\Walker_Nav_Menu(),
                    'fallback_cb' => false
                ]);
                ?>
            </nav>
        </div>
    </header>
    
    <!-- Search Modal -->
    <div 
        x-data="searchModal"
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex min-h-screen items-start justify-center px-4 pt-20">
            <div 
                class="fixed inset-0 bg-black/50"
                @click="close()"
            ></div>
            
            <div 
                class="relative bg-white rounded-xl shadow-xl w-full max-w-lg p-6"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
            >
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900"><?php _e('Rechercher', 'educato'); ?></h3>
                    <button @click="close()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="relative">
                        <input 
                            x-ref="searchInput"
                            type="search" 
                            name="s" 
                            placeholder="<?php esc_attr_e('Que recherchez-vous ?', 'educato'); ?>"
                            class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            autocomplete="off"
                        >
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button type="submit" class="btn btn-primary w-full mt-4">
                        <?php _e('Rechercher', 'educato'); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <main id="main" class="flex-1 pt-24">