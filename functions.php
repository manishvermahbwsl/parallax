<?php
/**
 * Title: Function
 *
 * Description: Defines theme specific functions including actions and filters.
 *
 * Please do not edit this file. This file is part of the Cyber Chimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category Cyber Chimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

// Load text domain.
function cyberchimps_text_domain() {
	load_theme_textdomain( 'parallax', get_template_directory() . '/inc/languages' );
}
add_action( 'after_setup_theme', 'cyberchimps_text_domain' );
// Load Core
require_once( get_template_directory() . '/cyberchimps/init.php' );
require_once( get_template_directory() . '/inc/featured-lite.php' );
require_once( get_template_directory() . '/inc/testimonial_template.php' );


// Set the content width based on the theme's design and stylesheet.
if ( !isset( $content_width ) ) {
	$content_width = 640;
} /* pixels */

// Define site info
function cyberchimps_add_site_info() {
	?>
	<p>&copy; Company Name</p>
<?php
}

add_action( 'cyberchimps_site_info', 'cyberchimps_add_site_info' );
add_action( 'wp_footer', 'featured_parallax_render' );
function featured_parallax_render() {
//$parallax_image = ( get_post_meta( $post->ID, 'featuredarea_backgroundimage', true ) ) ? get_post_meta( $post->ID, 'featuredarea_backgroundimage', true ) : '';
	?>

			<script>
					jQuery(document).ready(function () {
						<?php
						// Add parallax.
						 ?>
						jQuery('#featured_lite_section').css({

							'background-size': '100%'
						});
						jQuery('#featured_lite_section').parallax('50%', 0.5);
						<?php ?>
					});
				</script>
		<?php
}
function cyberchimps_parallax_script_setup() {

	wp_enqueue_script( 'theme-js', get_template_directory_uri() . '/inc/js/theme.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'jquery-flexslider', get_template_directory_uri() . '/inc/js/jquery.flexslider.js', 'jquery', '1.0', true );
}

add_action( 'wp_enqueue_scripts', 'cyberchimps_parallax_script_setup' );

function cyberchimps_instantiate_class() {
	CyberChimpsParallax::instance();
}
add_action( 'after_setup_theme', 'cyberchimps_instantiate_class' );



function editparallax_customize_register( $wp_customize ){
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
	) );
$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[bl_featuredarea_title]', array(
		'selector' => '.featured-title'
) );
$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[bl_featuredarea_text]', array(
		'selector' => '.featured-text'
) );
$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[bl_featuredarea_button1_text]', array(
		'selector' => '.featured-button1'
) );
$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[bl_featuredarea_button2_text]', array(
		'selector' => '.featured-button2'
) );
$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[bl_featuredarea_backgroundimage]', array(
		'selector' => '#featuredarea_container'
) );
$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[searchbar]', array(
		'selector' => '#navigation #searchform'
) );
$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[custom_logo]', array(
		'selector' => '#logo'
) );
$wp_customize->selective_refresh->add_partial( 'nav_menu_locations[primary]', array(
		'selector' => '#navigation'
) );
$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[theme_backgrounds]', array(
		'selector' => '#social'
) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[footer_show_toggle]', array(
		'selector' => '#footer-widget-container'
) );

}
add_action( 'customize_register', 'editparallax_customize_register' );
add_theme_support( 'customize-selective-refresh-widgets' );

if ( !function_exists( 'cyberchimps_comment' ) ) :

// Template for comments and pingbacks.
// Used as a callback by wp_list_comments() for displaying the comments.
	function cyberchimps_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>
				<li class="post pingback">
				<p><?php _e( 'Pingback:', 'parallax' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'parallax' ), ' ' ); ?></p>
				<?php
				break;
			default :
				?>
					<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment hreview">
						<footer>
							<div class="comment-author reviewer vcard">
								<?php echo get_avatar( $comment, 40 ); ?>
								<?php printf( '%s <span class="says">' . __( 'says:', 'parallax' ) . '</span>', sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
							</div>
							<!-- .comment-author .vcard -->
							<?php if ( $comment->comment_approved == '0' ) : ?>
								<em><?php _e( 'Your comment is awaiting moderation.', 'parallax' ); ?></em>
								<br/>
							<?php endif; ?>

							<div class="comment-meta commentmetadata">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="dtreviewed">
									<time pubdate datetime="<?php comment_time( 'c' ); ?>">
										<?php
										/* translators: 1: date, 2: time */
										printf( __( '%1$s at %2$s', 'parallax' ), get_comment_date(), get_comment_time() ); ?>
									</time>
								</a>
								<?php edit_comment_link( __( '(Edit)', 'parallax' ), ' ' );
								?>
							</div>
							<!-- .comment-meta .commentmetadata -->
						</footer>

						<div class="comment-content"><?php comment_text(); ?></div>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div>
						<!-- .reply -->
					</article><!-- #comment-## -->

				<?php
				break;
		endswitch;
	}
