<?php
/**
 * Plugin Name: ShopInPic 
 * Plugin URI: http://shopinpic.com/getapikey/wp.php
 * Description: Tool to make you image interactive
 * Version: 1.3.2
 * Author: Abrikos Digital 
 * Author URI: http://abdigital.ru
 * License: GPL2
 */

/*  Copyright 2015 Abrikos Digital (email: support@shopinpic.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') or die('No script kiddies please!');

if (!function_exists('shopinpic_head')) {
	function shopinpic_head() {
		global $fcbkbttn_options;
		if (!is_admin()) {
 //|| (isset($_GET['page'] ) && "facebook-button-plugin.php" == $_GET['page'] ) ) {
			if (get_option('shopinpic_apikey')) {
				wp_enqueue_style('shopinpic_stylesheet', plugin_dir_url( __FILE__ ).'css/areas.css');
				wp_enqueue_script('shopinpic_script',  plugin_dir_url( __FILE__ ).'js/loader2.min.js');
			}
		}
	}
}

if (!function_exists('shopinpic_footer_script')) {
	function shopinpic_footer_script() {
		$apiKey = get_option('shopinpic_apikey');
		//$contentId = get_option('shopinpic_content_id');
		if ($apiKey) {
			$minImgJsStr = "";
			$minImageWidth = (int)get_option('shopinpic_minImageWidth');
			if ($minImageWidth) {
				$minImgJsStr .= "'minImageWidth': ".$minImageWidth.",";
			}
			$minImageHeight = (int)get_option('shopinpic_minImageHeight');
			if ($minImageHeight) {
				$minImgJsStr .= "'minImageHeight': ".$minImageHeight.",";
			}
			$popupPositioning = get_option('shopinpic_positioning');
			if (!$popupPositioning) {
				$popupPositioning = 'right';
			}
			$inlineJs = "<script type='text/javascript'>";
			$adminPayload = '';

			//$inlineJs .= "Shopinpic_extendChildImages('".$contentId."');";
			$inlineJs .= (current_user_can('edit_post'))?'var isAdmin = true;':'var isAdmin = false;';
			$inlineJs .= "var sinp = new Shopinpic({
'apiKey': '".$apiKey."',
'popupPositioning': '".$popupPositioning."',
".$minImgJsStr."
'adminMode': isAdmin,
'adminPayload': '".$adminPayload."',
'visibleAnimation': true
});</script>";
			echo $inlineJs;
		}
	}
}

function shopinpic_activation() {
	add_option('shopinpic_apikey', '');
	//add_option('shopinpic_content_id', 'content'); //No default value
	add_option('shopinpic_positioning', 'auto');
	add_option('shopinpic_minImageWidth', 250);
	add_option('shopinpic_minImageHeight', 250);
}

function shopinpic_add_options() {
	add_options_page('Shopinpic Plugin Settings', 'Shopinpic Settings', 'administrator', __FILE__, 'shopinpic_settings_page',plugins_url('/img/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_shopinpicsettings' );
} 

function register_shopinpicsettings() {
	register_setting( 'shopinpic-settings-group', 'API Key');
	register_setting( 'shopinpic-settings-group', 'Theme Content Id');
	register_setting( 'shopinpic-settings-group', 'Popup positioning');
}

function messageHelper($message, $class = null) {
	echo '<div id="message" '.($class?'class="'.$class.'"':'').'><p><strong>'.$message.'</strong></p></div>';
}

function shopinpic_settings_page() {
	if (!current_user_can('manage_options')) {
		messageHelper('You do not have permission to manage options.', 'error');
		return;
	}

	$isWooIntegrated = NULL;
	if (isset($_POST['check_woo'])) {
		$wooSiteUrl = '';
		//{{{ 
		$jsonContents = file_get_contents('http://shopinpic.com/imgMap3/checkWooData.php?apiKey='.get_option('shopinpic_apikey'));
		$res = json_decode($jsonContents);
		$isWooIntegrated = FALSE;	
		if ($res) { 
			if ($res->error) {
				$isWooIntegrated = FALSE;	
			} else {
				$isWooIntegrated = TRUE;	
				$wooSiteUrl = $res->data->woo_url;
			}
		}
	}
	//}}}

	if (isset($_POST['update_options'])) {
		$validPositioning = array('auto' => 1, 'left' => 1, 'right' => 1);
		$minImageWidth = (int)$_POST['shopinpic_minImageWidth'];
		if ($minImageWidth) {
			update_option('shopinpic_minImageWidth', $minImageWidth);
		}
		$minImageHeight = (int)$_POST['shopinpic_minImageHeight'];
		if ($minImageHeight) {
			update_option('shopinpic_minImageHeight', $minImageHeight);
		}
		if ($minImageWidth && $minImageHeight && ($minImageWidth < 150 || $minImageHeight < 150)) {
messageHelper('Minimum image width or height must be more 150px due the popup width.', 'error');
return;
}
		$popupPositioning = $_POST['shopinpic_positioning'];
		if (!isset($validPositioning)) {
			$popupPositioning = 'auto';
		}
		update_option('shopinpic_positioning', $popupPositioning);

		$apiKey = preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['shopinpic_apikey']);
		$jsonContents = file_get_contents('http://shopinpic.com/imgMap3/getDatas.php?imageUrl=sample&apiKey='.$apiKey);
		$res = json_decode($jsonContents);
		if (preg_match('/Access\ denied/i', $res->error)) {
			update_option('shopinpic_apikey', null);
			messageHelper('Wrong API key you need to get a right one at <a href="http://shopinpic.com/getapikey/">http://shopinpic.com/getapikey/</a>', 'error');
		return;

		}
		
                update_option('shopinpic_apikey', $apiKey);

                //update_option('shopinpic_content_id', trim(str_replace(array("'", "`"), "", $_POST['shopinpic_content_id'])));
		messageHelper('API key is valid. Settings are saved. <br /><br />Refer USAGE section for further steps at <a target="_blank" href="http://shopinpic.com/getapikey/wp.php">http://shopinpic.com/getapikey/wp.php</a>');
		return;
	}
	?>
	<h2>ShopInPic settings</h2>
	<style>
	#sinp_form label { float:left; width: 200px;  }
	#sinp_form label .hint { display:block;font-size: 10px;  }
	#sinp_form #apiKey { width: 300px;  }
	#sinp_form input#selector { width: 150px;  }
	</style>
<p>ShopInPic – is a Image markup service for your posts. Learn more at <a href="http://shopinpic.com/demo/" target="_blank">http://shopinpic.com/demo/</a> </br>
To get an API key go to the <a href="http://shopinpic.com/getapikey" target="_blank">http://shopinpic.com/getapikey</a></p>
<hr />
	<form id='sinp_form' method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<div>
		<label>API key*: </label>
		<input type='text' id='apiKey' name='shopinpic_apikey' value='<?php echo get_option('shopinpic_apikey'); ?>' />
		<div style='clear:both;'></div>
	</div>
	<?php /* removed temprorally, not all users understood that
	<div>
		<label>ContentId HTML block</label>
		<input type='text' id='selector' name='shopinpic_content_id' value='<?php echo get_option('shopinpic_content_id'); ?>' />
		<div style='clear:both;'></div>
	</div>
	*/ ?>
	<div>
		<label>Popup positioning</label>
		<select name='shopinpic_positioning'>
			<option value="auto" <?php echo get_option('shopinpic_positioning') == 'auto'?'selected=selected':''?> >auto</option>
			<option value="left" <?php echo get_option('shopinpic_positioning') == 'left'?'selected=selected':''?> > left</option>
			<option value="right" <?php echo get_option('shopinpic_positioning') == 'right'?'selected=selected':''?> >right</option>
		</select>
		<div style='clear:both;'></div>
	</div>
	<div>
		<label>Minimum image width <span class='hint'>(in pixels, not less 150)</span></label>
		<input type='text' name='shopinpic_minImageWidth' value='<?php echo get_option('shopinpic_minImageWidth')?get_option('shopinpic_minImageWidth'):250; ?>' />
		<div style='clear:both;'></div>
	</div>
	<div>
		<label>Minimum image height <span class='hint'>(in pixels, not less 150)</span></label>
		<input type='text' name='shopinpic_minImageHeight' value='<?php echo get_option('shopinpic_minImageHeight')?get_option('shopinpic_minImageHeight'):250; ?>' />
		<div style='clear:both;'></div>
	</div>
