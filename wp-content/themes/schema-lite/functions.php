<?php
/**
 * Schema Lite functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Schema Lite
 */

if ( ! function_exists( 'schema_lite_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function schema_lite_setup() {
	define( 'SCHEMA_LITE_THEME_VERSION', '1.0.6' );
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Schema Lite, use a find and replace
	 * to change 'schema-lite' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'schema-lite', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true );
	add_image_size( 'schema-lite-featured', 680, 350, true ); //featured
	add_image_size( 'schema-lite-related', 210, 150, true ); //related

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
        'top' => esc_html__( 'Top', 'schema-lite' ),
		'primary' => esc_html__( 'Primary', 'schema-lite' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	if ( schema_lite_is_wc_active() ) {
		add_theme_support( 'woocommerce' );
	}

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'schema_lite_custom_background_args', array(
		'default-color' => '#eeeeee',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'schema_lite_setup' );

function schema_lite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'schema_lite_content_width', 678 );
}
add_action( 'after_setup_theme', 'schema_lite_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function schema_lite_widgets_init() {
	register_sidebar( array(
		'name'		  => esc_html__( 'Sidebar', 'schema-lite' ),
		'id'			=> 'sidebar',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	// First Footer 
	register_sidebar( array(
		'name'		  => __( 'Footer 1', 'schema-lite' ),
		'description'   => __( 'First footer column', 'schema-lite' ),
		'id'			=> 'footer-first',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Second Footer 
	register_sidebar( array(
		'name'		  => __( 'Footer 2', 'schema-lite' ),
		'description'   => __( 'Second footer column', 'schema-lite' ),
		'id'			=> 'footer-second',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Third Footer 
	register_sidebar( array(
		'name'		  => __( 'Footer 3', 'schema-lite' ),
		'description'   => __( 'Third footer column', 'schema-lite' ),
		'id'			=> 'footer-third',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	if ( schema_lite_is_wc_active() ) {
		// Register WooCommerce Shop and Single Product Sidebar
		register_sidebar( array(
			'name' => __('Shop Page Sidebar', 'schema-lite' ),
			'description'   => __( 'Appears on Shop main page and product archive pages.', 'schema-lite' ),
			'id' => 'shop-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __('Single Product Sidebar', 'schema-lite' ),
			'description'   => __( 'Appears on single product pages.', 'schema-lite' ),
			'id' => 'product-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'schema_lite_widgets_init' );

function schema_lite_custom_sidebar() {
	// Default sidebar.
	$sidebar = 'sidebar';

	// Woocommerce.
	if ( schema_lite_is_wc_active() ) {
		if ( is_shop() || is_product_category() ) {
			$sidebar = 'shop-sidebar';
		}
		if ( is_product() ) {
			$sidebar = 'product-sidebar';
		}
	}

	return $sidebar;
}

/**
 * Enqueue scripts and styles.
 */
function schema_lite_scripts() {
	wp_enqueue_style( 'schema-lite-style', get_stylesheet_uri() );
	wp_enqueue_script( 'jquery' );

	$handle = 'schema-lite-style';

	// WooCommerce
	if ( schema_lite_is_wc_active() ) {
		if ( is_woocommerce() || is_cart() || is_checkout() ) {
			wp_enqueue_style( 'schema-lite-woocommerce', get_template_directory_uri() . '/css/woocommerce2.css' );
			$handle = 'schema-lite-woocommerce';
		}
	}

	wp_enqueue_script( 'schema-lite-customscripts', get_template_directory_uri() . '/js/customscripts.js', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	$schema_lite_color_scheme = esc_attr(get_theme_mod('schema_lite_color_scheme', '#0274be'));
	$schema_lite_color_scheme2 = esc_attr(get_theme_mod('schema_lite_color_scheme2', '#222222'));
	$schema_lite_layout = esc_attr(get_theme_mod('schema_lite_layout', 'cslayout'));
	$header_image = esc_attr(get_header_image());
	$custom_css = "
		#site-header, #navigation.mobile-menu-wrapper { background-image: url('$header_image'); }
		.primary-navigation #navigation li:hover > a, #tabber .inside li .meta b,footer .widget li a:hover,.fn a,.reply a,#tabber .inside li div.info .entry-title a:hover, #navigation ul ul a:hover,.single_post a, a:hover, .sidebar.c-4-12 .textwidget a, #site-footer .textwidget a, #commentform a, #tabber .inside li a, .copyrights a:hover, a, .sidebar.c-4-12 a:hover, .top a:hover, footer .tagcloud a:hover, .title a, .related-posts .post:hover .title { color: $schema_lite_color_scheme; }

		#navigation ul li.current-menu-item a { color: $schema_lite_color_scheme!important; }

		.nav-previous a:hover, .nav-next a:hover, #commentform input#submit, #searchform input[type='submit'], .home_menu_item, .currenttext, .pagination a:hover, .mts-subscribe input[type='submit'], .pagination .current, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-product-search input[type='submit'], .woocommerce a.button, .woocommerce-page a.button, .woocommerce button.button, .woocommerce-page button.button, .woocommerce input.button, .woocommerce-page input.button, .woocommerce #respond input#submit, .woocommerce-page #respond input#submit, .woocommerce #content input.button, .woocommerce-page #content input.button, .featured-thumbnail .latestPost-review-wrapper.wp-review-show-total, .tagcloud a, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-page nav.woocommerce-pagination ul li span.current, .woocommerce #content nav.woocommerce-pagination ul li span.current, .woocommerce-page #content nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, #searchform input[type='submit'], .woocommerce-product-search input[type='submit'] { background-color: $schema_lite_color_scheme; }

		.woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-page nav.woocommerce-pagination ul li span.current, .woocommerce #content nav.woocommerce-pagination ul li span.current, .woocommerce-page #content nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce-page nav.woocommerce-pagination ul li a:focus, .woocommerce #content nav.woocommerce-pagination ul li a:focus, .woocommerce-page #content nav.woocommerce-pagination ul li a:focus, .pagination .current, .tagcloud a { border-color: $schema_lite_color_scheme; }
		.corner { border-color: transparent transparent $schema_lite_color_scheme transparent;}

		footer, #commentform input#submit:hover, .featured-thumbnail .latestPost-review-wrapper { background-color: $schema_lite_color_scheme2; }
			";
	if(!empty($schema_lite_layout) && $schema_lite_layout == "sclayout") {
		$custom_css .= ".article { float: right; } .sidebar.c-4-12 { float: left; }";
	}
	wp_add_inline_style( $handle, $custom_css );
}
add_action( 'wp_enqueue_scripts', 'schema_lite_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add the Social buttons Widget.
 */
include_once( "functions/widget-social.php" );

/**
 * Copyrights
 */
if ( ! function_exists( 'schema_lite_copyrights_credit' ) ) {
	function schema_lite_copyrights_credit() {
?>
<!--start copyrights-->
<div class="copyrights">
	<div class="container">
		<div class="row" id="copyright-note">
			<span><a href="<?php echo esc_url( home_url() ); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a> <?php _e('Copyright','schema-lite'); ?> &copy; <?php echo date_i18n(__('Y','schema-lite')); ?>.</span>
			<div class="top">
				<?php
				$allowed_tags = array(
					'a' => array(
						'class' => array(),
						'href'  => array(),
						'rel'   => array(),
						'title' => array(),
					),
					'b' => array(),
					'strong' => array(),
					'i' => array(),
					'em' => array(),
				);
				$schema_lite_copyright_text = wp_kses_post(get_theme_mod('schema_lite_copyright_text', __('Theme by','schema-lite').' <a href="http://mythemeshop.com/" rel="nofollow">MyThemeShop</a>.'), $allowed_tags);
					echo $schema_lite_copyright_text;
				?>
				<a href="#top" class="toplink"><?php _e('Back to Top','schema-lite'); ?> &uarr;</a>
			</div>
		</div>
	</div>
</div>
<!--end copyrights-->
<?php }
}

/**
 * Custom Comments template
 */
if ( ! function_exists( 'schema_lite_comments' ) ) {
	function schema_lite_comment($comment, $args, $depth) {
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			<div id="comment-<?php comment_ID(); ?>" style="position:relative;" itemscope itemtype="http://schema.org/UserComments">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment->comment_author_email, 80 ); ?>
					<div class="comment-metadata">
						<?php printf('<span class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</span>', get_comment_author_link()) ?>
                        <time><?php comment_date(get_option( 'date_format' )); ?></time>
						<span class="comment-meta">
							<?php edit_comment_link(__('(Edit)', 'schema-lite'),'  ','') ?>
						</span>
					</div>
				</div>
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php _e('Your comment is awaiting moderation.', 'schema-lite') ?></em>
					<br />
				<?php endif; ?>
				<div class="commentmetadata" itemprop="commentText">
					<?php comment_text() ?>
					<span class="reply">
						<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					</span>
				</div>
			</div>
	<?php }
}

/*
 * Excerpt
 */
function schema_lite_excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt);
  } else {
	$excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt.'...';
}

/**
 * Shorthand function to check for more tag in post.
 *
 * @return bool|int
 */
function schema_lite_post_has_moretag() {
	return strpos( get_the_content(), '<!--more-->' );
}

if ( ! function_exists( 'schema_lite_readmore' ) ) {
	/**
	 * Display a "read more" link.
	 */
	function schema_lite_readmore() {
		?>
		<div class="readMore">
			<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
				<?php _e( '[Continue reading...]', 'schema-lite' ); ?>
			</a>
		</div>
		<?php 
	}
}

/**
 * Breadcrumbs
 */
if (!function_exists('schema_lite_the_breadcrumb')) {
	function schema_lite_the_breadcrumb() {
		if ( is_front_page() ) {
			return;
		}
        echo '<span class="home"><i class="schema-lite-icon icon-home"></i></span>';
		echo '<span typeof="v:Breadcrumb" class="root"><a rel="v:url" property="v:title" href="';
		echo esc_url( home_url() );
		echo '">'.esc_html(sprintf( __( "Home", 'schema-lite' )));
		echo '</a></span><span><i class="schema-lite-icon icon-right-dir"></i></span>';
		if (is_single()) {
			$categories = get_the_category();
			if ( $categories ) {
				$level = 0;
				$hierarchy_arr = array();
				foreach ( $categories as $cat ) {
					$anc = get_ancestors( $cat->term_id, 'category' );
					$count_anc = count( $anc );
					if (  0 < $count_anc && $level < $count_anc ) {
						$level = $count_anc;
						$hierarchy_arr = array_reverse( $anc );
						array_push( $hierarchy_arr, $cat->term_id );
					}
				}
				if ( empty( $hierarchy_arr ) ) {
					$category = $categories[0];
					echo '<span typeof="v:Breadcrumb"><a href="'. esc_url( get_category_link( $category->term_id ) ).'" rel="v:url" property="v:title">'.esc_html( $category->name ).'</a></span><span><i class="schema-lite-icon icon-right-dir"></i></span>';
				} else {
					foreach ( $hierarchy_arr as $cat_id ) {
						$category = get_term_by( 'id', $cat_id, 'category' );
						echo '<span typeof="v:Breadcrumb"><a href="'. esc_url( get_category_link( $category->term_id ) ).'" rel="v:url" property="v:title">'.esc_html( $category->name ).'</a></span><span><i class="schema-lite-icon icon-right-dir"></i></span>';
					}
				}
			}
			echo "<span><span>";
			the_title();
			echo "</span></span>";
		} elseif (is_page()) {
			$parent_id  = wp_get_post_parent_id( get_the_ID() );
			if ( $parent_id ) {
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page = get_page( $parent_id );
					$breadcrumbs[] = '<span typeof="v:Breadcrumb"><a href="'.esc_url( get_permalink( $page->ID ) ).'" rel="v:url" property="v:title">'.esc_html( get_the_title($page->ID) ). '</a></span><span><i class="schema-lite-icon icon-angle-double-right"></i></span>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) { echo $crumb; }
			}
			echo "<span><span>";
			the_title();
			echo "</span></span>";
		} elseif (is_category()) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$this_cat_id = $cat_obj->term_id;
			$hierarchy_arr = get_ancestors( $this_cat_id, 'category' );
			if ( $hierarchy_arr ) {
				$hierarchy_arr = array_reverse( $hierarchy_arr );
				foreach ( $hierarchy_arr as $cat_id ) {
					$category = get_term_by( 'id', $cat_id, 'category' );
					echo '<span typeof="v:Breadcrumb"><a href="'.esc_url( get_category_link( $category->term_id ) ).'" rel="v:url" property="v:title">'.esc_html( $category->name ).'</a></span><span><i class="schema-lite-icon icon-angle-double-right"></i></span>';
				}
			}
			echo "<span><span>";
			single_cat_title();
			echo "</span></span>";
		} elseif (is_author()) {
			echo "<span><span>";
			if(get_query_var('author_name')) :
				$curauth = get_user_by('slug', get_query_var('author_name'));
			else :
				$curauth = get_userdata(get_query_var('author'));
			endif;
			echo esc_html( $curauth->nickname );
			echo "</span></span>";
		} elseif (is_search()) {
			echo "<span><span>";
			the_search_query();
			echo "</span></span>";
		} elseif (is_tag()) {
			echo "<span><span>";
			single_tag_title();
			echo "</span></span>";
		}
	}
}


/*
 * Google Fonts
 */
function schema_lite_fonts_url() { 
	$fonts_url = ''; 
 
	/** Translators: If there are characters in your language that are not 
	 * supported by Roboto Slab, translate this to 'off'. Do not translate 
	 * into your own language. 
	 */ 
	$roboto_slab = _x( 'on', 'Roboto Slab font: on or off', 'schema-lite' ); 
 
	/** Translators: If there are characters in your language that are not 
	 * supported by Raleway, translate this to 'off'. Do not translate into your 
	 * own language. 
	 */ 
	$raleway = _x( 'on', 'Raleway font: on or off', 'schema-lite' ); 
 
	if ( 'off' !== $roboto_slab || 'off' !== $raleway ) { 
		$font_families = array(); 
 
		if ( 'off' !== $roboto_slab ) 
			$font_families[] = 'Roboto Slab:300,400'; 
 
		if ( 'off' !== $raleway ) 
			$font_families[] = 'Raleway:400,500,700'; 
 
		$query_args = array( 
			'family' => urlencode( implode( '|', $font_families ) ),  
			'subset' => urlencode( 'latin-ext' ),
		); 
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ); 
	} 
 
	return $fonts_url; 
}

function schema_lite_scripts_styles() {
	wp_enqueue_style( 'schema-lite-fonts', schema_lite_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'schema_lite_scripts_styles' );

/**
 * WP Mega Menu Plugin Support
 */
function schema_lite_megamenu_parent_element( $selector ) {
	return '.primary-navigation .container';
}
add_filter( 'wpmm_container_selector', 'schema_lite_megamenu_parent_element' );

/**
 * Determines whether the WooCommerce plugin is active or not.
 * @return bool
 */
function schema_lite_is_wc_active() {
	if ( is_multisite() ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		return is_plugin_active( 'woocommerce/woocommerce.php' );
	} else {
		return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}
}

/**
 * WooCommerce
 */
if ( schema_lite_is_wc_active() ) {
	if ( !function_exists( 'schema_lite_loop_columns' )) {
		/**
		 * Change number or products per row to 3
		 *
		 * @return int
		 */
		function schema_lite_loop_columns() {
			return 3; // 3 products per row
		}
	}
	add_filter( 'loop_shop_columns', 'schema_lite_loop_columns' );

	/**
	 * Redefine schema_lite_output_related_products()
	 */
	function schema_lite_output_related_products() {
		$args = array(
			'posts_per_page' => 3,
			'columns' => 3,
		);
		woocommerce_related_products($args); // Display 3 products in rows of 1
	}

	/**
	 * Change the number of product thumbnails to show per row to 4.
	 *
	 * @return int
	 */
	function schema_lite_woocommerce_thumb_cols() {
	 return 4; // .last class applied to every 4th thumbnail
	}
	add_filter( 'woocommerce_product_thumbnails_columns', 'schema_lite_woocommerce_thumb_cols' );

	/**
	 * Optimize WooCommerce Scripts
	 * Updated for WooCommerce 2.0+
	 * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
	 */
	function schema_lite_manage_woocommerce_styles() {
	 
		//first check that woo exists to prevent fatal errors
		if ( function_exists( 'is_woocommerce' ) ) {
			//dequeue scripts and styles
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_style( 'woocommerce-layout' );
				wp_dequeue_style( 'woocommerce-smallscreen' );
				wp_dequeue_style( 'woocommerce-general' );
				wp_dequeue_style( 'wc-bto-styles' ); //Composites Styles
				wp_dequeue_script( 'wc-add-to-cart' );
				wp_dequeue_script( 'wc-cart-fragments' );
				wp_dequeue_script( 'woocommerce' );
				wp_dequeue_script( 'jquery-blockui' );
				wp_dequeue_script( 'jquery-placeholder' );
			}
		}
	}
	add_action( 'wp_enqueue_scripts', 'schema_lite_manage_woocommerce_styles', 99 );

}

/**
 * Post Layout for Archives
 */
if ( ! function_exists( 'schema_lite_archive_post' ) ) {
	/**
	 * Display a post of specific layout.
	 * 
	 * @param string $layout
	 */
	function schema_lite_archive_post( $layout = '' ) { 
		$schema_lite_full_posts = get_theme_mod('schema_lite_full_posts', '0'); ?>
		<article class="post excerpt">
			<header>						
				<h2 class="title">
					<a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<div class="post-info">
					<span class="theauthor"><i class="schema-lite-icon icon-user"></i> <?php _e('By','schema-lite'); ?> <?php esc_url(the_author_posts_link()); ?></span>
                    <span class="posted-on entry-date date updated"><i class="schema-lite-icon icon-calendar"></i> <?php the_time( get_option( 'date_format' ) ); ?></span>
					<span class="featured-cat"><i class="schema-lite-icon icon-tags"></i> <?php the_category(', '); ?></span>
					<span class="thecomment"><i class="schema-lite-icon icon-comment"></i> <a href="<?php esc_url(comments_link()); ?>"><?php comments_number(__('0 Comments','schema-lite'),__('1 Comment','schema-lite'),__('% Comments','schema-lite')); ?></a></span>
				</div>
			</header><!--.header-->
			<?php if ( empty($schema_lite_full_posts) ) : ?>
				<?php if ( has_post_thumbnail() ) { ?>
					<a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>" id="featured-thumbnail">
						<div class="featured-thumbnail">
							<?php the_post_thumbnail('schema-lite-featured',array('title' => '')); ?>
							<?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
						</div>
					</a>
				<?php } ?>
				<div class="post-content">
					<?php echo schema_lite_excerpt(42); ?>
				</div>
				<?php schema_lite_readmore(); ?>
			<?php else : ?>
				<div class="post-content full-post">
					<?php the_content(); ?>
				</div>
				<?php if (schema_lite_post_has_moretag()) : ?>
					<?php schema_lite_readmore(); ?>
				<?php endif; ?>
			<?php endif; ?>
		</article>
	<?php }
}

/**
 * Single Post Schema
 *
 * @return string
 */
function schema_lite_single_post_schema() {
	if ( is_singular( 'post' ) ) {
		global $post;
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( has_post_thumbnail( $post->ID ) && !empty( $custom_logo_id ) ) {
			$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
			if ( $logo_id ) {
				
				$images  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				$logo	= wp_get_attachment_image_src( $logo_id, 'full' );
				$excerpt = schema_lite_escape_text_tags( $post->post_excerpt );
				$content = $excerpt === "" ? mb_substr( schema_lite_escape_text_tags( $post->post_content ), 0, 110 ) : $excerpt;
				$args = array(
					"@context" => "http://schema.org",
					"@type"	=> "BlogPosting",
					"mainEntityOfPage" => array(
						"@type" => "WebPage",
						"@id"   => get_permalink( $post->ID )
					),
					"headline" => ( function_exists( '_wp_render_title_tag' ) ? wp_get_document_title() : wp_title( '', false, 'right' ) ),
					"image"	=> array(
						"@type"  => "ImageObject",
						"url"	 => $images[0],
						"width"  => $images[1],
						"height" => $images[2]
					),
					"datePublished" => get_the_time( DATE_ISO8601, $post->ID ),
					"dateModified"  => get_post_modified_time(  DATE_ISO8601, __return_false(), $post->ID ),
					"author" => array(
						"@type" => "Person",
						"name"  => schema_lite_escape_text_tags( get_the_author_meta( 'display_name', $post->post_author ) )
					),
					"publisher" => array(
						"@type" => "Organization",
						"name"  => get_bloginfo( 'name' ),
						"logo"  => array(
							"@type"  => "ImageObject",
							"url"	 => $logo[0],
							"width"  => $logo[1],
							"height" => $logo[2]
						)
					),
					"description" => ( class_exists('WPSEO_Meta') ? WPSEO_Meta::get_value( 'metadesc' ) : $content )
				);
				echo '<script type="application/ld+json">' , PHP_EOL;
				echo wp_json_encode( $args, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) , PHP_EOL;
				echo '</script>' , PHP_EOL;
			}
		}
	}
}
add_action( 'wp_head', 'schema_lite_single_post_schema' );

/**
 * Sanitizes choices (selects / radios)
 * Checks that the input matches one of the available choices
 *
 * @param array $input the available choices.
 * @param array $setting the setting object.
 */
function schema_lite_sanitize_choices( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}