<?php get_header(); ?>

<div class="container-custom section-spacing">
    <?php \Educato\Theme::breadcrumb(); ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <!-- Main content -->
        <main class="lg:col-span-2">
            <?php if (have_posts()): ?>
                <div class="content-spacing">
                    <?php while (have_posts()): the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                            <?php if (has_post_thumbnail()): ?>
                            <div class="aspect-video overflow-hidden rounded-t-2xl">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('card', ['class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300']); ?>
                                </a>
                            </div>
                            <?php endif; ?>
                            
                            <div class="p-5">
                                <header class="mb-4">
                                    <div class="flex items-center text-sm text-gray-500 mb-1">
                                        <time datetime="<?php echo get_the_date('c'); ?>" class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <?php echo get_the_date(); ?>
                                        </time>
                                        
                                        <?php $categories = get_the_category(); ?>
                                        <?php if ($categories): ?>
                                        <span class="mx-2">•</span>
                                        <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="text-primary-600 hover:text-primary-700">
                                            <?php echo esc_html($categories[0]->name); ?>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h2 class="text-xl font-semibold mb-2">
                                        <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-primary-600 transition-colors">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                </header>
                                
                                <div class="prose prose-gray max-w-none mb-3">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <footer class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <img src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'), ['size' => 32])); ?>" alt="<?php the_author(); ?>" class="w-8 h-8 rounded-full mr-2">
                                        <span><?php _e('Par', 'educato'); ?> <?php the_author(); ?></span>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">
                                        <?php _e('Lire la suite', 'educato'); ?>
                                    </a>
                                </footer>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <?php \Educato\Theme::pagination(); ?>
                
            <?php else: ?>
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2"><?php _e('Aucun article trouvé', 'educato'); ?></h2>
                    <p class="text-gray-600"><?php _e('Il semblerait qu\'aucun contenu ne soit disponible pour le moment.', 'educato'); ?></p>
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