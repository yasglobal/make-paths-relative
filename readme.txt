=== Make Paths Relative ===
Contributors: sasiddiqui, aliya yasir
Donate link: https://www.paypal.me/yasglobal
Tags: GDPR, URLs, Links, Paths, Relative, permalink, Absolute URLs, Relative URLs, scripts src, styles src, image src, remove_absolute
Requires at least: 3.5
Tested up to: 4.9
Stable tag: 0.6
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Convert Absolute URLs to be relative in your fingertip.

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

=== Thanks for the Support ===

The support from the users that love Make Paths Relative is huge. You can support Make Paths Relative future development and help to make it even better by donating or even giving a 5 star rating with a nice message to me :)

[Donate to Make Paths Relative](https://www.paypal.me/yasglobal)

=== Bug reports ===

Bug reports for Make Paths Relative are [welcomed on GitHub](https://github.com/yasglobal/make-paths-relative). Please note GitHub is not a support forum, and issues that aren't properly qualified as bugs will be closed.

== Installation ==

This process defines you the steps to follow either you are installing through WordPress or Manually from FTP.

**From within WordPress**

1. Visit 'Plugins > Add New'
2. Search for Make Paths Relative
3. Activate Make Paths Relative from your Plugins page.
4. Go to "after activation" below.

**Manually**

1. Upload the `make-paths-relative` folder to the `/wp-content/plugins/` directory
2. Activate Make Paths Relative through the 'Plugins' menu in WordPress
3. Go to "after activation" below.

**After activation**

1. Go to the plugin settings page and set up the plugin for your site.
2. You're done!

== Screenshots ==

* You can select the options from the settings page ([here](http://www.example.com/wp-admin/admin.php?page=make-paths-relative-settings)). 

== Frequently Asked Questions ==

= Q. Why should I install this plugin? =
A. Installing this plugin is the easiest way to make the paths(Permalinks + src) relative.

= Q. May i select the paths which i want to be show as relative items? = 
A. Yes, You can select the items you want to be relative.

= Q. May i exclude some items to be shown as absolute? = 
A. Yes, You can exclude the items by using the add_filter (You can find the filters in the [Description Area](https://wordpress.org/plugins/make-paths-relative/#description-header) ).

== Changelog ==

= 0.6 - May 25, 2018 =

  * Enhancements
    * Added Privacy Policy Section which will be shown in Admin Dashboard for
      WordPress 4.9.6 or higher

  * Bug
    * Fixed redirect issue for media when it is attached to post.

= 0.5.7 - Jan 26, 2018 =

  * Update text domain on about page