<br />
	<div>
		<input type="submit" class="button-primary" name="update_options" value="Update" />
	</div>

	</form> 
	<form method="POST">
		<h2>WooCommerce integration</h2>
		<p>You could integrate ShopInPic mapping software with WooCommerce plugin to fill up popup details quickly, just by entering SKU or product Id. To learn more please read <a href="//shopinpic.com/woocommerce/" target="_blank">manual</a>.</p>
		<p>
			<a class='button' href='//shopinpic.com/getapikey/wooSettings.php?woo_url=<?php echo get_site_url();?>' target="_blank">Start</a> integration</p>
			<input type='hidden' name='check_woo' value='1' />
			<?php if ($isWooIntegrated === NULL) : ?>
				<p>If you are already integrated you can <input class='button' type='submit' value='check' /> integration.</p>
			<?php endif; ?>
			<?php if ($isWooIntegrated === TRUE) : ?>
				<h4>You successfully integrated with wooCommerce [<?php echo $wooSiteUrl?>] url!</h4>
			<?php endif; ?>
			<?php if ($isWooIntegrated === FALSE) : ?>
				<h4 style='color: red;'>Integration fail. Please check credentials <a href='//shopinpic.com/getapikey/wooSettings.php?woo_url=<?php echo get_site_url();?>' target="_blank">here</a></h4>
			<?php endif; ?>
		<p>
	</form>
	<?php
}

function shopinpic_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }   
                
    if ($file == $this_plugin) {
        $settings_link = '<a href="'.admin_url().'admin.php?page=shopinpic/shopinpic.php">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
} 

add_action( 'wp_enqueue_scripts', 'shopinpic_head');
add_action( 'wp_footer', 'shopinpic_footer_script' );
register_activation_hook( __FILE__, 'shopinpic_activation' );
add_action('admin_menu', 'shopinpic_add_options');
add_filter('plugin_action_links', 'shopinpic_plugin_action_links', 10, 2);