endif; // ends check for cyberchimps_comment()

// set up next and previous post links for lite themes only
function cyberchimps_next_previous_posts() {
	if ( get_next_posts_link() || get_previous_posts_link() ): ?>
		<div class="more-content">
			<div class="row-fluid">
				<div class="span6 previous-post">
					<?php previous_posts_link(); ?>
				</div>
				<div class="span6 next-post">
					<?php next_posts_link(); ?>
				</div>
			</div>
		</div>
	<?php
	endif;
}

add_action( 'cyberchimps_after_content', 'cyberchimps_next_previous_posts' );

// core options customization Names and URL's
//Pro or Free
function cyberchimps_theme_check() {
	$level = 'free';

	return $level;
}

//Theme Name
function cyberchimps_options_theme_name() {
	$text = 'Parallax';

	return $text;
}

//Theme Pro Name
function cyberchimps_upgrade_bar_pro_title() {
	$text = 'Parallax Pro';

	return $text;
}

//Upgrade link
function cyberchimps_upgrade_bar_pro_link() {
	$url = 'http://cyberchimps.com/store/parallax-pro';

	return $url;
}

//Doc's URL
function cyberchimps_options_documentation_url() {
	$url = 'http://cyberchimps.com/guides/c/';

	return $url;
}

// Support Forum URL
function cyberchimps_options_support_forum() {
	$url = 'http://cyberchimps.com/forum/free/parallax/';

	return $url;
}

add_filter( 'cyberchimps_current_theme_name', 'cyberchimps_options_theme_name', 1 );
add_filter( 'cyberchimps_upgrade_pro_title', 'cyberchimps_upgrade_bar_pro_title' );
add_filter( 'cyberchimps_upgrade_link', 'cyberchimps_upgrade_bar_pro_link' );
add_filter( 'cyberchimps_documentation', 'cyberchimps_options_documentation_url' );
add_filter( 'cyberchimps_support_forum', 'cyberchimps_options_support_forum' );

// Help Section
function cyberchimps_options_help_header() {
	$text = 'parallax';

	return $text;
}

function cyberchimps_options_help_sub_header() {
	$text = __( 'CyberChimps Professional Responsive WordPress Theme', 'parallax' );

	return $text;
}

add_filter( 'cyberchimps_help_heading', 'cyberchimps_options_help_header' );
add_filter( 'cyberchimps_help_sub_heading', 'cyberchimps_options_help_sub_header' );

// Branding images and defaults

// Banner default
function cyberchimps_banner_default() {
	$url = '/images/branding/banner.jpg';

	return $url;
}

add_filter( 'cyberchimps_banner_img', 'cyberchimps_banner_default' );

//theme specific skin options in array. Must always include option default
function cyberchimps_skin_color_options( $options ) {
	// Get path of image
	$imagepath = get_template_directory_uri() . '/inc/css/skins/images/';

	$options = array(
		'default' => $imagepath . 'default.png'
	);

	return $options;
}

add_filter( 'cyberchimps_skin_color', 'cyberchimps_skin_color_options' );

// theme specific background images
function cyberchimps_background_image( $options ) {
	$imagepath = get_template_directory_uri() . '/cyberchimps/lib/images/';
	$options   = array(
		'none'  => $imagepath . 'backgrounds/thumbs/none.png',
		'noise' => $imagepath . 'backgrounds/thumbs/noise.png',
		'blue'  => $imagepath . 'backgrounds/thumbs/blue.png',
		'dark'  => $imagepath . 'backgrounds/thumbs/dark.png',
		'space' => $imagepath . 'backgrounds/thumbs/space.png'
	);

	return $options;
}

