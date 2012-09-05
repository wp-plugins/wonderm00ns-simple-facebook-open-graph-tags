<?php
/**
 * @package Wonderm00n's Simple Facebook Open Graph Meta Tags
 * @version 0.2.2
 */
/*
Plugin Name: Wonderm00n's Simple Facebook Open Graph Meta Tags
Plugin URI: http://blog.wonderm00n.com/2011/10/14/wordpress-plugin-simple-facebook-open-graph-tags/
Description: This plugin inserts Facebook Open Graph Tags into your Wordpress Blog/Website for better Facebook sharing
Author: Marco Almeida (Wonderm00n)
Version: 0.2.2
Author URI: http://wonderm00n.com
*/

function wonderm00n_open_graph() {
	
	//This should be set by options on wp-admin
	$fb_app_id_show=get_option('wonderm00n_open_graph_fb_app_id_show');
	$fb_app_id=get_option('wonderm00n_open_graph_fb_app_id');
	$fb_admin_id_show=get_option('wonderm00n_open_graph_fb_admin_id_show');
	$fb_admin_id=get_option('wonderm00n_open_graph_fb_admin_id');
	$fb_locale_show=get_option('wonderm00n_open_graph_fb_locale_show');
	$fb_locale = get_option('wonderm00n_open_graph_fb_locale');
	$fb_sitename_show=get_option('wonderm00n_open_graph_fb_sitename_show');
	$fb_title_show=get_option('wonderm00n_open_graph_fb_title_show');
	$fb_url_show=get_option('wonderm00n_open_graph_fb_url_show');
	$fb_url_add_trailing=get_option('wonderm00n_open_graph_fb_url_add_trailing');
	$fb_type_show=get_option('wonderm00n_open_graph_fb_type_show');
	$fb_type_homepage=get_option('wonderm00n_open_graph_fb_type_homepage');
	$fb_desc_show=get_option('wonderm00n_open_graph_fb_desc_show');
	$fb_desc_chars=intval(get_option('wonderm00n_open_graph_fb_desc_chars'));
	$fb_desc_homepage = get_option('wonderm00n_open_graph_fb_desc_homepage');
	$fb_desc_homepage_customtext = get_option('wonderm00n_open_graph_fb_desc_homepage_customtext');
	$fb_image_show=get_option('wonderm00n_open_graph_fb_image_show');
	$fb_image=get_option('wonderm00n_open_graph_fb_image');
	$fb_image_use_featured=get_option('wonderm00n_open_graph_fb_image_use_featured');
	$fb_image_use_content=get_option('wonderm00n_open_graph_fb_image_use_content');
	$fb_image_use_media=get_option('wonderm00n_open_graph_fb_image_use_media');
	$fb_image_use_default=get_option('wonderm00n_open_graph_fb_image_use_default');
	
	$fb_type='article';
	if (is_singular()) {
		//It's a Post or a Page or an attachment page
		global $post;
		$fb_title=esc_attr(strip_tags(stripslashes($post->post_title)));
		$fb_url=get_permalink();
		if (trim($post->post_excerpt)!='') {
			//If there's an excerpt that's waht we'll use
			$fb_desc=trim($post->post_excerpt);
		} else {
			//If not we grab it from the content
			$fb_desc=trim($post->post_content);
		}
		$fb_desc=(intval($fb_desc_chars)>0 ? substr(esc_attr(strip_tags(strip_shortcodes(stripslashes($fb_desc)))),0,$fb_desc_chars) : esc_attr(strip_tags(strip_shortcodes(stripslashes($fb_desc)))));
		if (intval($fb_image_show)==1) {
			$fb_image=wonderm00n_open_graph_post_image($fb_image_use_featured, $fb_image_use_content, $fb_image_use_media, $fb_image_use_default, $fb_image);
		}
	} else {
		global $wp_query;
		//Other pages - Defaults
		$fb_title=esc_attr(strip_tags(stripslashes(get_bloginfo('name'))));
		$fb_url=get_option('siteurl').(intval($fb_url_add_trailing)==1 ? '/' : '');
		switch(trim($fb_desc_homepage)) {
			case 'custom':
				$fb_desc=esc_attr(strip_tags(stripslashes($fb_desc_homepage_customtext)));
				break;
			default:
				$fb_desc=esc_attr(strip_tags(stripslashes(get_bloginfo('description'))));
				break;
		}
		
		if (is_category()) {
			$fb_title=esc_attr(strip_tags(stripslashes(single_cat_title('', false))));
			$term=$wp_query->get_queried_object();
			$fb_url=get_term_link($term, $term->taxonomy);
			$cat_desc=trim(esc_attr(strip_tags(stripslashes(category_description()))));
			if (trim($cat_desc)!='') $fb_desc=$cat_desc;
		} else {
			if (is_tag()) {
				$fb_title=esc_attr(strip_tags(stripslashes(single_tag_title('', false))));
				$term=$wp_query->get_queried_object();
				$fb_url=get_term_link($term, $term->taxonomy);
				$tag_desc=trim(esc_attr(strip_tags(stripslashes(tag_description()))));
				if (trim($tag_desc)!='') $fb_desc=$tag_desc;
			} else {
				if (is_tax()) {
					$fb_title=esc_attr(strip_tags(stripslashes(single_term_title('', false))));
					$term=$wp_query->get_queried_object();
					$fb_url=get_term_link($term, $term->taxonomy);
				} else {
					if (is_search()) {
						$fb_title=esc_attr(strip_tags(stripslashes(__('Search for').' "'.get_search_query().'"')));
						$fb_url=get_search_link();
					} else {
						if (is_author()) {
							$fb_title=esc_attr(strip_tags(stripslashes(get_the_author_meta('display_name', get_query_var('author')))));
							$fb_url=get_author_posts_url(get_query_var('author'), get_query_var('author_name'));
						} else {
							if (is_archive()) {
								if (is_day()) {
									$fb_title=esc_attr(strip_tags(stripslashes(get_query_var('day').' '.single_month_title(' ', false).' '.__('Archives'))));
									$fb_url=get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day'));
								} else {
									if (is_month()) {
										$fb_title=esc_attr(strip_tags(stripslashes(single_month_title(' ', false).' '.__('Archives'))));
										$fb_url=get_month_link(get_query_var('year'), get_query_var('monthnum'));
									} else {
										if (is_year()) {
											$fb_title=esc_attr(strip_tags(stripslashes(get_query_var('year').' '.__('Archives'))));
											$fb_url=get_year_link(get_query_var('year'));
										}
									}
								}
							} else {
								if (is_front_page()) {
									$fb_type=trim($fb_type_homepage=='' ? 'website' : $fb_type_homepage);
								} else {
									//Others... Defaults already set up there
								}
							}
						}
					}
				}
			}
		}
	}
	//If no description let's just add the title
	if (trim($fb_desc)=='') $fb_desc=$fb_title;
	
	$html.='<!-- START - Wonderm00n\'s Simple Facebook Open Graph Tags -->
';
	if (intval($fb_app_id_show)==1 && trim($fb_app_id)!='') $html.='<meta property="fb:app_id" content="'.trim($fb_app_id).'" />
';
	if (intval($fb_admin_id_show)==1 && trim($fb_admin_id)!='') $html.='<meta property="fb:admins" content="'.trim($fb_admin_id).'" />
';
	if (intval($fb_locale_show)==1) $html.='<meta property="og:locale" content="'.trim(trim($fb_locale)!='' ? trim($fb_locale) : trim(get_locale())).'" />
';
	if (intval($fb_sitename_show)==1) $html.='<meta property="og:site_name" content="'.get_bloginfo('name').'" />
';
	if (intval($fb_title_show)==1) $html.='<meta property="og:title" content="'.trim($fb_title).'" />
';
	if (intval($fb_url_show)==1) $html.='<meta property="og:url" content="'.trim(esc_attr($fb_url)).'" />
';
	if (intval($fb_type_show)==1) $html.='<meta property="og:type" content="'.trim(esc_attr($fb_type)).'" />
';
	if (intval($fb_desc_show)==1) $html.='<meta property="og:description" content="'.trim($fb_desc).'" />
';
	if(intval($fb_image_show)==1 && trim($fb_image)!='') $html.='<meta property="og:image" content="'.trim(esc_attr($fb_image)).'" />
';
	$html.='<!-- END - Wonderm00n\'s Simple Facebook Open Graph Tags -->
';
	echo $html;
}
add_action('wp_head', 'wonderm00n_open_graph', 9999);

