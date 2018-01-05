=== Make Paths Relative ===
Contributors: sasiddiqui, aliya yasir
Donate link: https://www.paypal.me/yasglobal
Tags: URLs, Links, Paths, Relative, permalink, Absolute URLs, Relative URLs, scripts src, styles src, image src, remove_absolute
Requires at least: 3.5
Tested up to: 4.9
Stable tag: 0.5.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Make(convert) the absolute URLs(paths) to relative.

== Description ==

This plugin can make(convert) the paths(URLs) to relative instead of absolute. This plugin is useful to using the relative URLs. The given below list of permalinks and src can be easily converted to relative:

* Post Permalinks
* Archive Permalinks
* Author Permalinks
* Category Permalinks
* Scripts Paths(src) 
* Styles Paths(src)
* Image Paths(src)

All the above permalinks and src can be converted to relative instead absolute by using this plugin. You can select the options from the plugin settings page. 

= Filters =

If you want to exclude some Permalink or src to be relative so, you can use `paths_relative` filter in your theme's functions.php or in your custom plugin.

Your filter may looks like this (Below filter would make the jquery.js Path to absolute):

`
function yasglobal_change_path( $link ) {
  if( $link == '/wp-includes/js/jquery/jquery.js?ver=1.12.4' ) {
    $link = site_url().'/wp-includes/js/jquery/jquery.js?ver=1.12.4';
  }
  return $link;
}
add_filter( 'paths_relative', 'yasglobal_change_path' );
`

If you doesn't want to Make the Paths relative for srcset(Responsive Images)
so, just add this line in your theme's functions.php.

`
add_filter( 'srcset_paths_relative', '__return_false' );
`

If you want to make plugin works and all the paths relative without going to
check/visit Settings Page so, just add this line in your theme's functions.php.

`
add_filter( 'make_paths_relative_activate_all', '__return_true' );
`

= Make sure to check the settings Page =

== Installation ==

1. Upload the `make-paths-relative` folder to the `/wp-content/plugins/` directory or Directly install the plugin through the WordPress plugins screen.
2. Activate the Make Paths Relative plugin through the `Plugins` menu in WordPress.
3. Configure the plugin by going to the menu `Make Paths Relative` that appears in your admin menu.

== Screenshots ==

* You can select the options from the settings page ([here](http://www.example.com/wp-admin/admin.php?page=make-paths-relative-settings)). 

== Frequently Asked Questions ==

= Q. Why should I install this plugin? =
A. Installing this plugin is the easiest way to make the paths(Permalinks + src) relative.

= Q. May i select the paths which i want to be show as relative items? = 
A. Yes, You can select the items you want to be relative.

= Q. May i exclude some items to be shown as absolute? = 
A. Yes, You can exclude the items by using the add_filter (You can find the filter in the Description Area).

== Changelog ==

= 0.5.4 =

  * Fixed PHP Notice

= 0.5.3 =
  
  * Enhancements
    * Added Filter to enable all the settings on plugin activation
    * Added Uninstall hook to remove the plugin settings

= 0.5.2 =
  
  * Fixing Spelling mistake and changing name of class FILE

= 0.5.1 =
  
  * Added Compatibility with Yoast Sitemap

= 0.5 =
  
  * Added feature to Exclude PostTypes

= 0.4.1 =

  * Fixed Responsive images issue

= 0.4 =

  * Fixed Protocol Issue and `//` startings URLs

= 0.3 =

  * Make the Paths Relative of srcset(Responsive Images)

= 0.2.1 =

  * Added Capability to make the Paths relative on Admin Dashboard 

= 0.2 =

  * Optimized the Plugin to provide the better performance and added the filter

= 0.1 =

  * First release on wordpress.org.