add_filter( 'cyberchimps_background_image', 'cyberchimps_background_image' );

// theme specific typography options
function cyberchimps_typography_sizes( $sizes ) {
	$sizes = array( '8', '9', '10', '12', '14', '16', '20' );

	return $sizes;
}

function cyberchimps_typography_faces( $faces ) {
	$faces = array(
		'Arial, Helvetica, sans-serif'                     => 'Arial',
		'Arial Black, Gadget, sans-serif'                  => 'Arial Black',
		'Comic Sans MS, cursive'                           => 'Comic Sans MS',
		'Courier New, monospace'                           => 'Courier New',
		'Georgia, serif'                                   => 'Georgia',
		'Impact, Charcoal, sans-serif'                     => 'Impact',
		'Lucida Console, Monaco, monospace'                => 'Lucida Console',
		'Lucida Sans Unicode, Lucida Grande, sans-serif'   => 'Lucida Sans Unicode',
		'Palatino Linotype, Book Antiqua, Palatino, serif' => 'Palatino Linotype',
		'Tahoma, Geneva, sans-serif'                       => 'Tahoma',
		'Times New Roman, Times, serif'                    => 'Times New Roman',
		'Trebuchet MS, sans-serif'                         => 'Trebuchet MS',
		'Verdana, Geneva, sans-serif'                      => 'Verdana',
		'Symbol'                                           => 'Symbol',
		'Webdings'                                         => 'Webdings',
		'Wingdings, Zapf Dingbats'                         => 'Wingdings',
		'MS Sans Serif, Geneva, sans-serif'                => 'MS Sans Serif',
		'MS Serif, New York, serif'                        => 'MS Serif',
		'Arimo, Arial, sans-serif'                         => 'Arimo',
		'Spinnaker, sans-serif'                            => 'Spinnaker',
	);

	return $faces;
}

function cyberchimps_typography_styles( $styles ) {
	$styles = array( 'normal' => 'Normal', 'bold' => 'Bold' );

	return $styles;
}

function cyberchimps_typography_defaults() {
	$default = array(
		'size'  => '14px',
		'face'  => 'Arimo, Arial, sans-serif',
		'style' => 'normal',
		'color' => '#555555'
	);

	return $default;
}

function cyberchimps_typography_heading_defaults() {
	$default = array(
		'face'  => 'Spinnaker, sans-serif',
	);

	return $default;
}

add_filter( 'cyberchimps_typography_sizes', 'cyberchimps_typography_sizes' );
add_filter( 'cyberchimps_typography_faces', 'cyberchimps_typography_faces' );
add_filter( 'cyberchimps_typography_styles', 'cyberchimps_typography_styles' );
add_filter( 'cyberchimps_typography_defaults', 'cyberchimps_typography_defaults' );
add_filter( 'cyberchimps_typography_heading_defaults', 'cyberchimps_typography_heading_defaults' );