function wonderm00n_open_graph_add_opengraph_namespace( $output ) {
	if (stristr($output,'xmlns:og')) {
		//Already there
	} else {
		//Let's add it
		$output=$output . ' xmlns:og="http://ogp.me/ns#"';
	}
	if (stristr($output,'xmlns:fb')) {
		//Already there
	} else {
		//Let's add it
		$output=$output . ' xmlns:fb="http://ogp.me/ns/fb#"';
	}
	return $output;
}
//We want to be last to add the namespace because some other plugin may already added it ;-)
add_filter('language_attributes', 'wonderm00n_open_graph_add_opengraph_namespace',9999);

//Add images also to RSS feed. Most code from WP RSS Images by Alain Gonzalez
function wonderm00n_open_graph_images_on_feed($comments) {
	$fb_image_rss=get_option('wonderm00n_open_graph_fb_image_rss');
	if (intval($fb_image_rss)==1) {
		if (!$comments) {
			add_action('rss2_ns', 'wonderm00n_open_graph_images_on_feed_yahoo_media_tag');
			add_action('rss_item', 'wonderm00n_open_graph_images_on_feed_image');
			add_action('rss2_item', 'wonderm00n_open_graph_images_on_feed_image');
		}
	}
}
function wonderm00n_open_graph_images_on_feed_yahoo_media_tag() {
	echo 'xmlns:media="http://search.yahoo.com/mrss/"';
}
function wonderm00n_open_graph_images_on_feed_image() {
	$fb_image=get_option('wonderm00n_open_graph_fb_image');
	$fb_image_use_featured=get_option('wonderm00n_open_graph_fb_image_use_featured');
	$fb_image_use_content=get_option('wonderm00n_open_graph_fb_image_use_content');
	$fb_image_use_media=get_option('wonderm00n_open_graph_fb_image_use_media');
	$fb_image_use_default=get_option('wonderm00n_open_graph_fb_image_use_default');
	$fb_image = wonderm00n_open_graph_post_image($fb_image_use_featured, $fb_image_use_content, $fb_image_use_media, $fb_image_use_default, $fb_image);
	if ($fb_image!='') {
		$uploads = wp_upload_dir();
		$url = parse_url($fb_image);
		$path = $uploads['basedir'] . preg_replace( '/.*uploads(.*)/', '${1}', $url['path'] );
		//echo $path;
		if (file_exists($path)) {
			$filesize=filesize($path);
			$url=$path;
		} else {		
			$header=get_headers($fb_image, 1);					   
			$filesize=$header['Content-Length'];	
			$url=$fb_image;				
		}
		list($width, $height, $type, $attr) = getimagesize($url);
		echo '<enclosure url="' . $fb_image . '" length="' . $filesize . '" type="'.image_type_to_mime_type($type).'" />';
		echo '<media:content url="'.$fb_image.'" width="'.$width.'" height="'.$height.'" medium="image" type="'.image_type_to_mime_type($type).'" />';
	}
}
add_action("do_feed_rss","wonderm00n_open_graph_images_on_feed",5,1);
add_action("do_feed_rss2","wonderm00n_open_graph_images_on_feed",5,1);

