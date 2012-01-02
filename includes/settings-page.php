<?php
/**
 * @package Wonderm00n's Simple Facebook Open Graph Tags
 * @subpackage Settings Page
 *
 * @since 0.1
 * @author Marco Almeida (Wonderm00n)
 *
 *
 */
		
	//Init settings
	if(intval(get_option("wonderm00n_open_graph_activated", ""))!=1) {
		wonderm00n_open_graph_activate();
	}
	
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

	?>
	<div class="wrap">
		
	<?php screen_icon(); ?>
  	<h2>Wonderm00n's Simple Facebook Open Graph Tags</h2>
  	<br class="clear"/>
  	<p>Please set some default values and which tags should, or should not, be included. It may be necessary to exclude some tags if other plugins are already including them.</p>
  	
  	<?php
  	settings_fields('wonderm00n_open_graph');
  	?>
  	
  	<div class="postbox-container" style="width: 69%;">
  		<div id="poststuff">
  			<div id="wonderm00n_open_graph-settings" class="postbox">
  				<h3 id="settings">Settings</h3>
  				<div class="inside">
  				
  					<form name="form1" method="post">
  						<table width="100%" class="form-table">
							<tr>
								<th scope="row" nowrap="nowrap">Include Facebook Platform App ID (fb:app_id) tag?</th>
								<td>
									<input type="checkbox" name="fb_app_id_show" id="fb_app_id_show" value="1" <?php echo (intval($fb_app_id_show)==1 ? ' checked="checked"' : ''); ?> onclick="showAppidOptions();"/>
								</td>
							</tr>
							<tr class="fb_app_id_options">
								<th scope="row" nowrap="nowrap">Facebook Platform App ID:</th>
								<td>
									<input type="text" name="fb_app_id" id="fb_app_id" size="30" value="<?php echo $fb_app_id; ?>"/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
							</tr>
							<tr>
								<th scope="row" nowrap="nowrap">Include Facebook Admin(s) ID (fb:admins) tag?</th>
								<td>
									<input type="checkbox" name="fb_admin_id_show" id="fb_admin_id_show" value="1" <?php echo (intval($fb_admin_id_show)==1 ? ' checked="checked"' : ''); ?> onclick="showAdminOptions();"/>
								</td>
							</tr>
							<tr class="fb_admin_id_options">
								<th scope="row" nowrap="nowrap">Facebook Admin(s) ID:</th>
								<td>
									<input type="text" name="fb_admin_id" id="fb_admin_id" size="30" value="<?php echo $fb_admin_id; ?>"/>
									<br/>
									Comma separated if more than one
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
							</tr>
							<tr>
								<th scope="row" nowrap="nowrap">Include locale (fb:locale) tag?</th>
								<td>
									<input type="checkbox" name="fb_locale_show" id="fb_locale_show" value="1" <?php echo (intval($fb_locale_show)==1 ? ' checked="checked"' : ''); ?> onclick="showLocaleOptions();"/>
								</td>
							</tr>
							<tr class="fb_locale_options">
								<th scope="row" nowrap="nowrap">Locale:</th>
								<td>
									<select name="fb_locale" id="fb_locale">
										<option value=""<?php if (trim($fb_locale)=='') echo ' selected="selected"'; ?>>Wordpress current locale/language (<?php echo get_locale(); ?>)&nbsp;</option>
									<?php
										$listLocales=false;
										//Online
										if ($ch = curl_init('http://www.facebook.com/translations/FacebookLocales.xmla')) {
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
											$fb_locales=curl_exec($ch);
											if (curl_errno($ch)) {
												//echo curl_error($ch);
											} else {
												$info = curl_getinfo($ch);
												if (intval($info['http_code'])==200) {
													$listLocales=true;
												}
											}
											curl_close($ch);
										}
										//Offline
										if (!$listLocales) {
											if ($fb_locales=file_get_contents(ABSPATH . 'wp-content/plugins/wonderm00ns-simple-facebook-open-graph-tags/includes/FacebookLocales.xml')) {
												$listLocales=true;
											}
										}
										//OK
										if ($listLocales) {
											$xml=simplexml_load_string($fb_locales);
											$json = json_encode($xml);
											$locales = json_decode($json,TRUE);
											if (is_array($locales['locale'])) {
												foreach ($locales['locale'] as $locale) {
													?><option value="<?php echo $locale['codes']['code']['standard']['representation']; ?>"<?php if (trim($fb_locale)==trim($locale['codes']['code']['standard']['representation'])) echo ' selected="selected"'; ?>><?php echo $locale['englishName']; ?> (<?php echo $locale['codes']['code']['standard']['representation']; ?>)</option><?php
												}
											}
										}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
							</tr>
							<tr>
								<th scope="row" nowrap="nowrap">Include Site Name (og:site_name) tag?</th>
								<td>
									<input type="checkbox" name="fb_sitename_show" id="fb_sitename_show" value="1" <?php echo (intval($fb_sitename_show)==1 ? ' checked="checked"' : ''); ?>/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
							</tr>
							<tr>
								<th scope="row" nowrap="nowrap">Include Post/Page title (og:title) tag?</th>
								<td>
									<input type="checkbox" name="fb_title_show" id="fb_title_show" value="1" <?php echo (intval($fb_title_show)==1 ? ' checked="checked"' : ''); ?>/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
							</tr>
							<tr>
								<th scope="row" nowrap="nowrap">Include URL (og:url) tag?</th>
								<td>
									<input type="checkbox" name="fb_url_show" id="fb_url_show" value="1" <?php echo (intval($fb_url_show)==1 ? ' checked="checked"' : ''); ?> onclick="showUrlOptions();"/>
								</td>
							</tr>
							<tr class="fb_url_options">
								<th scope="row" nowrap="nowrap">Add trailing slash at the end:</th>
								<td>
									<select name="fb_url_add_trailing" id="fb_url_add_trailing" onchange="showUrlTrail();">
										<option value="0"<?php if (intval($fb_url_add_trailing)==0) echo ' selected="selected"'; ?>>No&nbsp;</option>
										<option value="1"<?php if (intval($fb_url_add_trailing)==1) echo ' selected="selected"'; ?>>Yes&nbsp;</option>
									</select>
									<br/>
									On the homepage will be: <i><?php echo get_option('siteurl'); ?><span id="fb_url_add_trailing_example">/</span></i>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
							</tr>
							<tr>
								<th scope="row" nowrap="nowrap">Include Type (og:type) tag?</th>
								<td>
									<input type="checkbox" name="fb_type_show" id="fb_type_show" value="1" <?php echo (intval($fb_type_show)==1 ? ' checked="checked"' : ''); ?> onclick="showTypeOptions();"/>
									(will be	&quot;article&quot; for posts and pages and &quot;website&quot; or &quot;blog&quot; for the homepage)
								</td>
							</tr>
							<tr class="fb_type_options">
								<th scope="row" nowrap="nowrap">Homepage type:</th>
								<td>
									Use
									<select name="fb_type_homepage" id="fb_type_homepage">
										<option value="website"<?php if (trim($fb_type_homepage)=='' || trim($fb_type_homepage)=='website') echo ' selected="selected"'; ?>>website&nbsp;</option>
										<option value="blog"<?php if (trim($fb_type_homepage)=='blog') echo ' selected="selected"'; ?>>blog&nbsp;</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
							</tr>
							<tr>
								<th scope="row" nowrap="nowrap">Include Description (og:description) tag?</th>
								<td>
									<input type="checkbox" name="fb_desc_show" id="fb_desc_show" value="1" <?php echo (intval($fb_desc_show)==1 ? ' checked="checked"' : ''); ?> onclick="showDescriptionOptions();"/>
								</td>
							</tr>
							<tr class="fb_description_options">
								<th scope="row" nowrap="nowrap">Description maximum length:</th>
								<td>
									<input type="text" name="fb_desc_chars" id="fb_desc_chars" size="3" maxlength="3" value="<?php echo (intval($fb_desc_chars)>0 ? intval($fb_desc_chars) : ''); ?>"/> characters, 0 or blank for no maximum length
								</td>
							</tr>
							<tr class="fb_description_options">
								<th scope="row" nowrap="nowrap">Homepage description:</th>
								<td>
									Use
									<select name="fb_desc_homepage" id="fb_desc_homepage" onchange="showDescriptionCustomText();">
										<option value=""<?php if (trim($fb_desc_homepage)=='') echo ' selected="selected"'; ?>>Website tagline&nbsp;</option>
										<option value="custom"<?php if (trim($fb_desc_homepage)=='custom') echo ' selected="selected"'; ?>>Custom text&nbsp;</option>
									</select>
									<div id="fb_desc_homepage_customtext_div">
										<textarea name="fb_desc_homepage_customtext" id="fb_desc_homepage_customtext" rows="3" cols="50"><?php echo $fb_desc_homepage_customtext; ?></textarea>
									</div>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
							</tr>
							<tr>
								<th scope="row" nowrap="nowrap">Include Image (og:image) tag?</th>
								<td>
									<input type="checkbox" name="fb_image_show" id="fb_image_show" value="1" <?php echo (intval($fb_image_show)==1 ? ' checked="checked"' : ''); ?> onclick="showImageOptions();"/>
								</td>
							</tr>
							<tr class="fb_image_options">
								<th scope="row" nowrap="nowrap">Default image:</th>
								<td>
									<input type="text" name="fb_image" id="fb_image" size="50" value="<?php echo $fb_image; ?>"/>
									<input id="fb_image_button" class="button" type="button" value="Upload/Choose image" />
									<br/>
									Full URL with http://
								</td>
							</tr>
							<tr class="fb_image_options">
								<th scope="row" nowrap="nowrap">On posts/pages:</th>
								<td>
									<div>
										1) <input type="checkbox" name="fb_image_use_featured" id="fb_image_use_featured" value="1" <?php echo (intval($fb_image_use_featured)==1 ? ' checked="checked"' : ''); ?>/>
										Image will be fetched from post/page featured/thumbnail picture.</div>
									<div>
										2) <input type="checkbox" name="fb_image_use_content" id="fb_image_use_content" value="1" <?php echo (intval($fb_image_use_content)==1 ? ' checked="checked"' : ''); ?>/>
										If it doesn't exist, use the first image from the post/page content.
									</div>
									<div>
										3) <input type="checkbox" name="fb_image_use_media" id="fb_image_use_media" value="1" <?php echo (intval($fb_image_use_media)==1 ? ' checked="checked"' : ''); ?>/>
										If it doesn't exist, use first image from the post/page media gallery.
									</div>
									<div>
										4) <input type="checkbox" name="fb_image_use_default" id="fb_image_use_default" value="1" <?php echo (intval($fb_image_use_default)==1 ? ' checked="checked"' : ''); ?>/>
										If it doesn't exist, use the default image above.
									</div>
								</td>
							</tr>
  						</table>
  						<p class="submit">
  							<input type="hidden" name="action" value="save"/>
								<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
							</p>
  					</form>
  					
  				</div>
  			</div>
  		</div>
  	</div>
  	
  	<?php
  		$links[0]['text']='Test your URLs at Facebook URL Linter / Debugger';
  		$links[0]['url']='https://developers.facebook.com/tools/debug';
  		$links[10]['text']='About the Open Graph Protocol (on Facebook)';
  		$links[10]['url']='https://developers.facebook.com/docs/opengraph/';
  		$links[20]['text']='The Open Graph Protocol (official website)';
  		$links[20]['url']='http://ogp.me/';
  		$links[30]['text']='Plugin official URL (feedback is welcomed)';
  		$links[30]['url']='http://blog.wonderm00n.com/2011/10/14/wordpress-plugin-simple-facebook-open-graph-tags/';
  		$links[40]['text']='Author\'s website: Marco Almeida (Wonderm00n)';
  		$links[40]['url']='http://wonderm00n.com';
  		$links[50]['text']='Author\'s Twitter account: @Wonderm00n';
  		$links[50]['url']='http://twitter.com/wonderm00n';
  		$links[60]['text']='Author\'s Facebook account: Wonderm00n';
  		$links[60]['url']='http://www.facebook.com/wonderm00n';
  	?>
  	<div class="postbox-container" style="width: 29%; float: right;">
  		
  		<div id="poststuff">
  			<div id="wonderm00n_open_graph_links" class="postbox">
  				<h3 id="settings">Rate this plugin</h3>
  				<div class="inside">
  					If you like this plugin, <a href="http://wordpress.org/extend/plugins/wonderm00ns-simple-facebook-open-graph-tags/" target="_blank">please give it a high Rating</a>.
  				</div>
  			</div>
  		</div>
		
  		<div id="poststuff">
  			<div id="wonderm00n_open_graph_links" class="postbox">
  				<h3 id="settings">Useful links</h3>
  				<div class="inside">
  					<ul>
  						<?php foreach($links as $link) { ?>
  							<li>- <a href="<?php echo $link['url']; ?>" target="_blank"><?php echo $link['text']; ?></a></li>
  						<?php } ?>
  					</ul>
  				</div>
  			</div>
  		</div>
  	
  		<div id="poststuff">
  			<div id="wonderm00n_open_graph_donation" class="postbox">
  				<h3 id="settings">Donate</h3>
  				<div class="inside">
  					<p>If you find this plugin useful and want to make a contribution towards future development please consider making a small, or big ;-), donation.</p>
  					<center><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
						<input type="hidden" name="cmd" value="_donations">
						<input type="hidden" name="business" value="wonderm00n@gmail.com">
						<input type="hidden" name="lc" value="PT">
						<input type="hidden" name="item_name" value="Marco Almeida (Wonderm00n)">
						<input type="hidden" name="item_number" value="wonderm00n_open_graph">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form></center>
  				</div>
  			</div>
  		</div>
  		
  	</div>
  	
  	<div class="clear">
  		<p><br/>&copy 2011<?php if(date('Y')>2011) echo '-'.date('Y'); ?> <a href="http://wonderm00n.com" target="_blank">Marco Almeida (Wonderm00n)</a></p>
  	</div>
		
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#fb_image_button').click(function(){
				tb_show('',"media-upload.php?type=image&TB_iframe=true");
			});
			window.send_to_editor = function(html) {
				imgurl = jQuery('img',html).attr('src');
				jQuery("input"+"#fb_image").val(imgurl);
				tb_remove();
			}
			showAppidOptions();
			showAdminOptions();
			showLocaleOptions();
			showTypeOptions();
			showUrlOptions();
			showUrlTrail();
			jQuery('.fb_description_options').hide();
			showDescriptionOptions();
			jQuery('#fb_desc_homepage_customtext').hide();
			showDescriptionCustomText();
			showImageOptions();
		});
		function showAppidOptions() {
			if (jQuery('#fb_app_id_show').is(':checked')) {
				jQuery('.fb_app_id_options').show();
			} else {
				jQuery('.fb_app_id_options').hide();
			}
		}
		function showAdminOptions() {
			if (jQuery('#fb_admin_id_show').is(':checked')) {
				jQuery('.fb_admin_id_options').show();
			} else {
				jQuery('.fb_admin_id_options').hide();
			}
		}
		function showLocaleOptions() {
			if (jQuery('#fb_locale_show').is(':checked')) {
				jQuery('.fb_locale_options').show();
			} else {
				jQuery('.fb_locale_options').hide();
			}
		}
		function showUrlOptions() {
			if (jQuery('#fb_url_show').is(':checked')) {
				jQuery('.fb_url_options').show();
			} else {
				jQuery('.fb_url_options').hide();
			}
		}
		function showUrlTrail() {
			if (jQuery('#fb_url_add_trailing').val()=='1') {
				jQuery('#fb_url_add_trailing_example').show();
			} else {
				jQuery('#fb_url_add_trailing_example').hide();
			}
		}
		function showTypeOptions() {
			if (jQuery('#fb_type_show').is(':checked')) {
				jQuery('.fb_type_options').show();
			} else {
				jQuery('.fb_type_options').hide();
			}
		}
		function showDescriptionOptions() {
			if (jQuery('#fb_desc_show').is(':checked')) {
				jQuery('.fb_description_options').show();
			} else {
				jQuery('.fb_description_options').hide();
			}
		}
		function showDescriptionCustomText() {
			if (jQuery('#fb_desc_homepage').val()=='custom') {
				jQuery('#fb_desc_homepage_customtext').show().focus();
			} else {
				jQuery('#fb_desc_homepage_customtext').hide();
			}
		}
		function showImageOptions() {
			if (jQuery('#fb_image_show').is(':checked')) {
				jQuery('.fb_image_options').show();
			} else {
				jQuery('.fb_image_options').hide();
			}
		}
	</script>
	<style type="text/css">
		TABLE.form-table TR TH {
			font-weight: bold;
		}
	</style>