function parallax_customize_register( $wp_customize )
{
	$wp_customize->add_section( 'cyberchimps_featured_lite_section', array(
			'priority' => 15,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Featured Lite', 'cyberchimps_core' ),
			'description' => '',
			'panel' => 'blog_id',
	) );
	$wp_customize->add_setting( 'cyberchimps_options[bl_featuredarea_title]', array(
		'type' => 'option',
		'sanitize_callback' => 'cyberchimps_text_sanitization'
	) );
	$wp_customize->add_control( 'bl_featuredarea_title', array(
			'label' => __( 'Featured Area Title', 'cyberchimps_core' ),
			'section' => 'cyberchimps_featured_lite_section',
			'default' => __( 'This is Featured Area Title', 'cyberchimps_core' ),
			'settings' => 'cyberchimps_options[bl_featuredarea_title]',
			'type' => 'text'
	) );
	$wp_customize->add_setting( 'cyberchimps_options[bl_featuredarea_text]', array(
			'type' => 'option',
			'sanitize_callback' => 'cyberchimps_text_sanitization'
	) );
	$wp_customize->add_control( 'bl_featuredarea_text', array(
			'label' => __( 'Featured Area Text', 'cyberchimps_core' ),
			'section' => 'cyberchimps_featured_lite_section',
			'default' => __( 'Here you can place Featured Area Text', 'cyberchimps_core' ),
			'settings' => 'cyberchimps_options[bl_featuredarea_text]',
			'type' => 'textarea'
	) );
	$wp_customize->add_setting( 'cyberchimps_options[bl_featuredarea_button1_text]', array(
			'type' => 'option',
			'sanitize_callback' => 'cyberchimps_text_sanitization'
	) );
	$wp_customize->add_control( 'bl_featuredarea_button1_text', array(
			'label' => __( 'Featured Area Button1 Text', 'cyberchimps_core' ),
			'section' => 'cyberchimps_featured_lite_section',
			'default' => __( 'Free Responsive Themes', 'cyberchimps_core' ),
			'settings' => 'cyberchimps_options[bl_featuredarea_button1_text]',
			'type' => 'text'
	) );
	$wp_customize->add_setting( 'cyberchimps_options[bl_featuredarea_button1_url]', array(
			'type' => 'option',
			'sanitize_callback' => 'cyberchimps_text_sanitization'
	) );
	$wp_customize->add_control( 'bl_featuredarea_button1_url', array(
			'label' => __( 'Featured Area Button1 URL', 'cyberchimps_core' ),
			'section' => 'cyberchimps_featured_lite_section',
			'default' => '',
			'settings' => 'cyberchimps_options[bl_featuredarea_button1_url]',
			'type' => 'text'
	) );
	$wp_customize->add_setting( 'cyberchimps_options[bl_featuredarea_button2_text]', array(
			'type' => 'option',
			'sanitize_callback' => 'cyberchimps_text_sanitization'
	) );
	$wp_customize->add_control( 'bl_featuredarea_button2_text', array(
			'label' => __( 'Featured Area Button2 Text', 'cyberchimps_core' ),
			'section' => 'cyberchimps_featured_lite_section',
			'default' => __( 'Explore Pro Themes', 'cyberchimps_core' ),
			'settings' => 'cyberchimps_options[bl_featuredarea_button2_text]',
			'type' => 'text'
	) );
	$wp_customize->add_setting( 'cyberchimps_options[bl_featuredarea_button2_url]', array(
			'type' => 'option',
			'sanitize_callback' => 'cyberchimps_text_sanitization'
	) );
	$wp_customize->add_control( 'bl_featuredarea_button2_url', array(
			'label' => __( 'Featured Area Button2 URL', 'cyberchimps_core' ),
			'section' => 'cyberchimps_featured_lite_section',
			'default' => '',
			'settings' => 'cyberchimps_options[bl_featuredarea_button2_url]',
			'type' => 'text'
	) );
	$wp_customize->add_setting( 'cyberchimps_options[bl_featuredarea_backgroundimage]', array(
			'default' => '',
			'type' => 'option',
			'sanitize_callback' => 'cyberchimps_sanitize_upload'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bl_featuredarea_backgroundimage', array(
			'label' => __( 'Featured Area Background Image', 'cyberchimps_core' ),
			'section' => 'cyberchimps_featured_lite_section',
			'settings' => 'cyberchimps_options[bl_featuredarea_backgroundimage]',
			'type' => 'image',
	) ) );

}
add_action( 'customize_register', 'parallax_customize_register' );

function cyberchimps_blog_draganddrop_defaults() {
	$options = array(
		'slider_lite'    => __( 'Slider Lite', 'cyberchimps_core' ),
		'boxes_lite'     => __( 'Boxes', 'cyberchimps_core' ),
		'portfolio_lite' => __( 'Portfolio Lite', 'cyberchimps_core' ),
		'blog_post_page' => __( 'Post Page', 'cyberchimps_core' ),
		'featured_lite' => __( 'Featured lite', 'cyberchimps_core' ),
	);

	return $options;
}

add_filter( 'cyberchimps_elements_draganddrop_defaults', 'cyberchimps_blog_draganddrop_defaults' );


// Customize social icons.
function cyberchimps_social_icon_options( $options ) {
	$options['default'] = get_template_directory_uri() . '/images/social/icons-default.png';

	return $options;
}
add_filter( 'cyberchimps_social_icon_options', 'cyberchimps_social_icon_options' );


