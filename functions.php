<?php
require_once locate_template('/lib/cleanup.php');        		//Cleanup
require_once locate_template('/lib/script.php');        		//Cleanup
require_once locate_template('/lib/breadcrumb.php');      		//Breadcrumb
require_once locate_template('/lib/widget.php');
require_once locate_template('/lib/wp_bootstrap_gallery.php');	//Register Custom Gallery:https://github.com/twittem/wp-bootstrap-gallery
require_once locate_template('/lib/custom-post-type.php');
require_once locate_template('/lib/wp-h5bp-htaccess.php');		//https://github.com/roots/wp-h5bp-htaccess
/*
 * Setup Theme Functions
 */
if (!function_exists('ItalyStrap_theme_setup')):
    function ItalyStrap_theme_setup() {

        //load_theme_textdomain('ItalyStrap', get_template_directory() . '/lang');

        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array( 'aside', 'image', 'gallery', 'link', 'quote', 'status', 'video', 'audio', 'chat' ));
		register_nav_menus(array('main-menu' => __('Main Menu', 'ItalyStrap')));
        // load custom walker menu class file
        require 'lib/wp_bootstrap_navwalker.php';
    }
endif;
add_action('after_setup_theme', 'ItalyStrap_theme_setup');


//definisco una variabile globale per la url del template e dell'immagine di default
$path = get_template_directory_uri();
$defaultimage = $path . '/img/ItalyStrap.jpg';

function italystrap_thumb_url()
{
	global $defaultimage;
	if ( has_post_thumbnail() ) {
	$post_thumbnail_id = get_post_thumbnail_id();
	$image_attributes = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
	echo $image_attributes[0]; 
	
	} else echo $defaultimage;
}

function italystrap_logo()
{
	global $defaultimage;
	return $defaultimage;
}

/* Aggiungi la favicon al tuo Blog
 * by Roberto Iacono di robertoiacono.it
 */
function ri_wp_favicon()
{
	global $path;
    echo '<link rel="shortcut icon" type="image/x-icon" href="' . $path . '/img/favicon.ico" />';
}
add_action('wp_head', 'ri_wp_favicon');


