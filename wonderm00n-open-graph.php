<?php
/**
 * @package Wonderm00n's Simple Facebook Open Graph Meta Tags
 * @version 0.1.3
 */
/*
Plugin Name: Wonderm00n's Simple Facebook Open Graph Meta Tags
Plugin URI: http://blog.wonderm00n.com/2011/10/14/wordpress-plugin-simple-facebook-open-graph-tags/
Description: This plugin inserts Facebook Open Graph Tags into your Wordpress Blog/Website for better Facebook sharing
Author: Marco Almeida (Wonderm00n)
Version: 0.1.3
Author URI: http://wonderm00n.com
*/

function wonderm00n_open_graph() {
	
	//This should be set by options on wp-admin
	$fb_app_id_show=get_option('wonderm00n_open_graph_fb_app_id_show');
	$fb_app_id=get_option('wonderm00n_open_graph_fb_app_id');
	$fb_admin_id_show=get_option('wonderm00n_open_graph_fb_admin_id_show');
	$fb_admin_id=get_option('wonderm00n_open_graph_fb_admin_id');
	$fb_sitename_show=get_option('wonderm00n_open_graph_fb_sitename_show');
	$fb_title_show=get_option('wonderm00n_open_graph_fb_title_show');
	$fb_url_show=get_option('wonderm00n_open_graph_fb_url_show');
	$fb_type_show=get_option('wonderm00n_open_graph_fb_type_show');
	$fb_desc_show=get_option('wonderm00n_open_graph_fb_desc_show');
	$fb_desc_chars=intval(get_option('wonderm00n_open_graph_fb_desc_chars'));
	$fb_image_show=get_option('wonderm00n_open_graph_fb_image_show');
	$fb_image=get_option('wonderm00n_open_graph_fb_image');
	
	if (is_singular()) {
		//It's a Post or a Page or an attachment page
		global $post;
		$fb_title=esc_attr(strip_tags(stripslashes($post->post_title)));
		$fb_url=get_permalink();
		$fb_type='article';
		if (trim($post->post_excerpt)!='') {
			//If there's an excerpt that's waht we'll use
			$fb_desc=trim($post->post_excerpt);
		} else {
			//If not we grab it from the content
			$fb_desc=trim($post->post_content);
		}
		$fb_desc=(intval($fb_desc_chars)>0 ? substr(esc_attr(strip_tags(stripslashes($fb_desc))),0,$fb_desc_chars) : esc_attr(strip_tags(stripslashes($fb_desc))));
		$thumbok=false;
		if (function_exists('get_post_thumbnail_id')) {
			$thumbok=true;
		}
		if ($thumbok) {
			if ($id_attachment=get_post_thumbnail_id($post->ID)) {
				//There's a featured/thumbnail image for this post
				$fb_image=wp_get_attachment_url($id_attachment, false);
			} else {
				$thumbok=false;
			}
		}
		if (!$thumbok) {
			//If not, we'll try to get the first image on the post content
			$imgreg = '/<img .*src=["\']([^ ^"^\']*)["\']/';
			preg_match_all($imgreg, trim($post->post_content), $matches);
			$image=$matches[1][0];
			if ($image) {
				//There's an image on the content
				$pos = strpos($image, site_url());
				if ($pos === false) {
					$fb_image=$_SERVER['HTTP_HOST'].$image;
				} else {
					$fb_image=$image;
				}
			} else {
				//If not, we'll try to get the first image associated to the post, even if not used on the content
				$images = get_posts(array('post_type' => 'attachment','numberposts' => 1,'post_status' => null,'order' => 'ASC','orderby' => 'menu_order','post_mime_type' => 'image','post_parent' => $post->ID));
				if ($images) {
					$fb_image=wp_get_attachment_url($images[0]->ID, false);
				} else {
					//Well... We sure did try. We'll just keep the default one :-(
				}
			}
		}
	} else {
		//Other pages - Defaults
		$fb_title=esc_attr(strip_tags(stripslashes(get_bloginfo('name'))));
		$fb_url=get_option('siteurl');
		$fb_type='website';
		$fb_desc=esc_attr(strip_tags(stripslashes(get_bloginfo('description'))));
		
		if (is_category()) {
			$fb_title=esc_attr(strip_tags(stripslashes(single_cat_title('', false))));
			$term=get_queried_object();
			$fb_url=get_term_link($term, $term->taxonomy);
		} else {
			if (is_tag()) {
				$fb_title=esc_attr(strip_tags(stripslashes(single_tag_title('', false))));
				$term=get_queried_object();
				$fb_url=get_term_link($term, $term->taxonomy);
			} else {
				if (is_tax()) {
					$fb_title=esc_attr(strip_tags(stripslashes(single_term_title('', false))));
					$term=get_queried_object();
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
								//Home or others... Defaults already set up there
							}
						}
					}
				}
			}
		}
	}
	
	$html.='<!-- START - Wonderm00n\'s Simple Facebook Open Graph Tags -->