// Default for twitter bar handle
function cyberchimps_twitter_handle_filter() {
	return 'WordPress';
}

add_filter( 'cyberchimps_twitter_handle_filter', 'cyberchimps_twitter_handle_filter' );

// Set blog layout option default
function cyberchimps_blog_layout_options_default() {
	return 'full_width';
}
add_filter( 'cyberchimps_blog_layout_options_default', 'cyberchimps_blog_layout_options_default' );

// Remove header drag and drop as it is not suitable to the design in this theme.
function cyberchimps_remove_header_drag_drop( $sections_list ) {
	return cyberchimps_remove_options( $sections_list, array( 'cyberchimps_header_drag_drop_section' ) );
}
add_filter( 'cyberchimps_sections_filter', 'cyberchimps_remove_header_drag_drop' );

function cyberchimps_parallax_upgrade_bar(){
	$upgrade_link = apply_filters( 'cyberchimps_upgrade_link', 'http://cyberchimps.com' );
	$pro_title = apply_filters( 'cyberchimps_upgrade_pro_title', 'CyberChimps Pro' );
?>
	<br>
	<div class="upgrade-callout">
		<p><img src="<?php echo get_template_directory_uri(); ?>/cyberchimps/options/lib/images/chimp.png" alt="CyberChimps"/>
			<?php printf(
				__( 'Welcome to Parallax! Get 30%% off on %1$s using Coupon Code <span style="color:red">PARALLAX30</span>', 'cyberchimps_core' ),
				'<a href="' . $upgrade_link . '" target="_blank" title="' . $pro_title . '">' . $pro_title . '</a> '
			); ?>
		</p>

	<div class="social-container">
			<div class="social">
				<a href="https://twitter.com/cyberchimps" class="twitter-follow-button" data-show-count="false" data-size="small">Follow @cyberchimps</a>
				<script>!function (d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (!d.getElementById(id)) {
							js = d.createElement(s);
							js.id = id;
							js.src = "//platform.twitter.com/widgets.js";
							fjs.parentNode.insertBefore(js, fjs);
						}
					}(document, "script", "twitter-wjs");</script>
			</div>
			<div class="social">
				<iframe
					src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fcyberchimps.com%2F&amp;send=false&amp;layout=button_count&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21"
					scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:21px;" allowTransparency="true"></iframe>
			</div>
		</div>

	</div>
<h4 class="notice notice-info is-dismissible" style="margin-top:15px;">
<p>
<?php
	$utm_link="https://cyberchimps.com/free-download-50-stock-images-use-please/?utm_source=parallax";
 	$utm_text="Get 50 Free High-Resolution Stock Images by CyberChimps";
	printf('<a href="' . $utm_link . '" target="_blank">' . $utm_text . '</a> ');
?>
</p>
</h4>

<?php
}

add_action('admin_init','remove_upgrade_bar');
function remove_upgrade_bar(){
remove_action( 'cyberchimps_options_before_container', 'cyberchimps_upgrade_bar');
}

if( cyberchimps_theme_check() == 'free' ) {
	add_action( 'cyberchimps_options_before_container', 'cyberchimps_parallax_upgrade_bar' );
}

/**
 * [parallax_title_setup description]
 *
 * @return void.
 */
function parallax_title_setup() {
	// enabling theme support for title tag.
	add_theme_support( 'title-tag' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Adds support for editor color palette.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Gray', 'parallax' ),
				'slug'  => 'gray',
				'color' => '#777',
			),
			array(
				'name'  => __( 'Light Gray', 'parallax' ),
				'slug'  => 'light-gray',
				'color' => '#f5f5f5',
			),
			array(
				'name'  => __( 'Black', 'parallax' ),
				'slug'  => 'black',
				'color' => '#000000',
			),

			array(
				'name'  => __( 'Blue', 'parallax' ),
				'slug'  => 'blue',
				'color' => '#0286cf',
			),

			array(
				'name'  => __( 'Legacy', 'parallax' ),
				'slug'  => 'legacy',
				'color' => '#b6b6b6',
			),

			array(
				'name'  => __( 'Red', 'parallax' ),
				'slug'  => 'red',
				'color' => '#c80a00',
			),
		)
	);

}
add_action( 'after_setup_theme', 'parallax_title_setup' );