//Post image
function wonderm00n_open_graph_post_image($fb_image_use_featured=1, $fb_image_use_content=1, $fb_image_use_media=1, $fb_image_use_default=1, $default_image='') {
	global $post;
	$thumbdone=false;
	$fb_image='';
	//Featured image
	if (function_exists('get_post_thumbnail_id')) {
		if (intval($fb_image_use_featured)==1) {
			if ($id_attachment=get_post_thumbnail_id($post->ID)) {
				//There's a featured/thumbnail image for this post
				$fb_image=wp_get_attachment_url($id_attachment, false);
				$thumbdone=true;
				//echo 'IMG FEAT';
			}
		}
	}
	//From post/page content
	if (!$thumbdone) {
		if (intval($fb_image_use_content)==1) {
			$imgreg = '/<img .*src=["\']([^ ^"^\']*)["\']/';
			preg_match_all($imgreg, trim($post->post_content), $matches);
			$image=$matches[1][0];
			if ($image) {
				//There's an image on the content
				$pos = strpos($image, site_url());
				if ($pos === false) {
					if (stristr($image, 'http://') || stristr($image, 'https://')) {
						//URL Completo fora do site
						$fb_image=$image;
					} else {
						$fb_image=site_url().$image;
					}
				} else {
					//URL Completo no site
					$fb_image=$image;
				}
				$thumbdone=true;
				//echo 'IMG CONTENT';
			}
		}
	}
	//From media gallery
	if (!$thumbdone) {
		if (intval($fb_image_use_media)==1) {
			$images = get_posts(array('post_type' => 'attachment','numberposts' => 1,'post_status' => null,'order' => 'ASC','orderby' => 'menu_order','post_mime_type' => 'image','post_parent' => $post->ID));
			if ($images) {
				$fb_image=wp_get_attachment_url($images[0]->ID, false);
				$thumbdone=true;
				//echo 'IMG MEDIA';
			}
		}
	}
	//From default
	if (!$thumbdone) {
		if (intval($fb_image_use_default)==1) {
			//Well... We sure did try. We'll just keep the default one!
			$fb_image=$default_image;
			//echo 'IMG DEFAULT';
		} else {
			//User chose not to use default on pages/posts
			$fb_image='';
			//echo 'IMG NO IMG';
		}
	}
	return $fb_image;
}

