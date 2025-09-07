<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area card p-8">
    <?php if (have_comments()): ?>
        <h2 class="comments-title text-2xl font-bold text-gray-900 mb-6">
            <?php
            $comments_number = get_comments_number();
            if ($comments_number == 1) {
                printf(_x('Un commentaire sur &ldquo;%s&rdquo;', 'comments title', 'educato'), get_the_title());
            } else {
                printf(
                    _nx(
                        '%1$s commentaire sur &ldquo;%2$s&rdquo;',
                        '%1$s commentaires sur &ldquo;%2$s&rdquo;',
                        $comments_number,
                        'comments title',
                        'educato'
                    ),
                    number_format_i18n($comments_number),
                    get_the_title()
                );
            }
            ?>
        </h2>
        
        <ol class="comment-list space-y-6">
            <?php
            wp_list_comments([
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 50,
                'callback' => 'educato_comment_callback'
            ]);
            ?>
        </ol>
        
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
        <nav class="comment-navigation mt-8 flex justify-between">
            <div class="nav-previous">
                <?php previous_comments_link(__('&larr; Commentaires précédents', 'educato')); ?>
            </div>
            <div class="nav-next">
                <?php next_comments_link(__('Commentaires suivants &rarr;', 'educato')); ?>
            </div>
        </nav>
        <?php endif; ?>
        
    <?php endif; ?>
    
    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')): ?>
        <p class="no-comments text-gray-600 text-center py-8">
            <?php _e('Les commentaires sont fermés.', 'educato'); ?>
        </p>
    <?php endif; ?>
    
    <?php
    comment_form([
        'title_reply' => __('Laisser un commentaire', 'educato'),
        'title_reply_to' => __('Répondre à %s', 'educato'),
        'cancel_reply_link' => __('Annuler la réponse', 'educato'),
        'label_submit' => __('Publier le commentaire', 'educato'),
        'class_form' => 'comment-form mt-8',
        'class_submit' => 'btn btn-primary',
        'comment_field' => '<div class="mb-4"><label for="comment" class="block text-sm font-medium text-gray-700 mb-2">' . _x('Commentaire', 'noun', 'educato') . ' <span class="required text-red-500">*</span></label><textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea></div>',
        'fields' => [
            'author' => '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4"><div><label for="author" class="block text-sm font-medium text-gray-700 mb-2">' . __('Nom', 'educato') . ' <span class="required text-red-500">*</span></label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" /></div>',
            'email' => '<div><label for="email" class="block text-sm font-medium text-gray-700 mb-2">' . __('Email', 'educato') . ' <span class="required text-red-500">*</span></label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" /></div></div>',
            'url' => '<div class="mb-4"><label for="url" class="block text-sm font-medium text-gray-700 mb-2">' . __('Site web', 'educato') . '</label><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" /></div>'
        ]
    ]);
    ?>
</div>

<?php
// Comment callback function
function educato_comment_callback($comment, $args, $depth) {
    $tag = ($args['style'] === 'div') ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('comment flex space-x-4'); ?>>
        <div class="flex-shrink-0">
            <?php echo get_avatar($comment, 50, '', '', ['class' => 'w-12 h-12 rounded-full']); ?>
        </div>
        
        <div class="flex-1 min-w-0">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-medium text-gray-900">
                        <?php echo get_comment_author_link(); ?>
                    </h4>
                    <time datetime="<?php comment_time('c'); ?>" class="text-sm text-gray-500">
                        <?php comment_time(); ?>
                    </time>
                </div>
                
                <?php if ($comment->comment_approved == '0'): ?>
                <p class="text-sm text-yellow-600 mb-2">
                    <?php _e('Votre commentaire est en attente de modération.', 'educato'); ?>
                </p>
                <?php endif; ?>
                
                <div class="text-gray-700">
                    <?php comment_text(); ?>
                </div>
            </div>
            
            <div class="mt-2 flex items-center space-x-4 text-sm">
                <?php
                comment_reply_link(array_merge($args, [
                    'add_below' => 'comment',
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'before' => '',
                    'after' => ''
                ]));
                ?>
                <?php edit_comment_link(__('Modifier', 'educato'), '<span class="edit-link">', '</span>'); ?>
            </div>
        </div>
    <?php
}
?>