//add new add on - WPForms
function parallax_new_addon_sections( $sections_list ) {
	$sections_list[] = array(
		'id'      => 'cyberchimps_wpforms_lite_options',
		'label'   => __( 'WPForms Lite', 'parallax' ),
		'heading' => 'cyberchimps_addons_heading'
	);

	$sections_list[] = array(
		'id'      => 'cyberchimps_featured_lite_options',
		'label'   => __( 'Featured lite', 'parallax' ),
		'heading' => 'cyberchimps_blog_heading'
	);

	return $sections_list;
}

add_filter( 'cyberchimps_section_list', 'parallax_new_addon_sections', 20, 1 );

// Addon Fields
function parallax_new_addon_fields( $fields_list ) {
	$fields_list[] = array(
		'name'     => __( 'WPForms Lite', 'cyberchimps_core' ),
		'id'       => 'wpforms_lite',
		'type'     => 'info',
		'callback' => 'cyberchimps_custom_wpforms_lite_callback',
		'section'  => 'cyberchimps_wpforms_lite_options',
		'heading'  => 'cyberchimps_addons_heading'
	);
	$fields_list[] = array(
		'name'    => __( 'Featured Area Title', 'parallax' ),
		'id'      => 'bl_featuredarea_title',
		'std'     => __( 'The Future Has Arrived', 'parallax' ),
		'type'    => 'text',
		'section' => 'cyberchimps_featured_lite_options',
		'heading' => 'cyberchimps_blog_heading'
	);
	$fields_list[] = array(
		'name'    => __( 'Featured Area Text', 'parallax' ),
		'id'      => 'bl_featuredarea_text',
		'std'     => __( 'Mobile first responsive websites that look incredible on all devices.', 'parallax' ),
		'type'    => 'editor',
		'section' => 'cyberchimps_featured_lite_options',
		'heading' => 'cyberchimps_blog_heading'
	);
	$fields_list[] = array(
		'name'    => __( 'Featured Area Button1 Text', 'parallax' ),
'id'      => 'bl_featuredarea_button1_text',
'class'   => 'featuredarea_button1_toggle',
'std'     => __( 'Free Responsive Themes', 'parallax' ),
'type'    => 'text',
'section' => 'cyberchimps_featured_lite_options',
'heading' => 'cyberchimps_blog_heading'
);
	$fields_list[] = array(
		'name'    => __( 'Featured Area Button1 URL', 'parallax' ),
		'id'      => 'bl_featuredarea_button1_url',
		'class'   => 'featuredarea_button1_toggle',
		'std'     => '',
		'type'    => 'text',
		'section' => 'cyberchimps_featured_lite_options',
		'heading' => 'cyberchimps_blog_heading'
	);
	$fields_list[] = array(
			'name'    => __( 'Featured Area Button2 Text', 'parallax' ),
	'id'      => 'bl_featuredarea_button2_text',
	'class'   => 'featuredarea_button2_toggle',
	'std'     => __( 'Explore Pro Themes', 'parallax' ),
	'type'    => 'text',
	'section' => 'cyberchimps_featured_lite_options',
	'heading' => 'cyberchimps_blog_heading'
	);
	$fields_list[] = array(
		'name'    => __( 'Featured Area Button2 URL', 'parallax' ),
		'id'      => 'bl_featuredarea_button2_url',
		'class'   => 'featuredarea_button2_toggle',
		'std'     => '',
		'type'    => 'text',
		'section' => 'cyberchimps_featured_lite_options',
		'heading' => 'cyberchimps_blog_heading'
	);
	$fields_list[] = array(
	'name'    => __( 'Featured Area Background Image', 'parallax' ),
	'id'      => 'bl_featuredarea_backgroundimage',
	'class'   => 'custom_featuredbg_options_toggle',
	'std'     => '',
	'type'    => 'upload',
	'section' => 'cyberchimps_featured_lite_options',
	'heading' => 'cyberchimps_blog_heading'
);

	return $fields_list;
}

