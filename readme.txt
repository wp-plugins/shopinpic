=== ShopInPic Plugin ===
Contributors: Abrikos Digital 
Tags: image, tag, image tagging, image tags, featured image, featured images, art gallery, foto, photo, interactive image, interactive photo, interactive picture, imagemap, image map, marketing
Requires at least: 3.0.1
Tested up to: 4.2
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Made your images interactive with ShopInPic service. You could map areas of the image with different sizes, icons, text, colors etc. 

== Description ==

This plugin is a wrapper over the SHOPINPIC.COM web service. Service allow a blog editors mark up a post images with interactive areas. Eeach area is highly customizable to fit your design. Check out a DEMO page at the http://www.shopinpic.com/demo/.

Take a note, plugin will access shopinpic.com servers for imagemapping, store and retrieve data. To use a plugin you will need an API key, which your can get easily at http://shopinpic.com/getapikey/

== Installation ==
1. Upload the folder shopinpic to the directory /wp-content/plugins/.
2. Activate the plugin via the 'Plugins' menu in your WordPress admin panel.
3. Go to Settings your WordPress admin panel - "Settings" > "ShopInPic".
4. Put API key in settings and click "Save"
5. Check the settings page and write down a correct "ContentId HTML block" value. It's must be a wrapper id over your content, and depends from your theme.

== Frequently Asked Questions ==
= Will it works in sliding gallery? =
Who knows. It depends from gallery code. Your could try. 

= What about responsive layouts? =
It's supported, even if you resize browser window by mouse.

= Does background images supported? =
Nope. 

= What about limits? =
Now it's free. But we recommend to check a Terms of Using at http://shopinpic.com/getapikey/license.php If your site is commercial and it will bring a high load on our servers we will contact you to solve an issue.

== Screenshots ==
1. Result image screenshot1.png
2. Settings page screenshot-settings.png

== Known issues ==

Try to avoid putting images with mark up on the one line without wrapping elements.

Internet Explorer < 8 have a limited support:
* Images with padding left and top could have wrong icons placements
* Images with absolute positioning will hav a wrong icon placemend
* Management panel will not work under IE8

If you got an issue, please write us at support@shopinpic.com 


== Changelog ==
= 1.0.1 =
* Minor fixes
= 1.0.0 =
* Initial release
