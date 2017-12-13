# Make Paths Relative

## Description 

This plugin can make(convert) the paths(URLs) to relative instead of absolute. This plugin is useful to using the relative URLs. The given below list of permalinks and src can be easily converted to relative:

* Post Permalinks
* Archive Permalinks
* Author Permalinks
* Category Permalinks
* Scripts Paths(src) 
* Styles Paths(src)
* Image Paths(src)

All the above permalinks and src can be converted to relative instead absolute by using this plugin. You can select the options from the plugin settings page. 

### Filter

If you want to exclude some Permalink or src to be relative so, you can use `paths_relative` filter in your theme's functions.php or in your custom plugin.

Your filter may looks like this (Below filter would make the jquery.js Path to absolute):

```
function yasglobal_change_path( $link ) {
  if( $link == '/wp-includes/js/jquery/jquery.js?ver=1.12.4' ) {
    $link = site_url().'/wp-includes/js/jquery/jquery.js?ver=1.12.4';
  }
  return $link;
}
add_filter( 'paths_relative', 'yasglobal_change_path' );
```

If you doesn't want to Make the Paths relative for srcset(Responsive Images) so, just add this line in your theme's functions.php

```
add_filter( 'srcset_paths_relative', '__return_false' );
```

**Note**: Make sure to check the settings Page.

## Installation 

* Upload the `make-paths-relative` folder to the `/wp-content/plugins/` directory or Directly install the plugin through the WordPress plugins screen.
* Activate the Make Paths Relative plugin through the `Plugins` menu in WordPress.
* Configure the plugin by going to the menu `Make Paths Relative` that appears in your admin menu.

## Frequently Asked Questions 

**Q. Why should I install this plugin?**

A. Installing this plugin is the easiest way to make the paths(Permalinks + src) relative.

**Q. May i select the paths which i want to be show as relative items?** 

A. Yes, You can select the items you want to be relative.

**Q. May i exclude some items to be shown as absolute?** 

A. Yes, You can exclude the items by using the add_filter (You can find the filter in the Description Area).
