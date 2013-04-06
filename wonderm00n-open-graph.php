<?php
/**
 * @package Wonderm00n's Simple Facebook Open Graph Meta Tags
 * @version 0.5.4
 */
/*
Plugin Name: Wonderm00n's Simple Facebook Open Graph Meta Tags
Plugin URI: http://blog.wonderm00n.com/2011/10/14/wordpress-plugin-simple-facebook-open-graph-tags/
Description: This plugin inserts Facebook Open Graph Tags into your WordPress Blog/Website for more effective Facebook sharing results. It also allows you to add the Meta Description tag and Schema.org Name, Description and Image tags for more effective Google+ sharing results. You can also choose to insert the "enclosure" and "media:content" tags to the RSS feeds, so that apps like RSS Graffiti and twitterfeed post the image to Facebook correctly.
Author: Marco Almeida (Wonderm00n)
Version: 0.5.4
Author URI: http://wonderm00n.com
*/

$wonderm00n_open_graph_plugin_version='0.5.4';
$wonderm00n_open_graph_plugin_settings=array(
		'fb_app_id_show',
		'fb_app_id',
		'fb_admin_id_show',
		'fb_admin_id',
		'fb_locale_show',
		'fb_locale',
		'fb_sitename_show',
		'fb_title_show',
		'fb_title_show_schema',
		'fb_url_show',
		'fb_url_canonical',
		'fb_url_add_trailing',
		'fb_type_show',
		'fb_type_homepage',
		'fb_desc_show',
		'fb_desc_show_meta',
		'fb_desc_show_schema',
		'fb_desc_chars',
		'fb_desc_homepage',
		'fb_desc_homepage_customtext',
		'fb_image_show',
		'fb_image_show_schema',
		'fb_image',
		'fb_image_rss',
		'fb_image_use_featured',
		'fb_image_use_content',
		'fb_image_use_media',
		'fb_image_use_default',
		'fb_show_subheading',
		'fb_show_businessdirectoryplugin'
);

//We have to remove canonical NOW because the plugin runs too late
if (get_option('wonderm00n_open_graph_fb_url_show')==1) {
	if (get_option('wonderm00n_open_graph_fb_url_canonical')==1) {
		remove_action('wp_head', 'rel_canonical');
	}
}

