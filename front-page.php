<?php get_header(); ?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-600 to-primary-800 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container-custom py-20 lg:py-32">
        <div class="max-w-3xl">
            <h1 class="text-4xl lg:text-6xl font-bold mb-6 animate-fade-in-up">
                <?php bloginfo('name'); ?>
            </h1>
            <p class="text-xl lg:text-2xl text-primary-100 mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                <?php bloginfo('description'); ?>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up" style="animation-delay: 0.4s;">
                <a href="#content" class="btn btn-secondary">
                    <?php _e('Découvrir', 'educato'); ?>
                </a>
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn bg-white/10 text-white hover:bg-white/20 border border-white/20">
                    <?php _e('Actualités', 'educato'); ?>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Decorative elements -->
    <div class="absolute top-0 right-0 w-1/3 h-full opacity-10">
        <svg viewBox="0 0 400 400" class="w-full h-full">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>
</section>

<!-- Main Content -->
<div id="content" class="container-custom py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Content Area -->
        <main class="lg:col-span-2">
            <?php if (have_posts()): ?>
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2"><?php _e('Dernières actualités', 'educato'); ?></h2>
                    <p class="text-gray-600"><?php _e('Restez informé des dernières nouvelles et événements', 'educato'); ?></p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php 
                    $post_count = 0;
                    while (have_posts() && $post_count < 4): 
                        the_post(); 
                        $post_count++;
                    ?>
                        <article class="card group hover:shadow-lg transition-shadow duration-300">
                            <?php if (has_post_thumbnail()): ?>
                            <div class="aspect-video overflow-hidden">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('card', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                                </a>
                            </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                    <?php $categories = get_the_category(); ?>
                                    <?php if ($categories): ?>
                                    <span class="mx-2">•</span>
                                    <span class="text-primary-600"><?php echo esc_html($categories[0]->name); ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="text-lg font-semibold mb-3">
                                    <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-primary-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                
                                <p class="text-gray-600 text-sm line-clamp-3">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <div class="text-center mt-8">
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-primary">
                        <?php _e('Voir toutes les actualités', 'educato'); ?>
                    </a>
                </div>
                
            <?php else: ?>
                <div class="text-center py-12">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2"><?php _e('Aucun contenu disponible', 'educato'); ?></h2>
                    <p class="text-gray-600"><?php _e('Le contenu sera bientôt disponible.', 'educato'); ?></p>
                </div>
            <?php endif; ?>
        </main>
        
        <!-- Sidebar -->
        <?php if (is_active_sidebar('sidebar-main')): ?>
        <aside class="lg:col-span-1">
            <div class="sticky top-32 space-y-6">
                <?php dynamic_sidebar('sidebar-main'); ?>
            </div>
        </aside>
        <?php endif; ?>
    </div>
</div>

<!-- Features Section -->
<section class="bg-gray-50 py-16">
    <div class="container-custom">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4"><?php _e('Nos Services', 'educato'); ?></h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto"><?php _e('Découvrez nos différents services et programmes éducatifs', 'educato'); ?></p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="card text-center p-8 hover:shadow-lg transition-shadow duration-300">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3"><?php _e('Formation', 'educato'); ?></h3>
                <p class="text-gray-600"><?php _e('Des programmes de formation de qualité adaptés aux besoins actuels', 'educato'); ?></p>
            </div>
            
            <!-- Feature 2 -->
            <div class="card text-center p-8 hover:shadow-lg transition-shadow duration-300">
                <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3"><?php _e('Recherche', 'educato'); ?></h3>
                <p class="text-gray-600"><?php _e('Innovation et recherche scientifique pour l\'avancement des connaissances', 'educato'); ?></p>
            </div>
            
            <!-- Feature 3 -->
            <div class="card text-center p-8 hover:shadow-lg transition-shadow duration-300">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3"><?php _e('Communauté', 'educato'); ?></h3>
                <p class="text-gray-600"><?php _e('Une communauté dynamique d\'étudiants, enseignants et chercheurs', 'educato'); ?></p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>