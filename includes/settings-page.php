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
	
	$fb_app_id_show = get_option('wonderm00n_open_graph_fb_app_id_show');
	$fb_app_id = get_option('wonderm00n_open_graph_fb_app_id');
	$fb_admin_id_show = get_option('wonderm00n_open_graph_fb_admin_id_show');
	$fb_admin_id = get_option('wonderm00n_open_graph_fb_admin_id');
	$fb_sitename_show = get_option('wonderm00n_open_graph_fb_sitename_show');
	$fb_title_show = get_option('wonderm00n_open_graph_fb_title_show');
	$fb_url_show = get_option('wonderm00n_open_graph_fb_url_show');
	$fb_type_show = get_option('wonderm00n_open_graph_fb_type_show');
	$fb_desc_show = get_option('wonderm00n_open_graph_fb_desc_show');
	$fb_desc_chars = get_option('wonderm00n_open_graph_fb_desc_chars');
	$fb_image_show = get_option('wonderm00n_open_graph_fb_image_show');
	$fb_image = get_option('wonderm00n_open_graph_fb_image');

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
									<th scope="row" nowrap="nowrap">Include Facebook Platform App ID (og:app_id) tag?</th>
    					  	<td>
    					  		<input type="checkbox" name="fb_app_id_show" id="fb_app_id_show" value="1" <?php echo (intval($fb_app_id_show)==1 ? ' checked="checked"' : ''); ?>/>
    					  	</td>
    						</tr>
  							<tr>
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
									<th scope="row" nowrap="nowrap">Include Facebook Admin(s) ID (og:admins) tag?</th>
    					  	<td>
    					  		<input type="checkbox" name="fb_admin_id_show" id="fb_admin_id_show" value="1" <?php echo (intval($fb_admin_id_show)==1 ? ' checked="checked"' : ''); ?>/>
    					  	</td>
    						</tr>
  							<tr>
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
    					  		<input type="checkbox" name="fb_url_show" id="fb_url_show" value="1" <?php echo (intval($fb_url_show)==1 ? ' checked="checked"' : ''); ?>/>
    					  	</td>
    						</tr>
  							<tr>
  								<td>&nbsp;</td>
  								<td></td>
  							</tr>
  							<tr>
									<th scope="row" nowrap="nowrap">Include Type (og:type) tag?</th>
    					  	<td>
    					  		<input type="checkbox" name="fb_type_show" id="fb_type_show" value="1" <?php echo (intval($fb_type_show)==1 ? ' checked="checked"' : ''); ?>/>
    					  		(will be	&quot;article&quot; for posts and pages and &quot;website&quot; for the homepage)
    					  	</td>
    						</tr>
  							<tr>
  								<td>&nbsp;</td>
  								<td></td>
  							</tr>
  							<tr>
									<th scope="row" nowrap="nowrap">Include Description (og:description) tag?</th>
    					  	<td>
    					  		<input type="checkbox" name="fb_desc_show" id="fb_desc_show" value="1" <?php echo (intval($fb_desc_show)==1 ? ' checked="checked"' : ''); ?>/>
    					  	</td>
    						</tr>
  							<tr>
									<th scope="row" nowrap="nowrap">Description maximum length:</th>
    					  	<td>
    					  		<input type="text" name="fb_desc_chars" id="fb_desc_chars" size="3" maxlength="3" value="<?php echo (intval($fb_desc_chars)>0 ? intval($fb_desc_chars) : ''); ?>"/> characters
    					  		<br/>
    					  		0 or blank for no maximum length
    					  	</td>
    						</tr>
  							<tr>
  								<td>&nbsp;</td>
  								<td></td>
  							</tr>
  							<tr>
									<th scope="row" nowrap="nowrap">Include Image (og:image) tag?</th>
    					  	<td>
    					  		<input type="checkbox" name="fb_image_show" id="fb_image_show" value="1" <?php echo (intval($fb_image_show)==1 ? ' checked="checked"' : ''); ?>/>
    					  	</td>
    						</tr>
  							<tr>
									<th scope="row" nowrap="nowrap">Default image:</th>
    					  	<td>
    					  		<input type="text" name="fb_image" id="fb_image" size="50" value="<?php echo $fb_image; ?>"/>
    					  		<input id="fb_image_button" class="button" type="button" value="Upload/Choose image" />
    					  		<br/>
    					  		Full URL with http://
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
  		$links[0]['text']='Test your URLs at Facebook URL Linter';
  		$links[0]['url']='https://developers.facebook.com/tools/debug';
  		$links[10]['text']='About the Open Graph Protocol (on Facebook)';
  		$links[10]['url']='https://developers.facebook.com/docs/opengraph/';
  		$links[20]['text']='The Open Graph Protocol (official website)';
  		$links[20]['url']='http://ogp.me/';
  		$links[30]['text']='Plugin official URL (feedback is welcomed)';
  		$links[30]['url']='http://blog.wonderm00n.com/2011/10/14/wordpress-plugin-simple-facebook-open-graph-tags/';
  		$links[40]['text']='Author\'s website: Marco Almeida (Wonderm00n)';
  		$links[40]['url']='http://wonderm00n.com';
  	?>
  	<div class="postbox-container" style="width: 29%;">
  		
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
  		<p><br/>&copy 2011<?php if(date('Y')>2010) echo '-'.date('Y'); ?> <a href="http://wonderm00n.com" target="_blank">Marco Almeida (Wonderm00n)</a></p>
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
		});
	</script>
	<style type="text/css">
		TABLE.form-table TR TH {
			font-weight: bold;
		}
	</style>