function wonderm00n_open_graph() {
	global $wonderm00n_open_graph_plugin_settings, $wonderm00n_open_graph_plugin_version;
	
	//Get options
	foreach($wonderm00n_open_graph_plugin_settings as $key) {
		$$key=get_option('wonderm00n_open_graph_'.$key);
	}
	
	//Also set Title Tag?
	$fb_set_title_tag=0;

	$fb_type='article';
	if (is_singular()) {
		//It's a Post or a Page or an attachment page - It acan also be the homepage if it's set as a page
		global $post;
		$fb_title=esc_attr(strip_tags(stripslashes($post->post_title)));
		//All In One SEO - To Do
		/*if ($fb_show_allinoneseo==1) {
			@include_once(ABSPATH . 'wp-admin/includes/plugin.php');
			if (is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php')) {
				//Code still missing here
			}
		}*/
		//Platinum SEO - To Do
		/*if ($fb_show_platinumseo==1) {
			@include_once(ABSPATH . 'wp-admin/includes/plugin.php');
			if (is_plugin_active('platinum-seo-pack/platinum_seo_pack.php')) {
				//Code still missing here
			}
		}*/
		//SubHeading
		if ($fb_show_subheading==1) {
			@include_once(ABSPATH . 'wp-admin/includes/plugin.php');
			if (is_plugin_active('subheading/index.php')) {
				if (function_exists('get_the_subheading')) {
					$fb_title.=' - '.get_the_subheading();
				}
			}
		}
		$fb_url=get_permalink();
		if (trim($post->post_excerpt)!='') {
			//If there's an excerpt that's what we'll use
			$fb_desc=trim($post->post_excerpt);
		} else {
			//If not we grab it from the content
			$fb_desc=trim($post->post_content);
		}
		$fb_desc=(intval($fb_desc_chars)>0 ? substr(esc_attr(strip_tags(strip_shortcodes(stripslashes($fb_desc)))),0,$fb_desc_chars) : esc_attr(strip_tags(strip_shortcodes(stripslashes($fb_desc)))));
		if (intval($fb_image_show)==1) {
			$fb_image=wonderm00n_open_graph_post_image($fb_image_use_featured, $fb_image_use_content, $fb_image_use_media, $fb_image_use_default, $fb_image);
		}
		//Business Directory Plugin
		if ($fb_show_businessdirectoryplugin==1) {
			@include_once(ABSPATH . 'wp-admin/includes/plugin.php');
			if (is_plugin_active('business-directory-plugin/wpbusdirman.php')) {
				global $wpbdp;
				//$bdpaction = _wpbdp_current_action();
				$bdpaction=$wpbdp->controller->get_current_action();
				switch($bdpaction) {
					case 'showlisting':
						//Listing
						$listing_id = get_query_var('listing') ? wpbdp_get_post_by_slug(get_query_var('listing'))->ID : wpbdp_getv($_GET, 'id', get_query_var('id'));
						$bdppost=get_post($listing_id);
						$fb_title=esc_attr(strip_tags(stripslashes($bdppost->post_title))).' - '.$fb_title;
						$fb_set_title_tag=1;
						$fb_url=get_permalink($listing_id);
						if (trim($bdppost->post_excerpt)!='') {
							//If there's an excerpt that's what we'll use
							$fb_desc=trim($bdppost->post_excerpt);
						} else {
							//If not we grab it from the content
							$fb_desc=trim($bdppost->post_content);
						}
						$fb_desc=(intval($fb_desc_chars)>0 ? substr(esc_attr(strip_tags(strip_shortcodes(stripslashes($fb_desc)))),0,$fb_desc_chars) : esc_attr(strip_tags(strip_shortcodes(stripslashes($fb_desc)))));
						if (intval($fb_image_show)==1) {
							$thumbdone=false;
							if (intval($fb_image_use_featured)==1) {
								//Featured
								if ($id_attachment=get_post_thumbnail_id($bdppost->ID)) {
									//There's a featured/thumbnail image for this listing
									$fb_image=wp_get_attachment_url($id_attachment, false);
									$thumbdone=true;
								}
							}
							if (!$thumbdone) {
								//Main image loaded
								if ($thumbnail_id = wpbdp_listings_api()->get_thumbnail_id($bdppost->ID)) {
									$fb_image=wp_get_attachment_url($thumbnail_id, false);
								}
							}
						}
						break;
					case 'browsecategory':
							//Categories
							$term = get_term_by('slug', get_query_var('category'), wpbdp_categories_taxonomy());
							$fb_title=esc_attr(strip_tags(stripslashes($term->name))).' - '.$fb_title;
							$fb_set_title_tag=1;
							$fb_url=get_term_link($term);
							if (trim($term->description)!='') {
								$fb_desc=trim($term->description);
							}
						break;
					case 'main':
						//Main page
						//No changes
						break;
					default:
						//No changes
						break;
				}
			}
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
	
	$html='
<!-- START - Wonderm00n\'s Simple Facebook Open Graph Tags '.$wonderm00n_open_graph_plugin_version.' -->
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
	if (intval($fb_set_title_tag)==1) {
		//Does nothing so far. We try to create the <title> tag but it's too late now
	}
	if (intval($fb_title_show_schema)==1) $html.='<meta itemprop="name" content="'.trim($fb_title).'" />
';
	if (intval($fb_url_show)==1) {
		$html.='<meta property="og:url" content="'.trim(esc_attr($fb_url)).'" />
';
		if (intval($fb_url_canonical)==1) {
			//remove_action('wp_head', 'rel_canonical'); //This is already done
			$html.='<link rel="canonical" href="'.trim(esc_attr($fb_url)).'" />
';
		}
	}
	if (intval($fb_type_show)==1) $html.='<meta property="og:type" content="'.trim(esc_attr($fb_type)).'" />
';
	if (intval($fb_desc_show)==1) $html.='<meta property="og:description" content="'.trim($fb_desc).'" />
';
	if (intval($fb_desc_show_meta)==1) $html.='<meta name="description" content="'.trim($fb_desc).'" />
';
	if (intval($fb_desc_show_schema)==1) $html.='<meta itemprop="description" content="'.trim($fb_desc).'" />
';
	if(intval($fb_image_show)==1 && trim($fb_image)!='') $html.='<meta property="og:image" content="'.trim(esc_attr($fb_image)).'" />
';
	if(intval($fb_image_show_schema)==1 && trim($fb_image)!='') $html.='<meta itemprop="image" content="'.trim(esc_attr($fb_image)).'" />
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
			}
		}
	}
	//From post/page content
	if (!$thumbdone) {
		if (intval($fb_image_use_content)==1) {
			$imgreg = '/<img .*src=["\']([^ ^"^\']*)["\']/';
			preg_match_all($imgreg, trim($post->post_content), $matches);
			if (isset($matches[1][0])) {
				//There's an image on the content
				$image=$matches[1][0];
				$pos = strpos($image, site_url());
				if ($pos === false) {
					if (stristr($image, 'http://') || stristr($image, 'https://')) {
						//Complete URL - offsite
						$fb_image=$image;
					} else {
						$fb_image=site_url().$image;
					}
				} else {
					//Complete URL - onsite
					$fb_image=$image;
				}
				$thumbdone=true;
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
			}
		}
	}
	//From default
	if (!$thumbdone) {
		if (intval($fb_image_use_default)==1) {
			//Well... We sure did try. We'll just keep the default one!
			$fb_image=$default_image;
		} else {
			//User chose not to use default on pages/posts
			$fb_image='';
		}
	}
	return $fb_image;
}