//Admin
if ( is_admin() ) {
	add_action('admin_menu', 'wonderm00n_open_graph_add_options');
	
	add_action('activate_wonderm00n-open-graph/wonderm00n-open-graph.php', 'wonderm00n_open_graph_activate');
	
	function wonderm00n_open_graph_add_options() {
		if(function_exists('add_options_page')){
			add_options_page('Wonderm00n\'s Open Graph', 'Wonderm00n\'s Open Graph', 'manage_options', basename(__FILE__), 'wonderm00n_open_graph_admin');
		}
	}
	
	function wonderm00n_open_graph_activate() {
		update_option("wonderm00n_open_graph_activated", 1);
		update_option("wonderm00n_open_graph_fb_admin_id_show", 0);
		update_option("wonderm00n_open_graph_fb_app_id_show", 0);
		update_option("wonderm00n_open_graph_fb_locale_show", 1);
		update_option("wonderm00n_open_graph_fb_sitename_show", 1);
		update_option("wonderm00n_open_graph_fb_title_show", 1);
		update_option("wonderm00n_open_graph_fb_url_show", 1);
		update_option("wonderm00n_open_graph_fb_type_show", 1);
		update_option("wonderm00n_open_graph_fb_desc_show", 1);
		update_option("wonderm00n_open_graph_fb_desc_chars", 300);
		update_option("wonderm00n_open_graph_fb_image_show", 1);
		update_option("wonderm00n_open_graph_fb_image_rss", 0);
		update_option("wonderm00n_open_graph_fb_image_use_featured", 1);
		update_option("wonderm00n_open_graph_fb_image_use_content", 1);
		update_option("wonderm00n_open_graph_fb_image_use_media", 1);
		update_option("wonderm00n_open_graph_fb_image_use_default", 1);
	}
	
	function wonderm00n_open_graph_settings_link( $links, $file ) {
		if( $file == 'wonderm00ns-simple-facebook-open-graph-tags/wonderm00n-open-graph.php' && function_exists( "admin_url" ) ) {
			$settings_link = '<a href="' . admin_url( 'options-general.php?page=wonderm00n-open-graph.php' ) . '">' . __('Settings') . '</a>';
			array_push( $links, $settings_link ); // after other links
		}
		return $links;
	}
	add_filter('plugin_row_meta', 'wonderm00n_open_graph_settings_link', 9, 2 );
	
	
	function wonderm00n_open_graph_admin() {
		include_once 'includes/settings-page.php';
	}
	
	function wonderm00n_open_graph_scripts() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('jquery');
	}
	function wonderm00n_open_graph_styles() {
		wp_enqueue_style('thickbox');
	}
	add_action('admin_print_scripts', 'wonderm00n_open_graph_scripts');
	add_action('admin_print_styles', 'wonderm00n_open_graph_styles');
	
	if ( isset($_POST['action']) ) {
		if (trim($_POST['action'])=='save') {
			update_option('wonderm00n_open_graph_fb_app_id_show', intval($_POST['fb_app_id_show']));
			update_option('wonderm00n_open_graph_fb_app_id', trim($_POST['fb_app_id']));
			update_option('wonderm00n_open_graph_fb_admin_id_show', intval($_POST['fb_admin_id_show']));
			update_option('wonderm00n_open_graph_fb_admin_id', trim($_POST['fb_admin_id']));
			update_option('wonderm00n_open_graph_fb_locale_show', intval($_POST['fb_locale_show']));
			update_option('wonderm00n_open_graph_fb_locale', trim($_POST['fb_locale']));
			update_option('wonderm00n_open_graph_fb_sitename_show', intval($_POST['fb_sitename_show']));
			update_option('wonderm00n_open_graph_fb_title_show', intval($_POST['fb_title_show']));
			update_option('wonderm00n_open_graph_fb_url_show', intval($_POST['fb_url_show']));
			update_option('wonderm00n_open_graph_fb_url_add_trailing', intval($_POST['fb_url_add_trailing']));
			update_option('wonderm00n_open_graph_fb_type_show', intval($_POST['fb_type_show']));
			update_option('wonderm00n_open_graph_fb_type_homepage', trim($_POST['fb_type_homepage']));
			update_option('wonderm00n_open_graph_fb_desc_show', intval($_POST['fb_desc_show']));
			update_option('wonderm00n_open_graph_fb_desc_chars', intval($_POST['fb_desc_chars']));
			update_option('wonderm00n_open_graph_fb_desc_homepage', trim($_POST['fb_desc_homepage']));
			update_option('wonderm00n_open_graph_fb_desc_homepage_customtext', trim($_POST['fb_desc_homepage_customtext']));
			update_option('wonderm00n_open_graph_fb_image_show', intval($_POST['fb_image_show']));
			update_option('wonderm00n_open_graph_fb_image', trim($_POST['fb_image']));
			update_option('wonderm00n_open_graph_fb_image_rss', intval($_POST['fb_image_rss']));
			update_option('wonderm00n_open_graph_fb_image_use_featured', intval($_POST['fb_image_use_featured']));
			update_option('wonderm00n_open_graph_fb_image_use_content', intval($_POST['fb_image_use_content']));
			update_option('wonderm00n_open_graph_fb_image_use_media', intval($_POST['fb_image_use_media']));
			update_option('wonderm00n_open_graph_fb_image_use_default', intval($_POST['fb_image_use_default']));
		}
	}
}



	
//Upgrade 2012-01-02 (locale)
if (trim(get_option('wonderm00n_open_graph_fb_locale_show'))=='') {
	update_option("wonderm00n_open_graph_fb_locale_show", 1);
}
//Upgrade 2012-01-02 (images)
if (
	trim(get_option('wonderm00n_open_graph_fb_image_use_featured'))==''
	||
	trim(get_option('wonderm00n_open_graph_fb_image_use_content'))==''
	||
	trim(get_option('wonderm00n_open_graph_fb_image_use_media'))==''
	||
	trim(get_option('wonderm00n_open_graph_fb_image_use_default'))==''
	) {
	update_option("wonderm00n_open_graph_fb_image_use_featured", 1);
	update_option("wonderm00n_open_graph_fb_image_use_content", 1);
	update_option("wonderm00n_open_graph_fb_image_use_media", 1);
	update_option("wonderm00n_open_graph_fb_image_use_default", 1);
}

?>