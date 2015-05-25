=== ShopInPic Plugin ===
Contributors: Abrikos Digital 
Tags: image, tag, image tagging, image tags, featured image, featured images, art gallery, foto, photo, interactive image, interactive photo, interactive picture, imagemap, image map, marketing, native ads, native ad, woocommerce integration
Requires at least: 3.0.1
Tested up to: 4.2
Stable tag: 1.3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Made your images interactive with ShopInPic service. You could map areas of the image with different sizes, icons, text, colors etc. 

== Description ==

This plugin is a wrapper over the SHOPINPIC.COM web service. Service allow a blog editors mark up a post images with interactive areas. Eeach area is highly customizable to fit your design. Check out a DEMO page at the http://www.shopinpic.com/demo/. Your content will be understand better or you can you it in "native advertizing" approach. Service support WooCommerce plugin integration to fill popup data in one click.

Take a note, plugin will access shopinpic.com servers for image mapping, store and retrieve data. To use a plugin you will need an API key, which your can get easily at http://shopinpic.com/getapikey/

Service is not free of charge in cases:
1. Your site requires more 1 000 pageviews daily.
2. You want to hide ShopInPic branding and use services as "whitelabel".

== Installation ==
1. Upload the folder shopinpic to the directory /wp-content/plugins/.
2. Activate the plugin via the 'Plugins' menu in your WordPress admin panel.
3. Go to Settings your WordPress admin panel - "Settings" > "ShopInPic".
4. Put API key in settings and click "Save"
5. Check the settings page and write down a correct "ContentId HTML block" value. It's must be a wrapper id over your content, and depends from your theme.
6. Login as wordpress administrator and create a page with image inside.
7. Image sizes should be more 250x250px
8. Open page created at step 6 in preview mode or in public mode and you should see an edit icon over image at the bottom left corner.

== Frequently Asked Questions ==
= How to place an areas over an image? =
1. Login as wordpress administrator and create a page with image inside.
2. Image size should be more 200x200px
3. Open page created at step 1 in the preview or public mode and you should see an edit icon over image at the bottom left corner.

= I do not see an edit icon over image = 
1. Make sure image size is more 200x200px
2. Check a DIV content wrapper id. It depends from theme you are using. If you need support, please write us at support@shopinpic.com 

If images on the page are created dynamically (i.e. by photo gallery) they will not able using shopinpic plugin for now.

= Will it works in sliding gallery? =
Who knows. It depends from gallery code. Your could try. 

= How to add a border around area? =
Please check http://shopinpic.com/getapikey/faq.php

= What about responsive layouts? =
It's supported, even if you resize browser window by mouse.

= Does background images supported? =
Nope. 

= What about limits? =
Now it's free. But we recommend to check a Terms of Using at http://shopinpic.com/getapikey/license.php If your site is commercial and it will bring a high load on our servers we will contact you to solve an issue.

== Screenshots ==
1. Result image 
2. Settings page 
3. Image mapping management

== Known issues ==

Try to avoid putting images with mark up on the one line without wrapping elements.

Internet Explorer < 8 have a limited support:
1. Images with padding left and top could have wrong icons placements
2. Images with absolute positioning will hav a wrong icon placemend
3. Management panel will not work under IE8

If you got an issue, please write us at support@shopinpic.com 


== Changelog ==
= 1.3.2 =
* FEATURE WooCommerce plugin integration. Check more at http://shopinpic.com/woocommerce/
= 1.3.1 =
* FEATURE icons animation where scrolling to the images
* FEATURE icons startup animation
* FEATURE statistics initial module

= 1.3 =
* FEATURE https support
* BUGFIX relative positioned images for some wordpress themes
* FEATURE option "open by default" for any icon description
* BUGFIX description fadein animation now works
* BUGFIX more support for IE8 browser

= 1.2 =
* BUGFIX removed dependency from parent container id
* FEATURE added minimum image sizing settings
* FEATURE added more icons

= 1.1 =
* Now you can control popup appearing side. Available values is 'left', 'right' or 'auto'.
= 1.0.1 =
* Minor fixes
= 1.0.0 =
* Initial release
