<?php get_header(); ?>

<div class="container-custom py-8">
    <?php \Educato\Theme::breadcrumb(); ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main content -->
        <main class="lg:col-span-2">
            <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                    <?php if (has_post_thumbnail()): ?>
                    <div class="aspect-video overflow-hidden">
                        <?php the_post_thumbnail('hero', ['class' => 'w-full h-full object-cover']); ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="p-8">
                        <header class="mb-6">
                            <div class="flex items-center text-sm text-gray-500 mb-4">
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
                                
                                <span class="mx-2">•</span>
                                <span><?php _e('Par', 'educato'); ?> <?php the_author(); ?></span>
                            </div>
                            
                            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">
                                <?php the_title(); ?>
                            </h1>
                        </header>
                        
                        <div class="prose prose-lg prose-gray max-w-none">
                            <?php the_content(); ?>
                        </div>
                        
                        <?php if (has_tag()): ?>
                        <footer class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm font-medium text-gray-700"><?php _e('Tags:', 'educato'); ?></span>
                                <?php
                                $tags = get_the_tags();
                                if ($tags) {
                                    foreach ($tags as $tag) {
                                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="inline-block px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full hover:bg-primary-100 hover:text-primary-700 transition-colors">' . esc_html($tag->name) . '</a>';
                                    }
                                }
                                ?>
                            </div>
                        </footer>
                        <?php endif; ?>
                    </div>
                </article>
                
                <!-- Author bio -->
                <div class="card mt-8 p-6">
                    <div class="flex items-start space-x-4">
                        <img src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'), ['size' => 80])); ?>" alt="<?php the_author(); ?>" class="w-20 h-20 rounded-full">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php _e('À propos de', 'educato'); ?> <?php the_author(); ?></h3>
                            <?php if (get_the_author_meta('description')): ?>
                            <p class="text-gray-600"><?php echo esc_html(get_the_author_meta('description')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Comments -->
                <?php if (comments_open() || get_comments_number()): ?>
                <div class="mt-8">
                    <?php comments_template(); ?>
                </div>
                <?php endif; ?>
                
            <?php endwhile; ?>
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