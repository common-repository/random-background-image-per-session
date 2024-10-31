<?php
/*
Plugin Name: Random Background Image Per Session
Plugin URI:  http://davetcoleman.com/blog/random-background-image-per-session
Version:     1.2.3
Description: This plugin will choose a random background image for each site visitor, but remember the chosen background for each page for the entire visit duration.
Author:      Dave Coleman
Author URI:  http://davetcoleman.com/

Copyright 2011 by Dave Coleman (email: davetcoleman@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
	
	D:\Unique\Web\dtc\wordpress\wp-content\plugins\random-background-image-per-session
	D:\Unique\Web\dtc\wordpress-plugins\random-background-image-per-session\tags\1.2.3
	
	
//Admin Backend Functions -----------------------------------------------------------------------------

// Hook for adding admin menus
add_action('admin_menu', 'ri_add_pages');

// Action function for above hook
function ri_add_pages() {

	// Add a new submenu under Appearance:
	add_submenu_page('themes.php', 'Random Background Image', 'Random Background', 8, 'randomimg_options', 'ri_options_page');
}

//Show the Admin Settings Page for this plugin
function ri_options_page() {
				
	load_plugin_textdomain('random-background-image-per-session', false, dirname( plugin_basename(__FILE__) ) . '/languages');
	
	//For use with instruction images
	$plugin_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
	
	
	global $_POST;
	$updated = false;	//when true show updated message
	$errored = false;	//when true show error message
	
	//Check user privalages
	if ( !ri_is_authorized())
		_e('You do not have sufficient privilges.', 'random-background-image-per-session');
		
	?>
	<div class="wrap" style="max-width:850px;">
		<?php
		//Process form submission
        if (isset($_POST['randomimage_path'])) {
			
			update_option('randomimage_path',$_POST['randomimage_path']);
		
			//Checkboxes need to have an else statement
			if (isset($_POST['randomimage_session'])) {
				update_option('randomimage_session',1);
			}else{
				update_option('randomimage_session',0);
			}
			
			//Checkboxes need to have an else statement
			if (isset($_POST['randomimage_fade'])) {
				update_option('randomimage_fade',1);
			}else{
				update_option('randomimage_fade',0);
			}
			
			//Checkboxes need to have an else statement
			if (isset($_POST['randomimage_fixed'])) {
				update_option('randomimage_fixed',1);
			}else{
				update_option('randomimage_fixed',0);
			}
			
			//Height value
			if (isset($_POST['randomimage_height'])) {
				update_option('randomimage_height',$_POST['randomimage_height']);
			}
			
			?>
			<div id="message" class="updated below-h2">
				<p>
					<?php _e('Background updated.', 'random-background-image-per-session'); ?> 
					<a href="<?php echo get_settings('home'); ?>">
						<?php _e('Visit your site', 'random-background-image-per-session'); ?>
					</a> 
					<?php _e('to see how it looks.', 'random-background-image-per-session'); ?>
				</p>
			</div>
			<?php
        }

		?>
			
		<h2><?php _e('Random Background - Options', 'random-background-image-per-session'); ?></h2>
		<?php _e('Keep your site looking fresh!', 'random-background-image-per-session'); ?>
		<br />
		<a href="http://davetcoleman.com/blog/random-background-image-per-session" target="_blank"><?php _e('Help & Support', 'random-background-image-per-session'); ?></a>
		<br /><br />
		
		<? if (! is_plugin_active('nextgen-gallery/nggallery.php')): ?>
			<div id="message" class="updated below-h2">
				<p><?php _e('You are in manual upload mode and may need access to FTP to add background images. To easily add your background images we recommend you install the <a href="http://wordpress.org/extend/plugins/nextgen-gallery/">NextGen Gallery</a> Wordpress plugin and return to this page.', 'random-background-image-per-session'); ?></p>
			</div>
		<? endif; ?>
		
		<form action="" method="post">
		  <input type="hidden" name="redirect" value="true" />
			<h3><?php _e('Add Background Images', 'random-background-image-per-session'); ?></h3>
			<ol>
				<li>
					<b><?php _e('Find/create background images', 'random-background-image-per-session'); ?></b>
					<?php _e('that will be non-repeating and stetched to the page\'s width and (optionally) height.', 'random-background-image-per-session'); ?>
					<br />
					<ul style="list-style:circle;margin-left:20px;">
						<li><?php _e('Required formats: .png, .gif, or .jpg', 'random-background-image-per-session'); ?></li>
						<li><?php _e('Based on today\'s browser display statistics, a good recommended size is 1280px x 1024px.', 'random-background-image-per-session'); ?></li>
					</ul>
				</li>
				<?php 
				// If NextGen Galley plugin is installed, force user to use that because it makes this interface way easier. possible todo: allow NGG users to override this if they want. 
				if (is_plugin_active('nextgen-gallery/nggallery.php')): ?>
				
					<li>
						<b><?php _e('Upload images to a new NextGen gallery','random-background-image-per-session'); ?></b>
						<br />
						<ul style="list-style:circle;margin-left:20px;">
							<li><?php _e('Click on the "Gallery" link on the menu on the left of this page.', 'random-background-image-per-session'); ?></li>
							<li><?php _e('Click on the sub menu "Add Gallery / Images" and upload images to a new gallery.', 'random-background-image-per-session'); ?></li>
						</ul>
					</li>
					<li>
						<b><?php _e('Choose your NextGen gallery from the list below', 'random-background-image-per-session'); ?></b>
						<br/>
						<input type="hidden" name="randomimage_path" id="randomimage_path" size="65" value="<?php echo get_option('randomimage_path'); ?>" /> 
					 
						<?php
						global $wpdb;
						$galleries = $wpdb->get_results( "SELECT gid, name, path FROM wp_ngg_gallery" );
						?>
						<select id="ngg-galleries-select" style="width:400px;">
							<option selected="selected" value=""><i><?php _e('Choose your NextGen Gallery', 'random-background-image-per-session'); ?></i></option>';
																				  
							<?php foreach ($galleries as $gallery) { ?>
								<option value="<?php echo $gallery->path; ?>"><?php echo $gallery->gid . ' - '. $gallery->name; ?></option>
							<?php } ?>
							
						</select>
							  
						<script>                                        
							jQuery("#ngg-galleries-select").change(function () {
								var ngGallery = jQuery(this).val();
								jQuery("#randomimage_path").val(ngGallery);
							});
						</script>
					</li>
					
				<?php else: ?>
				
					<li>
						<b><?php _e('Create BG images folder','random-background-image-per-session'); ?></b><br /><?php _e('within your Wordpress installation. It can be in your theme folder or, recommended, uploads folder: (wp-content/uploads/bg-images/)', 'random-background-image-per-session'); ?><br />&nbsp;
					</li>
					<li>
						<b><?php _e('Enter the server sub-folder path', 'random-background-image-per-session'); ?></b> <?php _e('to where you put the BG images:', 'random-background-image-per-session'); ?>
						<br/>
						<?php echo str_replace('\\','/', ABSPATH);  ?>
						<input type="text" name="randomimage_path" id="randomimage_path" size="65" value="<?php echo get_option('randomimage_path'); ?>" /> 
						<i><?php _e('(e.g. wp-content/uploads/bg-images/)', 'random-background-image-per-session'); ?></i>
						
						<br />&nbsp;
					</li>
					
				<?php endif; ?>
			</ol>
			
			
			
			
			
			
			
			
			<h3><?php _e('Choose Background Layout', 'random-background-image-per-session'); ?></h3>
			<table cellspacing=10>
				<tr>
					<td><img src="<?php echo $plugin_path; ?>/screenshot-2.jpg"></td>
					<td><img src="<?php echo $plugin_path; ?>/screenshot-1.jpg"></td>
				</tr>
				<tr>
					<td><div style="font-weight:bold;text-align:center;">Scrolling Background</div></td>
					<td><div style="font-weight:bold;text-align:center;">Fixed Background</div></td>
				</tr>
			</table>
			<ol>
				<li>
					<input type="checkbox" name="randomimage_fixed" value="on" <?php echo (get_option('randomimage_fixed', 0)?'checked="yes"':'') ?> /> 
					<b><?php _e('Fix the background so it doesn\'t move when scrolling down page', 'random-background-image-per-session'); ?></b>
					<i>(<?php _e('default: disabled', 'random-background-image-per-session'); ?>)</i><br/>
					<?php _e('If not checked, the background will end for longer pages and fade/revert into your base background style.', 'random-background-image-per-session'); ?>
				</li>
				
				
				
				<li>
					<b><?php _e('Scrolling layout only: set the height of background.', 'random-background-image-per-session'); ?></b><br/>
					<?php _e('There is no height by default. If you want backgrounds to fit width and height of your page, you can set the height to 100%. Otherwise you can set the height in pixels.', 'random-background-image-per-session'); ?></i>
					<br />
					<input type="text" name="randomimage_height" size=10 value="<?php echo get_option('randomimage_height','100%'); ?>" /> <i>(e.g. "100%" or "800px")</i>
				</li>
			</ol>
			<h3><?php _e('Options', 'random-background-image-per-session'); ?></h3>
			<ol>
				<li>
					<input type="checkbox" name="randomimage_session" value="on" <?php echo (get_option('randomimage_session', 1)?'checked="yes"':'') ?> /> 
					<b><?php _e('Keep The Same Background the Whole Visit', 'random-background-image-per-session'); ?></b>
					<i>(<?php _e('default: enabled', 'random-background-image-per-session'); ?>)</i><br/>
					<?php _e('When checked a session cookie will be made to remember which background image was randomly chosen for the user for their current visit.', 'random-background-image-per-session'); ?>
				</li>
				<li>
					<input type="checkbox" name="randomimage_fade" value="on" <?php echo (get_option('randomimage_fade',0)?'checked="yes"':'') ?> /> 
					<b><?php _e('Fade In Background Dynamically', 'random-background-image-per-session'); ?></b>
					<i>(<?php _e('default: disabled', 'random-background-image-per-session'); ?>)</i>
					<br/>
					<?php _e('Uses the jQuery fade effect to show your background', 'random-background-image-per-session'); ?>
				</li>
			</ol>
			<br />
			<h3><?php _e('Advanced Tips', 'random-background-image-per-session'); ?></h3>
			<ol>
				<li>
					<b><?php _e('Make the effect look even better','random-background-image-per-session'); ?></b>
					<br />
					<?php _e('The random BG image, even when stretched to a height of 100%, will still only cover the height of the user\'s browser window. The following tips can help, depending on your theme and style:', 'random-background-image-per-session'); ?></i>
					<ul style="list-style:circle;margin-left:20px;">
						<li><?php _e('Consider having the bottom of the image fade to a solid color that matches the page\'s background color.', 'random-background-image-per-session'); ?></li>
						<li><?php _e('Another option is to have a secondary background image that repeats under the main random background image.', 'random-background-image-per-session'); ?></li>
						<li><?php _e('To set the page\'s background color or secondary background image, edit the style.css file or, in many themes including the default Wordpress theme, click on the "Appearance" link on the menu on the left of this page and choose "Background".', 'random-background-image-per-session'); ?></li>
					</ul>
				</li>
				<li>
					<b><?php _e('Fix your CSS style sheet', 'random-background-image-per-session'); ?></b><br/>
					<?php _e('If the background is not appearing corretly you might need to edit your theme\'s style sheet. Go to the "Appearance" menu on the left and click the "Editor" sub-menu item. On the following page you should be editing "style.css". Find your page\'s main div wrapper - this is the first html element after the &#60;body&#62; tag. Within the style for this element add the following two lines:', 'random-background-image-per-session'); ?><br />
					&nbsp;&nbsp;<i>z-index:2;<br />
					&nbsp;&nbsp;position:relative;</i><br />
					<?php _e('Save the style sheet changes and hopefully you are ready to go!', 'random-background-image-per-session'); ?>
				</li>
			</ol>
			<br />
			<p><input type="submit" value="<?php _e('Save Settings', 'random-background-image-per-session'); ?>" /></p>
		</form>
	</div>
	<?php
}

//Frontend Display Functions -----------------------------------------------------------------------------


//Only require jQuery be loaded if this option has been checked
if(get_option('randomimage_fade'))
	wp_enqueue_script("jquery");
	
//Add the background html code filter hook
add_filter( 'wp_head', randBG_Header ); 
add_filter( 'wp_footer', randBG_Footer ); 

//Have global plugin variables so that the footer function can access info from the header function
$footer_html = "";

function randBG_Header()
{
	global $footer_html;
	
	//Load plugin options
	$useSession = get_option('randomimage_session', 1);	//Check if the plugin settings are to use the session
	$bg_height = get_option('randomimage_height','100%');
	$bg_fade = get_option('randomimage_fade', 0);
	$bg_fixed = get_option('randomimage_fixed', 0);
	
	//Get the URL to the background image
	if($useSession)
	{
		//Check if there is already a BG saved in session
		session_start();
		
		if(isset($_SESSION['background']))	//already have session bg 
		{
			$bg_image = $_SESSION['background'];	//get from cookie
		}
		else
		{
			$bg_image = generateRandomImage();	//pull from folder a rand bg
			
			if($bg_image === false)	//no images found
				$bg_image = 'http://flickholdr.com/1200/900/sunrise/bw';	//show default background for funzies
			else
				$_SESSION['background'] = $bg_image;	//save image to session
		}
	}
	else
	{
		$bg_image = generateRandomImage();	//pull from folder a rand bg
		
		if($bg_image === false)	//no images found
			$bg_image = 'http://flickholdr.com/1200/900/sunrise/bw';	//show default background for funzies
	}	
		
	//Make the HTML ----------------------------------------------
	
	//Output the actual background <img> tag code
	
	//Decide if the image should be fixed or scoll with the page:
	if($bg_fixed):	//show fixed version
		?>
		<style type="text/css">
			/*  Random background per session plugin: styles automatically inserted based on plugin settings 
				Based on: http://css-tricks.com/perfect-full-page-background-image/
			*/
			img.bg-rand {
				/* Set rules to fill background */
				min-height: 100%;
				min-width: 1024px;

				/* Set up proportionate scaling */
				width: 100%;
				height: auto;

				/* Set up positioning */
				position: fixed;
				top: 0;
				left: 0;
				z-index:-1;
			}

			@media screen and (max-width: 1024px) { /* Specific to this particular image */
				img.bg-rand {
					left: 50%;
					margin-left: -512px;   /* 50% */
				}
			}
		</style>			
		<?php	
		
	else:	//let her scroll -------------------------------------------------
		
		//Create the css height property if applicable
		if(!empty($bg_height))
			$bg_height = 'height:'. $bg_height .';';	
			
		?>
		<style type="text/css">
			/* Random background per session plugin: styles automatically inserted based on plugin settings */
			img.bg-rand {
				position:absolute;
				top:0;
				left:0;
				z-index:-1;
				width:100%;
				<?php echo $bg_height; ?>
			}
		</style>			
		<?php	
		
	endif;

	
	//Save the footer code for the footer function
	$footer_html = '<img id="bg-rand" class="bg-rand" src="'.$bg_image.'"  />';
	
	//Check if jQuery fade effect is to be used
	if($bg_fade) { 
	
		$footer_html = $footer_html . '
			<script type="text/javascript">
				jQuery("#bg-rand").hide().fadeIn(1500);
			</script>';
	} 
	
}