';
	if (intval($fb_app_id_show)==1 && trim($fb_app_id)!='') $html.='<meta property="fb:app_id" content="'.trim($fb_app_id).'" />
';
	if (intval($fb_admin_id_show)==1 && trim($fb_admin_id)!='') $html.='<meta property="fb:admins" content="'.trim($fb_admin_id).'" />
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
add_action('wp_head', 'wonderm00n_open_graph', 1);

function wonderm00n_open_graph_add_opengraph_namespace( $output ) {
	if (stristr($output,'xmlns:og')) {
		//Already there
		return $output;
	} else {
		//Let's add it
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/"';
	}
}
//We want to be last to add the namespace because some other plugin may already added it ;-)
add_filter('language_attributes', 'wonderm00n_open_graph_add_opengraph_namespace',9999);

//Admin
if ( is_admin() ){
	add_action('admin_menu', 'wonderm00n_open_graph_add_options');
}
add_action('activate_wonderm00n-open-graph/wonderm00n-open-graph.php', 'wonderm00n_open_graph_activate');

function wonderm00n_open_graph_add_options() {
  if(function_exists('add_options_page')){
    add_options_page('Wonderm00n\'s Open Graph', 'Wonderm00n\'s Open Graph', 9, basename(__FILE__), 'wonderm00n_open_graph_admin');
  }
}

function wonderm00n_open_graph_activate() {
	update_option("wonderm00n_open_graph_activated", 1);
	update_option("wonderm00n_open_graph_fb_admin_id_show", 1);
	update_option("wonderm00n_open_graph_fb_app_id_show", 1);
	update_option("wonderm00n_open_graph_fb_sitename_show", 1);
	update_option("wonderm00n_open_graph_fb_title_show", 1);
	update_option("wonderm00n_open_graph_fb_url_show", 1);
	update_option("wonderm00n_open_graph_fb_type_show", 1);
	update_option("wonderm00n_open_graph_fb_desc_show", 1);
	update_option("wonderm00n_open_graph_fb_desc_chars", 300);
	update_option("wonderm00n_open_graph_fb_image_show", 1);
}

function wonderm00n_open_graph_settings_link( $links, $file ) {
 	if( $file == 'wonderm00n-open-graph/wonderm00n-open-graph.php' && function_exists( "admin_url" ) ) {
		$settings_link = '<a href="' . admin_url( 'options-general.php?page=wonderm00n-open-graph.php' ) . '">' . __('Settings') . '</a>';
		array_push( $links, $settings_link ); // after other links
	}
	return $links;
}
add_filter( 'plugin_action_links', 'wonderm00n_open_graph_settings_link', 9, 2 );


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
		update_option('wonderm00n_open_graph_fb_sitename_show', intval($_POST['fb_sitename_show']));
		update_option('wonderm00n_open_graph_fb_title_show', intval($_POST['fb_title_show']));
		update_option('wonderm00n_open_graph_fb_url_show', intval($_POST['fb_url_show']));
		update_option('wonderm00n_open_graph_fb_type_show', intval($_POST['fb_type_show']));
		update_option('wonderm00n_open_graph_fb_desc_show', intval($_POST['fb_desc_show']));
		update_option('wonderm00n_open_graph_fb_desc_chars', intval($_POST['fb_desc_chars']));
		update_option('wonderm00n_open_graph_fb_image', trim($_POST['fb_image']));
	}
}

?>