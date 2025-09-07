<?php get_header(); ?>

<div class="container-custom py-8">
    <?php \Educato\Theme::breadcrumb(); ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main content -->
        <main class="lg:col-span-2">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <?php printf(__('Résultats de recherche pour : %s', 'educato'), '<span class="text-primary-600">' . get_search_query() . '</span>'); ?>
                </h1>
                <p class="text-gray-600">
                    <?php
                    global $wp_query;
                    printf(_n('%d résultat trouvé', '%d résultats trouvés', $wp_query->found_posts, 'educato'), $wp_query->found_posts);
                    ?>
                </p>
            </header>
            
            <?php if (have_posts()): ?>
                <div class="space-y-6">
                    <?php while (have_posts()): the_post(); ?>
                        <article class="card p-6 hover:shadow-lg transition-shadow duration-300">
                            <header class="mb-4">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                    <?php $categories = get_the_category(); ?>
                                    <?php if ($categories): ?>
                                    <span class="mx-2">•</span>
                                    <span class="text-primary-600"><?php echo esc_html($categories[0]->name); ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <h2 class="text-xl font-semibold mb-3">
                                    <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-primary-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                            </header>
                            
                            <div class="prose prose-gray max-w-none mb-4">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <footer>
                                <a href="<?php the_permalink(); ?>" class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                                    <?php _e('Lire la suite', 'educato'); ?> →
                                </a>
                            </footer>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <?php \Educato\Theme::pagination(); ?>
                
            <?php else: ?>
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2"><?php _e('Aucun résultat trouvé', 'educato'); ?></h2>
                    <p class="text-gray-600 mb-6"><?php _e('Essayez avec des mots-clés différents ou parcourez nos catégories.', 'educato'); ?></p>
                    
                    <!-- Search form -->
                    <div class="max-w-md mx-auto">
                        <?php get_search_form(); ?>
                    </div>
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

<?php get_footer(); ?>