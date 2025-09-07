</main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')): ?>
        <div class="py-12">
            <div class="container-custom">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <?php if (is_active_sidebar("footer-{$i}")): ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar("footer-{$i}"); ?>
                        </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Copyright -->
        <div class="border-t border-gray-800 py-6">
            <div class="container-custom">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('Tous droits réservés.', 'educato'); ?></p>
                    
                    <?php if (has_nav_menu('footer')): ?>
                    <nav class="mt-4 md:mt-0">
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'footer',
                            'container' => false,
                            'menu_class' => 'flex space-x-6',
                            'depth' => 1
                        ]);
                        ?>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>