add_action( 'admin_notices', 'parallax_admin_notices' );
function parallax_admin_notices()
{
	$admin_check_screen = get_admin_page_title();

	if( !class_exists('SlideDeckPlugin') )
	{
	$plugin='slidedeck/slidedeck.php';
	$slug = 'slidedeck';
	$installed_plugins = get_plugins();

	 if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
		?>
		<div class="notice notice-info is-dismissible" style="margin-top:15px;">
		<p>
			<?php if( isset( $installed_plugins[$plugin] ) )
			{
			?>
				 <a href="<?php echo admin_url( 'plugins.php' ); ?>">Activate the SlideDeck Lite plugin</a>
			 <?php
			}
			else
			{
			 ?>
			 <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ); ?>">Install the SlideDeck Lite plugin</a>
			 <?php } ?>

		</p>
		</div>
		<?php
	}
	}

	if( !class_exists('WPForms') )
	{
	$plugin = 'wpforms-lite/wpforms.php';
	$slug = 'wpforms-lite';
	$installed_plugins = get_plugins();
	 if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
		?>
		<div class="notice notice-info is-dismissible" style="margin-top:15px;">
		<p>
			<?php if( isset( $installed_plugins[$plugin] ) )
			{
			?>
				 <a href="<?php echo admin_url( 'plugins.php' ); ?>">Activate the WPForms Lite plugin</a>
			 <?php
			}
			else
			{
			 ?>
	 		 <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ); ?>">Install the WP Forms Lite plugin</a>
			 <?php } ?>
		</p>
		</div>
		<?php
	}
	}

	if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
	?>
		<div class="notice notice-success is-dismissible">
				<b><p>Liked this theme? <a href="https://wordpress.org/support/theme/parallax/reviews/#new-post" target="_blank">Leave us</a> a ***** rating. Thank you! </p></b>
		</div>
		<?php
	}

}

add_action( 'cyberchimps_posted_by', 'parallax_byline_author' );
function parallax_byline_author()
{
	// Get url of all author archive( the page will contain all posts by the author).
$auther_posts_url = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );

// Set author title text which will appear on hover over the author link.
$auther_link_title = esc_attr( sprintf( __( 'View all posts by %s', 'cyberchimps_core' ), get_the_author() ) );

// Get value of post byline author toggle option from theme option for different pages.
if( is_single() ) {
	$show_author = ( cyberchimps_get_option( 'single_post_byline_author', 1 ) ) ? cyberchimps_get_option( 'single_post_byline_author', 1 ) : false;
}
elseif( is_archive() ) {
	$show_author = ( cyberchimps_get_option( 'archive_post_byline_author', 1 ) ) ? cyberchimps_get_option( 'archive_post_byline_author', 1 ) : false;
}
else {
	$show_author = ( cyberchimps_get_option( 'post_byline_author', 1 ) ) ? cyberchimps_get_option( 'post_byline_author', 1 ) : false;
}

	$posted_by = sprintf(
							'<span class="byline"> ' . __( 'by %s', 'cyberchimps_core' ),
								'<span class="author vcard">
									<a class="url fn n" href="' . $auther_posts_url . '" title="' . $auther_link_title . '" rel="author">' . esc_html( get_the_author() ) . '</a>
								</span>
								<span class="avatar">
									<a href="' . $auther_posts_url . '" title="' . $auther_link_title . '" rel="avatar">' . get_avatar( get_the_author_meta( 'ID' ), 20) . '</a>
								</span>
							</span>'

						);

	if( $show_author )
	{
			return $posted_by;
	}

	return;
}


/**
 *  Enqueue block styles  in editor
 */
function parallax_block_styles() {
	wp_enqueue_style( 'parallax-gutenberg-blocks', get_stylesheet_directory_uri() . '/inc/css/gutenberg-blocks.css', array(), '1.0' );

}
add_action( 'enqueue_block_editor_assets', 'parallax_block_styles' );

/**
 * [parallax_set_defaults description]
 */
function parallax_set_defaults() {
	remove_action('testimonial', array( CyberChimpsTestimonial::instance(), 'render_display' ));
	add_action('testimonial', 'parallax_testimonial_render_display');
}
add_action( 'init', 'parallax_set_defaults' );
