<?php get_header(); ?>

<div class="container-custom py-16">
    <div class="text-center max-w-2xl mx-auto">
        <!-- 404 Illustration -->
        <div class="mb-8">
            <svg class="w-32 h-32 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        
        <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-6"><?php _e('Page non trouvée', 'educato'); ?></h2>
        <p class="text-lg text-gray-600 mb-8">
            <?php _e('Désolé, la page que vous recherchez n\'existe pas ou a été déplacée.', 'educato'); ?>
        </p>
        
        <!-- Search form -->
        <div class="max-w-md mx-auto mb-8">
            <?php get_search_form(); ?>
        </div>
        
        <!-- Action buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                <?php _e('Retour à l\'accueil', 'educato'); ?>
            </a>
            
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-secondary">
                <?php _e('Voir les actualités', 'educato'); ?>
            </a>
        </div>
        
        <!-- Popular categories -->
        <?php
        $categories = get_categories(['number' => 6, 'orderby' => 'count', 'order' => 'DESC']);
        if ($categories):
        ?>
        <div class="mt-12">
            <h3 class="text-lg font-semibold text-gray-900 mb-4"><?php _e('Catégories populaires', 'educato'); ?></h3>
            <div class="flex flex-wrap justify-center gap-2">
                <?php foreach ($categories as $category): ?>
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="inline-block px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-primary-100 hover:text-primary-700 transition-colors text-sm">
                    <?php echo esc_html($category->name); ?>
                    <span class="text-gray-500">(<?php echo $category->count; ?>)</span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>