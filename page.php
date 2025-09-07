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
                            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">
                                <?php the_title(); ?>
                            </h1>
                        </header>
                        
                        <div class="prose prose-lg prose-gray max-w-none">
                            <?php the_content(); ?>
                        </div>
                        
                        <?php
                        wp_link_pages([
                            'before' => '<div class="page-links mt-8 p-4 bg-gray-50 rounded-lg"><span class="font-medium">' . __('Pages:', 'educato') . '</span>',
                            'after' => '</div>',
                            'link_before' => '<span class="inline-block px-3 py-1 ml-2 bg-white rounded border hover:bg-primary-50 hover:border-primary-200 transition-colors">',
                            'link_after' => '</span>'
                        ]);
                        ?>
                    </div>
                </article>
                
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