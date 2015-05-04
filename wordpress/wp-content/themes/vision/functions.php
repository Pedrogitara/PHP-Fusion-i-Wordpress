<?php


/**********************************************************************************
/* Vision Setup *
**********************************************************************************/
function vision_setup() {

	/* Content Width */
	if ( ! isset( $content_width ) )
	$content_width = 745;
	
	/* Translation */
	load_theme_textdomain( 'vision', get_template_directory() . '/lang' );	

	
	add_theme_support( 'automatic-feed-links' );

	
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'image', 'quote', 'video', 'link', 'status', 'chat'
	) );


	add_theme_support('custom-background');

	

	/* Menu */
	register_nav_menus(array(
		'top-menu' => __( 'Top Menu', 'vision' ),
		'mobile-menu' => __('Mobile Top Menu', 'vision')
		));


	/* Thumbnail Size */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'image',745, 290, true );


	
}
add_action( 'after_setup_theme', 'vision_setup' );




/**********************************************************************************
/* Load Custom Fonts *
**********************************************************************************/
function vision_fonts_url() {
	$fonts_url = '';

	
	$oswald = _x( 'on', 'Source Sans Pro font: on or off', 'vision' );

	
	$bitter = _x( 'on', 'Bitter font: on or off', 'vision' );

	if ( 'off' !== $oswald || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $oswald )
			$font_families[] = 'Oswald:400,300,700:latin';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}





/**********************************************************************************
/* Load Jquery Files *
**********************************************************************************/
function vision_scripts_styles() {
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );


	/* Jquery Files */	

	wp_enqueue_script('vision-modernizr',get_template_directory_uri().'/js/modernizr.js',array(),'',true);

	wp_enqueue_script('vision-smoothscroll',get_template_directory_uri().'/js/SmoothScroll.js',array(),'',true);

	wp_enqueue_script('vision-slider',get_template_directory_uri().'/js/jquery.flexslider.js',array('jquery'),'',true);

	wp_enqueue_script('vision-custom',get_template_directory_uri().'/js/vision-custom.js',array('jquery'),'',true);

	/* Custom Font */
	wp_enqueue_style( 'vision-fonts', vision_fonts_url(), array(), null );

	/* Main Stylesheet */
	wp_enqueue_style( 'vision-style', get_stylesheet_uri(), array(), '' );

	
}
add_action( 'wp_enqueue_scripts', 'vision_scripts_styles' );






/**********************************************************************************
/* Title *
**********************************************************************************/
function vision_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;
	
	$title .= get_bloginfo( 'name' );
	
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'vision' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'vision_wp_title', 10, 2 );







/**********************************************************************************
/* Excerpt *
**********************************************************************************/
function vision_excerpt_length( $length ) {
	return 110;
}
add_filter( 'excerpt_length', 'vision_excerpt_length', 999 );


function new_excerpt_more( $more ) {
	return ' [...]';
}
add_filter('excerpt_more', 'new_excerpt_more');




/**********************************************************************************
/* Dynamic Widgets *
**********************************************************************************/
function vision_widgets(){

	/* Dynamic Sidebar */
register_sidebar(array(
	'id'          => 'sidebar',
    'name'        => __( 'Right Sidebar', 'vision' ),
    'description' => __( 'This sidebar is located right side.', 'vision' ),
    'before_widget' => '<div class="widget">',
	'after_widget'  => '</div>',
	'before_title'  => '<h3>',
	'after_title'   => '</h3>',
	));



/* Footer Widget 1 */
register_sidebar(array(
	'id'          => 'footer-1',
    'name'        => __( 'Left Footer Widget', 'vision' ),
    'description' => __( 'This widget is located left side.', 'vision' ),
    'before_widget' => '<div class="footer-widget">',
	'after_widget'  => '</div>',
	'before_title'  => '<h4>',
	'after_title'   => '</h4>',
	));




/* Footer Widget 2 */
register_sidebar(array(
	'id'          => 'footer-2',
    'name'        => __( 'Middle Footer Widget', 'vision' ),
    'description' => __( 'This widget is located left side.', 'vision' ),
    'before_widget' => '<div class="footer-widget">',
	'after_widget'  => '</div>',
	'before_title'  => '<h4>',
	'after_title'   => '</h4>',
	));



/* Footer Widget 3 */
register_sidebar(array(
	'id'          => 'footer-3',
    'name'        => __( 'Right Footer Widget', 'vision' ),
    'description' => __( 'This widget is located left side.', 'vision' ),
    'before_widget' => '<div class="footer-widget">',
	'after_widget'  => '</div>',
	'before_title'  => '<h4>',
	'after_title'   => '</h4>',
	));

}
add_action('widgets_init', 'vision_widgets');





/**********************************************************************************
/* Paging *
**********************************************************************************/
require_once(get_template_directory().'/functions/pagination.php');



/***********************************************************************************************/
/* Custom Comment Form */
/***********************************************************************************************/
function vision_custom_comment_form($defaults) {
	
	
	$defaults['comment_notes_before'] = '';	
	$defaults['id_form'] = 'comment-form';
	$defaults['comment_field'] = '<p><textarea name="comment" id="comment" class="form-control input-sm" rows="6"></textarea></p>';

	return $defaults;
}

add_filter('comment_form_defaults', 'vision_custom_comment_form');

function vision_custom_comment_fields() {
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$aria_req = ($req ? " aria-required='true'" : '');
	
	$fields = array(
		'author' => '<p>' . 
						'<input id="author" name="author" type="text" class="form-control input-sm" placeholder="Name ( required )" value="' . esc_attr($commenter['comment_author']) . '" ' . $aria_req . ' />' .
						
		            '</p>',
		'email' => '<p>' . 
						'<input id="email" name="email" type="text" class="form-control input-sm" placeholder="Email ( required )" value="' . esc_attr($commenter['comment_author_email']) . '" ' . $aria_req . ' />'  .
		            '</p>',
		'url' => '<p>' . 
						'<input id="url" name="url" type="text" class="form-control input-sm" placeholder="Website" value="' . esc_attr($commenter['comment_author_url']) . '" />'  .
		            '</p>'
	);

	return $fields;
}

add_filter('comment_form_default_fields', 'vision_custom_comment_fields');


/************************************************************************
// Advanced Custom Plugin
*************************************************************************/
define( 'ACF_LITE' , true );



if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_slider-options',
		'title' => 'Slider Options',
		'fields' => array (
			array (
				'key' => 'field_536c7915da76c',
				'label' => 'Featured Slider',
				'name' => 'featured_slider',
				'type' => 'true_false',
				'instructions' => 'Enable Featured Slider',
				'message' => 'Enable Slider ?',
				'default_value' => 0,
			),
			array (
				'key' => 'field_536c7a626da29',
				'label' => 'Slider Image',
				'name' => 'slider_image',
				'type' => 'image',
				'instructions' => 'Ideal image\'s height should be 400px.',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}




/************************************************************************
/* TGM Plugin *
*************************************************************************/
require_once(get_template_directory().'/functions/tgm-plugin/tgm-activation.php');

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin from a private repo in your theme.
        array(
            'name'               => 'Advanced Custom Fields', // The plugin name.
            'slug'               => 'advanced-custom-fields', // The plugin slug (typically the folder name).
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'external_url'       => 'http://wordpress.org/plugins/advanced-custom-fields', // If set, overrides default API URL and points to an external URL.
        )

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin for slider images: %1$s.', 'This theme requires the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin for slider: %1$s.', 'This theme recommends the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tgmpa' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'tgmpa' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'tgmpa' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}