//Admin
if ( is_admin() ) {
	
	add_action('admin_menu', 'wonderm00n_open_graph_add_options');
	
	register_activation_hook(__FILE__, 'wonderm00n_open_graph_activate');
	
	function wonderm00n_open_graph_add_options() {
		if(function_exists('add_options_page')){
			add_options_page('Wonderm00n\'s Open Graph', 'Wonderm00n\'s Open Graph', 'manage_options', basename(__FILE__), 'wonderm00n_open_graph_admin');
		}
	}
	
	function wonderm00n_open_graph_default_values() {
		return array(
			'fb_locale_show' => 1,
			'fb_sitename_show' => 1,
			'fb_title_show' => 1,
			'fb_url_show' => 1,
			'fb_url_canonical' => 1,
			'fb_type_show' => 1,
			'fb_desc_show' => 1,
			'fb_desc_chars' => 300,
			'fb_image_show' => 1,
			'fb_image_use_featured' => 1,
			'fb_image_use_content' => 1,
			'fb_image_use_media' => 1,
			'fb_image_use_default' => 1,
			'fb_keep_data_uninstall' => 1
		);
	}
	
	function wonderm00n_open_graph_activate() {
		// Let's not!
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
		global $wonderm00n_open_graph_plugin_settings, $wonderm00n_open_graph_plugin_version;
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
}


//Uninstall stuff
register_uninstall_hook(__FILE__, 'wonderm00n_open_graph_uninstall'); //NOT WORKING! WHY?
function wonderm00n_open_graph_uninstall() {
	//NOT WORKING! WHY?
	global $wonderm00n_open_graph_plugin_settings;
	//Remove data
	foreach($wonderm00n_open_graph_plugin_settings as $key) {
		delete_option('wonderm00n_open_graph_'.$key);
	}
	delete_option('wonderm00n_open_graph_activated');
}

//To avoid notices when updating options on settings-page.php
//Hey @flynsarmy you are here, see?
function wonderm00n_open_graph_post($var, $default='') {
	return isset($var) ? $var : $default;
}

?>