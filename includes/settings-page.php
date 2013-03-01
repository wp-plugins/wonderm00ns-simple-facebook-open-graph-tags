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
		
	//First we save!
	if ( isset($_POST['action']) ) {
		if (trim($_POST['action'])=='save') {
			//This should also use the $wonderm00n_open_graph_plugin_settings array, but because of intval and trim we still can't
			update_option('wonderm00n_open_graph_fb_app_id_show', intval(wonderm00n_open_graph_post($_POST['fb_app_id_show'])));
			update_option('wonderm00n_open_graph_fb_app_id', trim(wonderm00n_open_graph_post($_POST['fb_app_id'])));
			update_option('wonderm00n_open_graph_fb_admin_id_show', intval(wonderm00n_open_graph_post($_POST['fb_admin_id_show'])));
			update_option('wonderm00n_open_graph_fb_admin_id', trim(wonderm00n_open_graph_post($_POST['fb_admin_id'])));
			update_option('wonderm00n_open_graph_fb_locale_show', intval(wonderm00n_open_graph_post($_POST['fb_locale_show'])));
			update_option('wonderm00n_open_graph_fb_locale', trim(wonderm00n_open_graph_post($_POST['fb_locale'])));
			update_option('wonderm00n_open_graph_fb_sitename_show', intval(wonderm00n_open_graph_post($_POST['fb_sitename_show'])));
			update_option('wonderm00n_open_graph_fb_title_show', intval(wonderm00n_open_graph_post($_POST['fb_title_show'])));
			update_option('wonderm00n_open_graph_fb_title_show_schema', intval(wonderm00n_open_graph_post($_POST['fb_title_show_schema'])));
			update_option('wonderm00n_open_graph_fb_url_show', intval(wonderm00n_open_graph_post($_POST['fb_url_show'])));
			update_option('wonderm00n_open_graph_fb_url_canonical', intval(wonderm00n_open_graph_post($_POST['fb_url_canonical'])));
			update_option('wonderm00n_open_graph_fb_url_add_trailing', intval(wonderm00n_open_graph_post($_POST['fb_url_add_trailing'])));
			update_option('wonderm00n_open_graph_fb_type_show', intval(wonderm00n_open_graph_post($_POST['fb_type_show'])));
			update_option('wonderm00n_open_graph_fb_type_homepage', trim(wonderm00n_open_graph_post($_POST['fb_type_homepage'])));
			update_option('wonderm00n_open_graph_fb_desc_show', intval(wonderm00n_open_graph_post($_POST['fb_desc_show'])));
			update_option('wonderm00n_open_graph_fb_desc_show_meta', intval(wonderm00n_open_graph_post($_POST['fb_desc_show_meta'])));
			update_option('wonderm00n_open_graph_fb_desc_show_schema', intval(wonderm00n_open_graph_post($_POST['fb_desc_show_schema'])));
			update_option('wonderm00n_open_graph_fb_desc_chars', intval(wonderm00n_open_graph_post($_POST['fb_desc_chars'])));
			update_option('wonderm00n_open_graph_fb_desc_homepage', trim(wonderm00n_open_graph_post($_POST['fb_desc_homepage'])));
			update_option('wonderm00n_open_graph_fb_desc_homepage_customtext', trim(wonderm00n_open_graph_post($_POST['fb_desc_homepage_customtext'])));
			update_option('wonderm00n_open_graph_fb_image_show', intval(wonderm00n_open_graph_post($_POST['fb_image_show'])));
			update_option('wonderm00n_open_graph_fb_image_show_schema', intval(wonderm00n_open_graph_post($_POST['fb_image_show_schema'])));
			update_option('wonderm00n_open_graph_fb_image', trim(wonderm00n_open_graph_post($_POST['fb_image'])));
			update_option('wonderm00n_open_graph_fb_image_rss', intval(wonderm00n_open_graph_post($_POST['fb_image_rss'])));
			update_option('wonderm00n_open_graph_fb_image_use_featured', intval(wonderm00n_open_graph_post($_POST['fb_image_use_featured'])));
			update_option('wonderm00n_open_graph_fb_image_use_content', intval(wonderm00n_open_graph_post($_POST['fb_image_use_content'])));
			update_option('wonderm00n_open_graph_fb_image_use_media', intval(wonderm00n_open_graph_post($_POST['fb_image_use_media'])));
			update_option('wonderm00n_open_graph_fb_image_use_default', intval(wonderm00n_open_graph_post($_POST['fb_image_use_default'])));
			update_option('wonderm00n_open_graph_fb_show_subheading', intval(wonderm00n_open_graph_post($_POST['fb_show_subheading'])));
			update_option('wonderm00n_open_graph_fb_show_businessdirectoryplugin', intval(wonderm00n_open_graph_post($_POST['fb_show_businessdirectoryplugin'])));
		}
	}
	
	//Load the defaults
	$defaults=wonderm00n_open_graph_default_values();
	//Load the user settings (if they exist)
	foreach($wonderm00n_open_graph_plugin_settings as $key) {
		$usersettings[$key]=get_option('wonderm00n_open_graph_'.$key);
	}
	//Merge the settings "all together now" (yes, it's a Beatles reference)
	foreach($usersettings as $key => $value) {
		//if ($value=='') {
		if (strlen(trim($value))==0) {
			if (!empty($defaults[$key])) {
				$usersettings[$key]=$defaults[$key];
			}
		}
	}
	extract($usersettings);

	?>
	<div class="wrap">
		
	<?php screen_icon(); ?>
  	<h2>Wonderm00n's Simple Facebook Open Graph Tags (<?php echo $wonderm00n_open_graph_plugin_version; ?>)</h2>
  	<br class="clear"/>
  	<p>Please set some default values and which tags should, or should not, be included. It may be necessary to exclude some tags if other plugins are already including them.</p>
  	
  	<?php
  	settings_fields('wonderm00n_open_graph');
  	?>
  	
  	<div class="postbox-container" style="width: 69%;">
  		<div id="poststuff">
  			<form name="form1" method="post">
	  			<div id="wonderm00n_open_graph-settings" class="postbox">
	  				<h3 id="settings">Settings</h3>
	  				<div class="inside">
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
									<td colspan="2"><hr/></td>
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
									<td colspan="2"><hr/></td>
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
											$loadedOnline=false;
											$loadedOffline=false;
											//Online
											if (intval($_GET['localeOnline'])==1) {
												if ($ch = curl_init('http://www.facebook.com/translations/FacebookLocales.xml')) {
													curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
													$fb_locales=curl_exec($ch);
													if (curl_errno($ch)) {
														//echo curl_error($ch);
													} else {
														$info = curl_getinfo($ch);
														if (intval($info['http_code'])==200) {
															//Save the file locally
															$fh = fopen(ABSPATH . 'wp-content/plugins/wonderm00ns-simple-facebook-open-graph-tags/includes/FacebookLocales.xml', 'w') or die("Can't open file");
															fwrite($fh, $fb_locales);
															fclose($fh);
															$listLocales=true;
															$loadedOnline=true;
														}
													}
													curl_close($ch);
												}
											}
											//Offline
											if (!$listLocales) {
												if ($fb_locales=file_get_contents(ABSPATH . 'wp-content/plugins/wonderm00ns-simple-facebook-open-graph-tags/includes/FacebookLocales.xml')) {
													$listLocales=true;
													$loadedOffline=true;
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
										<br/>
										<?php
										if ($loadedOnline) {
											?>List loaded from Facebook (online)<?php
										} else {
											if ($loadedOffline) {
												?>List loaded from local cache (offline) - <a href="?page=wonderm00n-open-graph.php&amp;localeOnline=1" onClick="return(confirm('You\'l lose any changes you haven\'t saved. Are you sure?'));">Reload from Facebook</a><?php
											} else {
												?>List not loaded<?php
											}
										}
										?>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap">Include Site Name (og:site_name) tag?</th>
									<td>
										<input type="checkbox" name="fb_sitename_show" id="fb_sitename_show" value="1" <?php echo (intval($fb_sitename_show)==1 ? ' checked="checked"' : ''); ?>/>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap">Include Post/Page title (og:title) tag?</th>
									<td>
										<input type="checkbox" name="fb_title_show" id="fb_title_show" value="1" <?php echo (intval($fb_title_show)==1 ? ' checked="checked"' : ''); ?> onclick="showTitleOptions();"/>
									</td>
								</tr>
								<tr class="fb_title_options">
									<th scope="row" nowrap="nowrap">Also include Schema.org "itemprop" Name tag?</th>
									<td>
										<input type="checkbox" name="fb_title_show_schema" id="fb_title_show_schema" value="1" <?php echo (intval($fb_title_show_schema)==1 ? ' checked="checked"' : ''); ?>/>
										<br/>
										<i>&lt;meta itemprop="name" content="..."/&gt;</i>
										<br/>
										Recommended for G+ sharing purposes if no other plugin is setting it already
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap">Include URL (og:url) tag?</th>
									<td>
										<input type="checkbox" name="fb_url_show" id="fb_url_show" value="1" <?php echo (intval($fb_url_show)==1 ? ' checked="checked"' : ''); ?> onclick="showUrlOptions();"/>
									</td>
								</tr>
								<tr class="fb_url_options">
									<th scope="row" nowrap="nowrap">Also set Canonical URL:</th>
									<td>
										<input type="checkbox" name="fb_url_canonical" id="fb_url_canonical" value="1" <?php echo (intval($fb_url_canonical)==1 ? ' checked="checked"' : ''); ?>/>
										<br/>
										<i>&lt;link rel="canonical" href="..."/&gt;</i>
									</td>
								</tr>
								<tr class="fb_url_options">
									<th scope="row" nowrap="nowrap">Add trailing slash at the end:</th>
									<td>
										<input type="checkbox" name="fb_url_add_trailing" id="fb_url_add_trailing" value="1" <?php echo (intval($fb_url_add_trailing)==1 ? ' checked="checked"' : ''); ?> onclick="showUrlTrail();"/>
										<br/>
										On the homepage will be: <i><?php echo get_option('siteurl'); ?><span id="fb_url_add_trailing_example">/</span></i>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap">Include Type (og:type) tag?</th>
									<td>
										<input type="checkbox" name="fb_type_show" id="fb_type_show" value="1" <?php echo (intval($fb_type_show)==1 ? ' checked="checked"' : ''); ?> onclick="showTypeOptions();"/>
										<br/>
										Will be &quot;article&quot; for posts and pages and &quot;website&quot; or &quot;blog&quot; for the homepage
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
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap">Include Description (og:description) tag?</th>
									<td>
										<input type="checkbox" name="fb_desc_show" id="fb_desc_show" value="1" <?php echo (intval($fb_desc_show)==1 ? ' checked="checked"' : ''); ?> onclick="showDescriptionOptions();"/>
									</td>
								</tr>
								<tr class="fb_description_options">
									<th scope="row" nowrap="nowrap">Also include Meta Description tag?</th>
									<td>
										<input type="checkbox" name="fb_desc_show_meta" id="fb_desc_show_meta" value="1" <?php echo (intval($fb_desc_show_meta)==1 ? ' checked="checked"' : ''); ?>/>
										<br/>
										<i>&lt;meta name="description" content="..."/&gt;</i>
										<br/>
										Recommended for SEO purposes if no other plugin is setting it already
									</td>
								</tr>
								<tr class="fb_description_options">
									<th scope="row" nowrap="nowrap">Also include Schema.org "itemprop" Description tag?</th>
									<td>
										<input type="checkbox" name="fb_desc_show_schema" id="fb_desc_show_schema" value="1" <?php echo (intval($fb_desc_show_schema)==1 ? ' checked="checked"' : ''); ?>/>
										<br/>
										<i>&lt;meta itemprop="description" content="..."/&gt;</i>
										<br/>
										Recommended for G+ sharing purposes if no other plugin is setting it already
									</td>
								</tr>
								<tr class="fb_description_options">
									<th scope="row" nowrap="nowrap">Description maximum length:</th>
									<td>
										<input type="text" name="fb_desc_chars" id="fb_desc_chars" size="3" maxlength="3" value="<?php echo (intval($fb_desc_chars)>0 ? intval($fb_desc_chars) : ''); ?>"/> characters,
										<br/>
										0 or blank for no maximum length
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
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap">Include Image (og:image) tag?</th>
									<td>
										<input type="checkbox" name="fb_image_show" id="fb_image_show" value="1" <?php echo (intval($fb_image_show)==1 ? ' checked="checked"' : ''); ?> onclick="showImageOptions();"/>
										<br/>
										It's HIGHLY recommended that all images have at least 200px on both dimensions in order to Facebook to properly load them
									</td>
								</tr>
								<tr class="fb_image_options">
									<th scope="row" nowrap="nowrap">Also include Schema.org "itemprop" Image tag?</th>
									<td>
										<input type="checkbox" name="fb_image_show_schema" id="fb_image_show_schema" value="1" <?php echo (intval($fb_image_show_schema)==1 ? ' checked="checked"' : ''); ?>/>
										<br/>
										<i>&lt;meta itemprop="image" content="..."/&gt;</i>
										<br/>
										Recommended for G+ sharing purposes if no other plugin is setting it already
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
									<th scope="row" nowrap="nowrap">Also add image to RSS/RSS2 feeds?</th>
									<td>
										<input type="checkbox" name="fb_image_rss" id="fb_image_rss" value="1" <?php echo (intval($fb_image_rss)==1 ? ' checked="checked"' : ''); ?> onclick="showImageOptions();"/>
										<br/>
										For auto-posting apps like RSS Graffiti, twitterfeed, ...
									</td>
								</tr>
								<tr class="fb_image_options">
									<th scope="row" nowrap="nowrap">On posts/pages:</th>
									<td>
										<div>
											1) <input type="checkbox" name="fb_image_use_featured" id="fb_image_use_featured" value="1" <?php echo (intval($fb_image_use_featured)==1 ? ' checked="checked"' : ''); ?>/>
											Image will be fetched from post/page featured/thumbnail picture
										</div>
										<div>
											2) <input type="checkbox" name="fb_image_use_content" id="fb_image_use_content" value="1" <?php echo (intval($fb_image_use_content)==1 ? ' checked="checked"' : ''); ?>/>
											If it doesn't exist, use the first image from the post/page content
										</div>
										<div>
											3) <input type="checkbox" name="fb_image_use_media" id="fb_image_use_media" value="1" <?php echo (intval($fb_image_use_media)==1 ? ' checked="checked"' : ''); ?>/>
											If it doesn't exist, use first image from the post/page media gallery
										</div>
										<div>
											4) <input type="checkbox" name="fb_image_use_default" id="fb_image_use_default" value="1" <?php echo (intval($fb_image_use_default)==1 ? ' checked="checked"' : ''); ?>/>
											If it doesn't exist, use the default image above
										</div>
									</td>
								</tr>
	  					</table>
	  				</div>
	  			</div>
	  			<div id="wonderm00n_open_graph-thirdparty" class="postbox">
	  				<h3 id="thirdparty">3rd Party Integration</h3>
	  				<div class="inside">
	  					<?php
	  					$thirdparty=false;
	  					if(is_plugin_active('subheading/index.php')) {
	  						$thirdparty=true;
	  						?>
	  						<h4><a href="http://wordpress.org/extend/plugins/subheading/" target="_blank">SubHeading</a></h4>
	  						<table width="100%" class="form-table">
									<tr>
										<th scope="row" nowrap="nowrap">Add SubHeading to Post/Page title?</th>
										<td>
											<input type="checkbox" name="fb_show_subheading" id="fb_show_subheading" value="1" <?php echo (intval($fb_show_subheading)==1 ? ' checked="checked"' : ''); ?>/>
										</td>
									</tr>
								</table>
	  						<?php
	  					}
	  					if(is_plugin_active('business-directory-plugin/wpbusdirman.php')) {
	  						$thirdparty=true;
	  						?>
	  						<h4><a href="http://wordpress.org/extend/plugins/business-directory-plugin/" target="_blank">Business Directory Plugin</a></h4>
	  						<table width="100%" class="form-table">
									<tr>
										<th scope="row" nowrap="nowrap">Use listing BDP listing contents as OG tags?</th>
										<td>
											<input type="checkbox" name="fb_show_businessdirectoryplugin" id="fb_show_businessdirectoryplugin" value="1" <?php echo (intval($fb_show_businessdirectoryplugin)==1 ? ' checked="checked"' : ''); ?>/>
											<br/>
											Setting "Include URL", "Also set Canonical URL", "Include Description" and "Include Image" options above is HIGHLY recommended
										</td>
									</tr>
								</table>
	  						<?php
	  					}
	  					if (!$thirdparty) {
	  						?>
	  						<p>You don't have any compatible 3rd Party plugin installed/active.</p>
	  						<p>This plugin is currently compatible with:</p>
	  						<ul>
	  							<li><a href="http://wordpress.org/extend/plugins/subheading/" target="_blank">SubHeading</a></li>
	  							<li><a href="http://wordpress.org/extend/plugins/business-directory-plugin/" target="_blank">Business Directory Plugin</a></li>
	  						</ul>
	  						<?php
	  					}
	  					?>
	  				</div>
	  			</div>
	  			<p class="submit">
	  				<input type="hidden" name="action" value="save"/>
						<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
					</p>
  			</form>
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
			showTitleOptions();
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
			if (jQuery('#fb_url_add_trailing').is(':checked')) {
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
		function showTitleOptions() {
			if (jQuery('#fb_title_show').is(':checked')) {
				jQuery('.fb_title_options').show();
			} else {
				jQuery('.fb_title_options').hide();
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
		TABLE.form-table TR TD HR {
			height: 1px;
  		margin: 0px;
  		background-color: #DFDFDF;
  		border: none;
		}
	</style>