//Registro l'area widget classica nella sidebar
if (function_exists('register_sidebar'))
{
	register_sidebar( array(
		'name' => 'Sidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Box 1', 'ItalyStrap' ),
		'id' => 'footer-box-1',
		'description' => __( 'Footer box 1 widget area (Usa solo un widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="col-md-3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Box 2', 'ItalyStrap' ),
		'id' => 'footer-box-2',
		'description' => __( 'Footer box 2 widget area (Usa solo un widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="col-md-3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Box 3', 'ItalyStrap' ),
		'id' => 'footer-box-3',
		'description' => __( 'Footer box 3 widget area (Usa solo un widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="col-md-3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Box 4', 'ItalyStrap' ),
		'id' => 'footer-box-4',
		'description' => __( 'Footer box 4 widget area (Usa solo un widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="col-md-3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

//Definisco la lunghezza massima excerpt
function custom_excerpt_length( $length ) {
	if ( is_home() || is_front_page() ){
	return 30;}
	else{
	return 50;
	}
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 20 );

function new_excerpt_more( $more ) {
	if ( is_home() || is_front_page() ){
	return '';}
	else{
	return ' <a href="'. get_permalink() . '">... Continua a leggere</a>';
	}
}
add_filter('excerpt_more', 'new_excerpt_more');

/*
=================================================================*/
add_image_size( 'slide', 1140, 500, true);
add_image_size( 'article-thumb', 740, 370, true);
add_image_size( 'article-thumb-index', 253, 126, true);
add_image_size( 'full-width', 1130, 565, true);


add_action('wp_insert_post', 'italystrap_set_default_custom_fields');
 
function italystrap_set_default_custom_fields($post_id)
{
 if (isset($_GET['post_type']) && $_GET['post_type'] == 'prodotti' ) {
 
        add_post_meta($post_id, 'title_headline', '', true);
		add_post_meta($post_id, 'headline', '', true);
        add_post_meta($post_id, 'call_to_action', '', true);
 
    }
    return true;
}
//http://yoast.com/user-contact-fields-wordpress/
function italystrap_add_social_contactmethod( $contactmethods ) {
  // Add Avatar
  if ( !isset( $contactmethods['avatar'] ) )
	$contactmethods['avatar'] = 'Url avatar' ; 
  // Add Skype
  if ( !isset( $contactmethods['skype'] ) )
	$contactmethods['skype'] = 'Skype' ; 
  // Add Twitter
  if ( !isset( $contactmethods['twitter'] ) )
    $contactmethods['twitter'] = 'Twitter';
	// Add Google Profiles
  if ( !isset( $contactmethods['google_profile'] ) )
	$contactmethods['google_profile'] = 'Google Profile URL';
	// Add Google Page
  if ( !isset( $contactmethods['google_page'] ) )
	$contactmethods['google_page'] = 'Google Page URL';
	// Add Facebook Profile
  if ( !isset( $contactmethods['fb_profile'] ) )
	$contactmethods['fb_profile'] = 'Facebook Profile URL';
	// Add Facebook Page
  if ( !isset( $contactmethods['fb_page'] ) )
	$contactmethods['fb_page'] = 'Facebook Page URL';
	// Add LinkedIn
  if ( !isset( $contactmethods['linkedIn'] ) )
	$contactmethods['linkedIn'] = 'LinkedIn';
	// Add Pinterest
  if ( !isset( $contactmethods['pinterest'] ) )
	$contactmethods['pinterest'] = 'Pinterest';
	// Add Instagram
  //if ( !isset( $contactmethods['instagram'] ) )
	//$contactmethods['instagram'] = 'Instagram';

  // Remove Yahoo IM
  if ( isset( $contactmethods['yim'] ) )
    unset( $contactmethods['yim'] );
  // Remove jabber/Google Talk
  if ( isset( $contactmethods['jabber'] ) )	
	unset( $contactmethods['jabber'] );
  // Remove AIM
  if ( isset( $contactmethods['aim'] ) )		
	unset( $contactmethods['aim'] );

  return $contactmethods;
}
add_filter( 'user_contactmethods', 'italystrap_add_social_contactmethod', 10, 1 );

/*Defined at: wp-includes/comment-template.php, line 1153*/
function new_get_cancel_comment_reply_link($text = '') {
	if ( empty($text) )
		$text = __('Click here to cancel reply.');

	$style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
	$link = esc_html( remove_query_arg('replytocom') ) . '#respond';
	return apply_filters('new_cancel_comment_reply_link', '<a rel="nofollow" id="cancel-comment-reply-link" href="' . $link . '"' . $style . ' class="btn btn-danger btn-sm">' . $text . '</a>', $link, $text);
}
function new_cancel_comment_reply_link($text = '') {
	echo new_get_cancel_comment_reply_link($text);
}
/*Fine modifica wp-includes/comment-template.php*/


//Funzione per http://schema.org/Article: wordCount - timeRequired
function italystrap_ttr_wc(){

	ob_start();
    the_content();
    $content = ob_get_clean();
    $word_count = sizeof(explode(" ", $content));

	$words_per_minute = 150;
	
	// Get Estimated time
	$minutes = floor( $word_count / $words_per_minute);
	$seconds = floor( ($word_count / ($words_per_minute / 60) ) - ( $minutes * 60 ) );
	
	// If less than a minute
	if( $minutes < 1 ) {
		$estimated_time = 'PT1M';
	}
	
	// If more than a minute
	if( $minutes >= 1 ) {
		if( $seconds > 0 ) {
			$estimated_time = 'PT' . $minutes . 'M' . $seconds . 'S';
		} else {
			$estimated_time = 'PT' . $minutes.__( 'M', 'rc_prds' );
		}
	}
	
	$ttr_wc = '<meta  itemprop="wordCount" content="' . $word_count . '"/><br/><meta  itemprop="timeRequired" content="' . $estimated_time . '"/>';
	return $ttr_wc;
}


// function create_my_taxonomies() {

// register_taxonomy('NOMETASSONOMIA', 'page', array(
													// 'hierarchical' => false, 
													// 'label' => 'NOMETASSONOMIA',
													// 'query_var' => true,
													// 'rewrite' => true
													// ));
// }

// add_action('init', 'create_my_taxonomies', 0);

//funzione per estrapolare le url da gravatar
function estraiUrlsGravatar($url)  
{
	$url_pulito = substr($url,17,-56);
	return $url_pulito; 
}


//http://www.lanexa.net/2012/09/add-twitter-bootstrap-pagination-to-your-wordpress-theme/
function bootstrap_pagination($pages = '', $range = 2)
{
	$showitems = ($range * 2)+1;

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	{
	global $wp_query;
	$pages = $wp_query->max_num_pages;
	if(!$pages)
	{
	$pages = 1;
	}
	}

	if(1 != $pages)
	{
	echo "<div class='text-center'><ul class='pagination'>";
	if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
	if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

	for ($i=1; $i <= $pages; $i++)
	{
	if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	{
	echo ($paged == $i)? "<li class='active'><span class='current'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
	}
	}

	if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
	if ($paged < $pages-1 && $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
	echo "</ul></div>\n";
}
}
//Funzione per mostrare una description in open graph e twitter card
function italystrap_open_graph_desc(){
	global $post;
	$myposts = get_posts();
		foreach( $myposts as $post ) : setup_postdata( $post );
			$excerpt = substr( strip_tags( get_the_content() ), 4, 200);
		endforeach; wp_reset_query();
	//Codice per All in One Seo pack
	if ( function_exists('aioseop_load_modules')) {
		$post_aioseo_desc = get_post_meta($post->ID, '_aioseop_description', true);
		if($post_aioseo_desc){
		echo stripcslashes($post_aioseo_desc);
		}}
	//Codice per SEO by Yoast
	if ( function_exists('wpseo_get_value') ){
		echo wpseo_get_value('metadesc');
	}
	if ( !function_exists('wpseo_get_value') && !function_exists('aioseop_load_modules')){
		if ( !empty($post->post_excerpt) ){
			echo $post->post_excerpt;
		}else echo $excerpt;
	}
}
//http://gabrieleromanato.com/2012/02/wordpress-visualizzare-i-post-correlati-senza-plugin/
function show_related_posts() {
		global $post;

		$tags = wp_get_post_tags($post->ID);
		
		if($tags) {
		
  		echo '<h3>Potrebbero interessarti</h3>' . "\n";
  		$first_tag = $tags[0]->term_id;
  		$args = array(
    		'tag__in' => array($first_tag),
    		'post__not_in' => array($post->ID),
    		'showposts'=> 4,
    		'ignore_sticky_posts'=>1
   		);
  	$post_correlati = new WP_Query($args);
  		if( $post_correlati->have_posts() ) {
  		    echo '<div class="row" itemscope itemtype="http://schema.org/Article">' . "\n";
    		while ($post_correlati->have_posts()) : $post_correlati->the_post(); ?>
				<span class="col-md-3">
					<?php if ( has_post_thumbnail() ) {
							echo "<figure>";
							the_post_thumbnail( 'thumbnail', array('class' => 'img-thumbnail') );
							echo "</figure>";} ?>
							<meta  itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" itemprop="url"><span itemprop="name"><strong><?php the_title(); ?></strong></span></a>
				</span>
      	<?php
    		endwhile;
    		echo '</div>' . "\n";
    		 wp_reset_query();
  		}
  	  }
}

//Add img-polarod css class
function italystrap_add_image_class($class){
	$class .= ' img-thumbnail';
	return $class;
}
add_filter('get_image_tag_class','italystrap_add_image_class');
?>