//Now output the img tag and any javascript
function randBG_Footer()
{
	global $footer_html;
	echo $footer_html;
}




//Helper Functions -----------------------------------------------------------------------------

//Check to see if user has sufficient privileges to edit the plugin settings in the admin
function ri_is_authorized() 
{
	global $user_level;
	if (function_exists("current_user_can")) {
		return current_user_can('activate_plugins');
	} else {
		return $user_level > 5;
	}
}
		
		
//This is where the random image is chosen
function generateRandomImage()
{
	$imageSubPath = get_option('randomimage_path','wp-content/uploads/bg-images/');
    $physicalPath = ABSPATH . $imageSubPath;
	$virtualPath = get_bloginfo('wpurl') . "/" . $imageSubPath;
	
    $image_types = array('jpg','png','gif'); // Array of valid image types
    $image_directory = @opendir($physicalPath);

	//Check if directory does not exist
	if($image_directory === false){
		return false;
	}
	
	//This next part I borrowed from another part. I haven't 
	//taken the time to see if its optimized, but I have a hunch it isn't:
    while($image_file = readdir($image_directory))
    {
      if(in_array(strtolower(substr($image_file,-3)),$image_types))
      {
         $image_array[] = $image_file;
         sort($image_array);
         reset ($image_array);
      }
    }

    return $virtualPath.'/'.$image_array[rand(1,count($image_array))-1];
	
}

