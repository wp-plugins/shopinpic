<?php
/**
 * Plugin Name: ShopInPic 
 * Plugin URI: http://shopinpic.com/getapikey/wp.php
 * Description: Tool to make you image interactive
 * Version: 1.0.1
 * Author: Abrikos Digital 
 * Author URI: http://abdigital.ru
 * License: GPL2
 */

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

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
		$contentId = get_option('shopinpic_content_id');
		if ($apiKey) {
			$inlineJs = "<script type='text/javascript'>Shopinpic_extendChildImages('".$contentId."');";
			$inlineJs .= (current_user_can('edit_post'))?'var isAdmin = true;':'var isAdmin = false;';
			$inlineJs .= "var sinp = new Shopinpic({
'apiKey': '".$apiKey."',
'imgCssName': 'shopinpic',
'adminMode': isAdmin
});</script>";
			echo $inlineJs;
		}
	}
}

function shopinpic_activation() {
	add_option('shopinpic_apikey', '');
	add_option('shopinpic_content_id', 'content');
}

function shopinpic_add_options() {
	add_options_page('Shopinpic Plugin Settings', 'Shopinpic Settings', 'administrator', __FILE__, 'shopinpic_settings_page',plugins_url('/img/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_shopinpicsettings' );
} 

function register_shopinpicsettings() {
	register_setting( 'shopinpic-settings-group', 'API Key' );
	register_setting( 'shopinpic-settings-group', 'Theme Content Id' );
}

function messageHelper($message, $class = null) {
	echo '<div id="message" '.($class?'class="'.$class.'"':'').'><p><strong>'.$message.'</strong></p></div>';
}

function shopinpic_settings_page() {
	if (!current_user_can('manage_options')) {
		messageHelper('You do not have permission to manage options.', 'error');
		return;
	}

	if (isset($_POST['update_options'])) {
		$apiKey = preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['shopinpic_apikey']);
		$jsonContents = file_get_contents('http://shopinpic.com/imgMap3/getDatas.php?imageUrl=sample&apiKey='.$apiKey);
		$res = json_decode($jsonContents);
		if (preg_match('/Access\ denied/i', $res->error)) {
			update_option('shopinpic_apikey', null);
			messageHelper('Wrong API key you need to get a right one at <a href="http://shopinpic.com/getapikey/">http://shopinpic.com/getapikey/</a>', 'error');
		return;

		}

		
                update_option('shopinpic_apikey', $apiKey);
                update_option('shopinpic_content_id', trim(str_replace(array("'", "`"), "", $_POST['shopinpic_content_id'])));
		messageHelper('API key is valid. Settings are saved. <br /><br />Refer USAGE section for further steps at <a target="_blank" href="http://shopinpic.com/getapikey/wp.php">http://shopinpic.com/getapikey/wp.php</a>');
		return;
	}
	?>
	<h2>ShopInPic settings</h2>
	<style>
	#sinp_form label { float:left; width: 200px;  }
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
	</div>
	<div>
	<label>ContentId HTML block</label>
	<input type='text' id='selector' name='shopinpic_content_id' value='<?php echo get_option('shopinpic_content_id'); ?>' />
	</div>
	<div>
	<input type="submit" class="button-primary" name="update_options" value="Update" />
	</div>
	</form> 
	<?
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
        
